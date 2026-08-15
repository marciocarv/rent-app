<?php
namespace App\Services;

use App\Enums\UnitStatus;
use App\Models\Contract;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class CreateContractService
{
    /**
     * Handle the complex business logic of creating a new lease.
     */
    public function execute(array $data): Contract
    {
        // DB::transaction ensures that if ANY piece of code fails in here,
        // the entire database rolls back to its previous state. No corrupt data!
        return DB::transaction(function () use ($data) {

            // 1. Create the contract
            $contract = Contract::create([
                'unit_id' => $data['unit_id'],
                'tenant_id' => $data['tenant_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'monthly_rent' => $data['monthly_rent'],
                'security_deposit' => $data['security_deposit'],
            ]);

            // 2. Automatically update the Unit to 'Occupied'
            $unit = Unit::findOrFail($data['unit_id']);
            $unit->update([
                'status' => UnitStatus::Occupied
            ]);

            // (Future Feature: We can also automatically generate the first Invoice here!)

            return $contract;
        });
    }
}
