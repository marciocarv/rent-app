<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index()
    {
        // Trazemos os tickets ordenados: Primeiro os "Abertos", depois por data mais antiga
        $tickets = Ticket::with(['tenant', 'unit.property'])
            ->orderByRaw("FIELD(status, 'open', 'in_progress', 'resolved')")
            ->latest()
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => ['required', Rule::enum(TicketStatus::class)],
        ]);

        $ticket->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status do chamado atualizado com sucesso!');
    }
}
