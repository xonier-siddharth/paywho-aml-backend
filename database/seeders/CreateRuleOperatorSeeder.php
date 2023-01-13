<?php

namespace Database\Seeders;

use App\Models\RuleOperator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRuleOperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('monitor_transactions')->insert(
            [
                'communication_number' => 'PW_2020011245454545',
                'paywho_reference_id' => 'abc123',
                'customer_id' => '1',
                'customer_type' => 'INDIVIDUAL',
                'amount' => '500000',
                'financial_flow_direction' => 'OUTGOING',
                'source_county' => 'LT',
                'destination_county' => 'PH',
                'source_currency' => 'EUR',
                'destination_currency' => 'PHP',
                'sender_account_number' => '12345',
                'sender_first_name' => 'siddharth',
                'sender_last_name' => 'pandey',
                'sender_bic' => 'S00277FG',
                'sender_bank_title' => 'Paywho',
                'receiver_account_number' => '54321',
                'receiver_bic' => 'F097HJ0P',
                'receiver_first_name' => 'prince',
                'receiver_last_name' => 'sharma',
                'receiver_bank_title' => 'ABC',
                'payment_mode' => 'CARD',
                'sender_ip_address' => '10.0.128.24:8080',
                'payment_description' => 'this payment is made for testing purpose',
                'risk_score' => 0,
                'payment_status' => 'SUCCESSFUL',
            ]
        );

    }
}
