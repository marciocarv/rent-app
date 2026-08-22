<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Transaction;
use App\Models\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Get filter values from request, defaulting to current month/year
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Apply filters to the query
        $transactions = Transaction::with(['tenant', 'unit.property', 'contract.tenant'])
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->orderBy('due_date', 'asc')
            ->get();

        // Metrics now automatically reflect the selected month!
        $metrics = [
            'pending' => $transactions->where('status', 'pending')->where('type', 'revenue')->where('due_date', '>=', Carbon::today())->sum('amount'),
            'overdue' => $transactions->where('status', 'pending')->where('type', 'revenue')->where('due_date', '<', Carbon::today())->sum('amount'),
            'paid' => $transactions->where('status', 'paid')->where('type', 'revenue')->sum('amount'),
        ];

        // Fetch units for the "Nova Despesa" modal dropdown
        $units = Unit::with('property')->get();

        // Pass $month and $year back to the view so the dropdowns stay selected
        return view('transactions.index', compact('transactions', 'metrics', 'units', 'month', 'year'));
    }

    public function markAsPaid(Transaction $transaction)
    {
        if ($transaction->landlord_id !== auth()->id()) {
            abort(403);
        }

        $transaction->update([
            'status' => 'paid',
            'paid_date' => Carbon::today(),
        ]);

        return back()->with('success', 'Status atualizado com sucesso!');
    }

    public function storeExpense(StoreExpenseRequest $request)
    {
        $validated = $request->validated();

        Transaction::create([
            'landlord_id' => auth()->id(),
            'unit_id' => $validated['unit_id'],
            'type' => 'expense', // Hardcoded as an expense
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'paid_date' => $validated['status'] === 'paid' ? Carbon::today() : null,
        ]);

        return back()->with('success', 'Despesa registrada com sucesso!');
    }
}
