<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Contract;
use App\Models\Property;
use App\Models\Ticket;
use App\Models\Transaction; // <-- Add this
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon; // <-- Add this

class DashboardController extends Controller
{
    public function index()
    {
        $landlordId = auth()->id();

        $propertiesCount = Property::where('landlord_id', $landlordId)->count();
        $unitsCount = Unit::where('landlord_id', $landlordId)->count();
        $tenantsCount = User::where('landlord_id', $landlordId)->where('role', UserRole::Tenant)->count();

        $recentContracts = Contract::where('landlord_id', $landlordId)
            ->with(['tenant', 'unit.property'])
            ->latest()
            ->take(5)
            ->get();

        $openTicketsCount = Ticket::where('landlord_id', $landlordId)
            ->where('status', 'open')
            ->count();

        $recentTickets = Ticket::where('landlord_id', $landlordId)
            ->with(['tenant'])
            ->latest()
            ->take(5)
            ->get();

        // NEW: Calculate Expected Revenue for the current month
        $expectedRevenue = Transaction::where('landlord_id', $landlordId)
            ->where('type', 'revenue')
            ->whereMonth('due_date', Carbon::now()->month)
            ->whereYear('due_date', Carbon::now()->year)
            ->sum('amount');

        return view('dashboard', compact(
            'propertiesCount',
            'unitsCount',
            'tenantsCount',
            'recentContracts',
            'openTicketsCount',
            'recentTickets',
            'expectedRevenue' // <-- Pass it to the view
        ));
    }
}
