<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreTenantRequest;
use App\Models\User;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\TicketPriority;
use App\Models\Ticket;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function index()
    {
        // Security: Only fetch tenants belonging to THIS landlord
        $tenants = User::where('role', UserRole::Tenant)
                       ->where('landlord_id', auth()->id())
                       ->latest()
                       ->get();

        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function store(StoreTenantRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'),
            'role' => UserRole::Tenant,
            'landlord_id' => auth()->id(),
            // Novos campos:
            'phone' => $request->phone,
            'document_number' => $request->document_number,
            'rg' => $request->rg,
            'nationality' => $request->nationality,
            'profession' => $request->profession,
            'address' => $request->address,
            'marital_status' => $request->marital_status,
            'spouse_name' => $request->spouse_name,
            'spouse_document' => $request->spouse_document,
        ]);

        return redirect()->route('tenants.index')
                         ->with('success', 'Inquilino cadastrado com sucesso!');
    }

    public function destroy(User $tenant)
    {
        // Extra Security: Ensure the landlord deleting the tenant actually owns this tenant
        if ($tenant->landlord_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $tenant->delete();

        return redirect()->route('tenants.index')
                         ->with('success', 'Inquilino excluído com sucesso!');
    }

    public function dashboard()
    {
        $user = auth()->user();

        $contract = Contract::withoutGlobalScopes()
            ->with([
                'unit' => fn ($query) => $query->withoutGlobalScopes()->with('property'),
                'landlord',
            ])
            ->where('tenant_id', $user->id)
            ->first();

        $tickets = Ticket::withoutGlobalScopes()
            ->where('tenant_id', $user->id)
            ->latest()
            ->get();

        return view('tenants.dashboard', compact('contract', 'tickets'));
    }

    public function storeTicket(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
        ]);

        // Find the active contract to auto-link the unit and landlord
        $contract = Contract::where('tenant_id', auth()->id())
            ->where('status', 'active')
            ->firstOrFail();

        Ticket::create([
            'tenant_id' => auth()->id(),
            'landlord_id' => $contract->landlord_id,
            'unit_id' => $contract->unit_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open', // Always starts as open
        ]);

        return back()->with('success', 'Chamado de manutenção aberto com sucesso! Seu locador foi notificado.');
    }
}
