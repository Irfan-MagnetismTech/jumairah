<?php

namespace App\Services;

use App\Project;
use App\SalesCollectionDetails;
use App\Sells\InstallmentList;
use Illuminate\Http\Request;

class RevenueInflowService
{

    /**
     * @param model $model
     * @param string $prefix
     * @param columnName $column
     * @param columnValue $columnValue
     * @return string - unique id
     *
     * this function is used to generate unique id for any model
     */
    public function handleRevenueInflow(Request $request)
    {
        $projects = Project::with(
            'sells.sellClient.client:id,name',
            'sells.apartment:id,name,project_id',
            'sells.currentInstallment.installmentCollections',
            'sells.installmentList.salesCollectionsDetails',
            'sells.currMonthSalesCollections',
            'sells.maturedInstallments.installmentCollections'
        )
            ->when(request()->project_id, function ($q)
        {
                $q->where('id', request()->project_id);
            })
            ->whereHas('sells.currentInstallment')
            ->with('sells', function ($q)
        {
                $q->whereDoesntHave('saleCancellation')->whereHas('currentInstallment');
            })
            ->get();

        // $clients = [];

        $clients = collect();

        foreach ($projects as $projectKey => $project)
        {
            foreach ($project->sells as $sellKey => $sell)
            {
                $maturedInstallments      = $sell->maturedInstallments;                
                $maturedInstallmentsPaids = $sell->maturedInstallments->pluck('installmentCollections')->flatten();
                $overDueAmount            = $maturedInstallments->sum('installment_amount') - $maturedInstallmentsPaids->sum('amount');

                $currInstAmount         = $sell->currentInstallment->installment_amount;
                $currInstPrevPaidAmount = $sell->currentInstallment->installmentCollections->sum('amount');
                $currInstDueAmount      = $currInstAmount > $currInstPrevPaidAmount ? $currInstAmount - $currInstPrevPaidAmount : 0.00;

                $totalDue                = $overDueAmount + $currInstDueAmount;
                $currMonthReceivedAmount = $sell->currMonthSalesCollections->sum('received_amount');
                $balance                 = $totalDue - $currMonthReceivedAmount;

                $clientData = [
                    'project_id'                 => $project->id,
                    'sell_id'                    => $sell->id,
                    'project_name'               => $project->name,
                    'client_name'                => $sell->sellClient->client->name,
                    'apartment_name'             => $sell->apartment->name,
                    'curr_inst_no'               => $sell->currentInstallment->installment_no ?? '--',
                    'curr_inst_amount'           => $currInstAmount,
                    'curr_inst_prev_paid_amount' => $currInstPrevPaidAmount,
                    'curr_inst_date'             => $sell->currentInstallment->installment_date,
                    'curr_inst_due'              => $currInstDueAmount,
                    'over_due'                   => $overDueAmount,
                    'total_due'                  => $totalDue,
                    'curr_month_received_amount' => $currMonthReceivedAmount,
                    'balance_amount'             => $balance > 0 ? $balance : 0.00,
                ];

                $clients->push((object) $clientData);
            }
        };

        $projectInfo['clients']                        = $clients;
        $projectInfo['ttl_curr_inst_amount']           = $clients->sum('curr_inst_amount');
        $projectInfo['ttl_curr_inst_prev_paid']        = $clients->sum('curr_inst_prev_paid_amount');
        $projectInfo['ttl_curr_inst_due']              = $clients->sum('curr_inst_due');
        $projectInfo['ttl_curr_over_due']              = $clients->sum('over_due');
        $projectInfo['ttl_curr_total_due']             = $clients->sum('total_due');
        $projectInfo['ttl_curr_month_received_amount'] = $clients->sum('curr_month_received_amount');
        $projectInfo['balance_amount']                 = $clients->sum('balance_amount');

        return $projectInfo;
    }

}
