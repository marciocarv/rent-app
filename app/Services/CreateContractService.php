<?php
namespace App\Services;

use App\Enums\UnitStatus;
use App\Models\Contract;
use App\Models\Transaction;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateContractService
{
    public function execute(array $data): Contract
    {
        return DB::transaction(function () use ($data) {

            // 1. Create the contract
            $contract = Contract::create([
                'unit_id' => $data['unit_id'],
                'tenant_id' => $data['tenant_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'monthly_rent' => $data['monthly_rent'],
                'security_deposit' => $data['security_deposit'],
                'due_day' => $data['due_day'],
                'payment_method' => $data['payment_method'],
                'landlord_id' => auth()->id(),
            ]);

            // 2. Automatically update the Unit to 'Occupied'
            $unit = Unit::findOrFail($data['unit_id']);
            $unit->update([
                'status' => UnitStatus::Occupied
            ]);

            // 3. FINANCIAL ENGINE: Auto-generate the Rent Transactions (Faturas)
            $this->generateRentInvoices($contract);

            return $contract;
        });
    }

    /**
     * Loops through the contract duration and generates pending transactions.
     */
    private function generateRentInvoices(Contract $contract): void
    {
        $startDate = Carbon::parse($contract->start_date);
        $endDate = Carbon::parse($contract->end_date);

        // Cast to integer to satisfy Carbon's strict type requirement
        $dueDay = (int) $contract->due_day;

        $currentDate = $startDate->copy();

        // Bulletproof array for Portuguese months
        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        // Loop month by month until we reach the end date
        while ($currentDate->lessThanOrEqualTo($endDate)) {

            // Set the due date for the current month loop
            $dueDate = $currentDate->copy()->setDay($dueDay);

            // Get the month number (1-12) to match our array, and the 4-digit year
            $monthNumber = $dueDate->format('n');
            $year = $dueDate->format('Y');

            // Create the pending transaction
            Transaction::create([
                'landlord_id' => $contract->landlord_id,
                'unit_id'     => $contract->unit_id,
                'contract_id' => $contract->id,
                'tenant_id'   => $contract->tenant_id,
                'type'        => 'revenue',
                // Assemble the string manually: "Aluguel - Janeiro/2024"
                'description' => 'Aluguel - ' . $meses[$monthNumber] . '/' . $year,
                'amount'      => $contract->monthly_rent,
                'due_date'    => $dueDate,
                'status'      => 'pending',
            ]);

            // Move to the next month
            $currentDate->addMonth();
        }
    }
}
