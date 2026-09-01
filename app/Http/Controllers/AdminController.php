<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\PlanTier;

class AdminController extends Controller
{
    public function index()
    {
        // Contagem de usuários separada por tipo
        $totalLandlords = User::where('role', 'landlord')->count();
        $totalTenants = User::where('role', 'tenant')->count();

        // Contagem de assinaturas apenas para proprietários
        $premiumUsers = User::where('role', 'landlord')->where('plan_tier', 'premium')->count();
        $basicUsers = User::where('role', 'landlord')->where('plan_tier', 'basic')->count();
        $freeUsers = User::where('role', 'landlord')->where('plan_tier', 'free')->count();

        // Cálculo da Receita Mensal Recorrente (MRR)
        $mrr = ($premiumUsers * 19.99) + ($basicUsers * 9.99);

        // Busca apenas os proprietários para a tabela de gerenciamento (exclui admins e inquilinos)
        $users = User::where('role', 'landlord')->latest()->paginate(20);

        return view('admin.index', compact(
            'totalLandlords',
            'totalTenants',
            'premiumUsers',
            'basicUsers',
            'freeUsers',
            'mrr',
            'users'
        ));
    }

    // NEW: Method to manually change a user's plan
    public function updateUserPlan(Request $request, User $user)
    {
        $request->validate([
            'plan_tier' => ['required', 'string', 'in:free,basic,premium'],
        ]);

        $user->update([
            'plan_tier' => $request->plan_tier,
        ]);

        return back()->with('success', "Plano de {$user->name} alterado para " . strtoupper($request->plan_tier) . " com sucesso.");
    }
}
