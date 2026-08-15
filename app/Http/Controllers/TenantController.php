<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreTenantRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            // Generate a random password. If we ever build a tenant login portal,
            // they can use a "Forgot Password" flow to set their own.
            'password' => bcrypt(Str::random(16)),
            'role' => UserRole::Tenant,
            'landlord_id' => auth()->id(), // Assign to the current landlord
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
}
