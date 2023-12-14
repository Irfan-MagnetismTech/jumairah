<?php

namespace App\Http\Controllers\Sells;

use App\CollectionYearlyBudgetDetails;
use App\CSD\CsdFinalCostingDemand;
use App\CSD\CsdFinalCostingRefund;
use App\Http\Controllers\Controller;
use App\Project;
use App\SalesCollection;
use App\SalesCollectionDetails;
use App\SellCollectionHead;
use App\Sells\Apartment;
use App\Sells\CollectionYearlyBudget;
use App\Sells\InstallmentList;
use App\Sells\SalesYearlyBudget;
use App\Sells\SalesYearlyBudgetDetail;
use App\Sells\Sell;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use App\Team;
use App\Sells\Leadgeneration;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryWiseLeadGenerationExport;
use App\Services\RevenueInflowService;

class SellsReportController extends Controller
{
    public function projectsreport(Request $request)
    {
        $reportType = $request->reportType;
        $project_id = $request->project_id;
        $current_status = $request->status;
        $status = ['All', 'Upcoming', 'Ongoing', 'Ready'];

        $projects = Project::with('apartments.sell', 'sells', 'unsoldApartments', 'costCenter')
            ->withSum('apartments', 'total_value')
            ->withSum('unsoldApartments', 'total_value')
            ->withSum('sells as total_sold_value', 'total_value')
            ->with(['sells' => function ($q) {
                return $q->withSum('salesCollections', 'received_amount');
            }])
            ->withCount(['apartments' => function ($q) {
                $q->where('owner', 1);
            }])
            ->withCount('sells')
            ->with(['costCenter' => function ($query) {
                $query->withSum('ledgers', 'dr_amount')
                    ->with(['ledgers.account' => function ($q) {
                        $q->where('balance_and_income_line_id', 14);
                    }]);
            }])
            ->when($current_status && $current_status != "All", function ($q) use ($current_status) {
                if ($current_status == "Ready") {
                    return $q->whereNotNull('handover_date');
                } elseif ($current_status == "Ongoing") {
                    return $q->whereNull('handover_date');
                } else {
                    return $q->whereNull('innogration_date');
                }
            })
            ->when($project_id, function ($q) use ($project_id) {
                $q->where('id', $project_id);
            })
            ->get();
        //return response()->json($projects);
        // dd($projects);

        if ($reportType == 'pdf') {
            return PDF::loadview('sales.projects.projectsreportpdf', compact('projects', 'status', 'current_status'))
                ->setPaper(array(0, 0, 612, 1200), 'landscape')->stream('projects_report.pdf');
        } else {
            return view('sales.projects.projectsreport', compact('projects', 'status', 'current_status'));
        }
    }

    public function projectreport(Request $request)
    {
        $reportType = $request->reportType;
        $project_name = $request->project_name;
        $project_id = $request->project_id;
        $dateType = $request->dateType;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : null;
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : null;

        $sells = Sell::with('sellClient.client', 'apartment.project', 'salesCollections')
            ->when($project_id, function ($q) use ($project_id) {
                $q->whereHas('apartment.project', function ($q) use ($project_id) {
                    $q->where('project_id', $project_id);
                });
            })
            ->orderBy('sell_date', 'desc')
            ->withSum('salesCollections as totalCollectedAmount', 'received_amount')

            ->when($dateType, function ($q) use ($dateType, $fromDate, $tillDate) {
                return $q->dateRange('sell_date', $dateType, $fromDate, $tillDate);
            })
            ->get();

        //    return $sells;

        if ($reportType == 'pdf') {
            return  PDF::loadview('sales.projects.projectreportpdf', compact('sells'))->setPaper('a4', 'landscape')->stream('projectreport.pdf');
        } else {
            return  view('sales.projects.projectreport', compact('sells', 'project_id', 'project_name', 'project_id', 'dateType', 'fromDate', 'tillDate'));
        }
    }

    public function collectionsreport(Request $request)
    {
        //        dd($request->all());
        $paymentModes = ['Cash' => 'Cash', 'Cheque' => 'Cheque', 'Pay Order' => 'Pay Order', 'DD' => 'DD', 'TT' => 'TT', 'Online Bank Transfer' => 'Online Bank Transfer', 'Adjustment' => 'Adjustment',];
        $paymentTypes = SellCollectionHead::pluck('name', 'name');

        $dateType = $request->dateType;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : null;
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : null;

        //        dd($request->all());
        $salesCollections = SalesCollection::with('salesCollectionDetails', 'sell.apartment.project', 'sell.sellClient.client')->withSum('salesCollectionDetails', 'amount')
            ->when($request->project_id, function ($q) {
                $q->whereHas('sell.apartment', function ($q) {
                    $q->where('project_id', request()->project_id);
                });
            })
            ->when($request->payment_mode && $request->payment_mode != "All", function ($q) {
                $q->where('payment_mode', request()->payment_mode);
            })
            ->when($request->payment_type && $request->payment_type != "All", function ($q) {
                $q->whereHas('salesCollectionDetails', function ($q) {
                    $q->where('particular', request()->payment_type);
                });
            })
            ->when(!$dateType || $dateType === 'today', function ($q) {
                $q->whereDate('received_date', now());
            })
            ->when($dateType === 'weekly', function ($q) {
                $q->whereBetween('received_date', [now()->subDays(7), now()]);
            })
            ->when($dateType === 'monthly', function ($q) {
                $q->whereBetween('received_date', [now()->subDays(30), now()]);
            })
            ->when($dateType === 'custom', function ($q) use ($fromDate, $tillDate) {
                $q->whereBetween('received_date', [$fromDate, $tillDate]);
            })
            ->get();

        //        dd($request->all(), $salesCollections->toArray());

        if ($request->reportType == 'pdf') {
            return  PDF::loadview('sales.projects.collectionsreportpdf', compact('salesCollections', 'dateType', 'fromDate', 'tillDate'))->setPaper('a4', 'landscape')->stream('collectionsreport.pdf');
        } else {
            return  view('sales.projects.collectionsreport', compact('salesCollections', 'paymentTypes', 'paymentModes', 'request', 'dateType', 'fromDate', 'tillDate'));
        }
    }

    public function clientcollectionreport(Request $request)
    {
        $client = $request->sell_id ?? null;
        $clients = [];
        $clientCollections = SalesCollection::with('salesCollectionDetails.installment', 'sell.sellClient.client', 'sell.apartment')
            ->withSum('salesCollectionDetails', 'amount')
            ->withSum('salesCollectionDetails', 'applied_amount')
            ->where('sell_id', $request->sell_id)->get();
        if ($request->reportType == 'pdf') {
            return  PDF::loadview('sales.projects.clientcollectionreportpdf', compact('clientCollections', 'clients'))
                ->stream('clientcollectionreportpdf.pdf');
        } else {
            return  view('sales.projects.clientcollectionreport', compact('clientCollections', 'clients', 'client', 'request'));
        }
    }

    public function revenueinflowreport(Request $request)
    {
        $projects = (new RevenueInflowService)->handleRevenueInflow($request); 
        // return $projects; 

        if ($request->reportType == 'pdf') {
            return PDF::loadview('sales.projects.revenueinflowreportpdf', compact('request', 'projects'))
                ->setPaper('legal', 'landscape')->stream('clientcollectionreportpdf.pdf');
        } else {
            return view('sales.projects.revenueinflowreport', compact('request', 'projects'));
        }
    }

    public function yearlycollectionreport(Request $request)
    {
        $year = $request->year ? Carbon::createFromFormat('Y', $request->year) : now();

        $upComings = CollectionYearlyBudgetDetails::whereHas('collectionYearlyBudget', function ($q) use ($year) {
            $q->where('year', $year);
        })->orderBy('month')->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->month)->format('F');
            })
            ->map(function ($item) {
                return $item->sum('collection_amount');
            });

        $installments = InstallmentList::whereYear('installment_date', $year)
            ->orderBy('installment_date')->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->installment_date)->format('F');
            })->map(function ($item) {
                return $item->sum('installment_amount');
            });
        $bookingMoneys = Sell::whereYear('booking_money_date', $year)
            ->orderBy('booking_money_date')
            ->get()
            ->sortBy('booking_money_date')
            ->groupBy(function ($val) {
                return Carbon::parse($val->downpayment)->format('F');
            })->map(function ($item) {
                return $item->sum('booking_money');
            });
        $downPayments = Sell::whereYear('downpayment_date', $year)
            ->orderBy('downpayment_date')
            ->get()
            ->sortBy('booking_money_date')
            ->groupBy(function ($val) {
                return Carbon::parse($val->downpayment)->format('F');
            })->map(function ($item) {
                return $item->sum('downpayment');
            });

        $saleCollections = SalesCollection::whereYear('received_date', $year)
            ->orderBy('received_date')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->received_date)->format('F');
            })->map(function ($item) {
                return $item->sum('received_amount');
            });

        if ($request->reportType == 'pdf') {
            return PDF::loadview('sales.projects.yearlycollectionreportpdf', compact('request', 'upComings', 'installments', 'saleCollections', 'bookingMoneys', 'downPayments'))->stream('yearlycollectionreportpdf.pdf');
        } else {
            return view('sales.projects.yearlycollectionreport', compact('request', 'upComings', 'installments', 'saleCollections', 'bookingMoneys', 'downPayments'));
        }
    }

    public function monthlyprojectsreport()
    {
        return  PDF::loadview('sales.projects.monthlyprojectsreportpdf')->stream('anyname__according_to_taks.pdf');
    }


    public function finalsettlementreport(Request $request)
    {
        $client = $request->sell_id ?? null;
        $clients = [];
        $sell = Sell::with('salesCollections.salesCollectionDetails', 'installmentList', 'apartment.project', 'sellClients.client')
            ->where('id', $client)->first();
        if ($sell) {
            $csd_final_costing_demand = CsdFinalCostingDemand::whereHas('csdFinalCosting', function ($q) use ($sell) {
                $q->where('apartment_id', $sell->apartment_id)->where('sell_id', $sell->id);
            })->get();
            $csd_final_costing_refund = CsdFinalCostingRefund::whereHas('csdFinalCosting', function ($q) use ($sell) {
                $q->where('apartment_id', $sell->apartment_id)->where('sell_id', $sell->id);
            })->get();
            $rentalComponcetion = Carbon::parse($sell->hand_over_date)->addMonth($sell->ho_grace_period)->format('d-m-Y');
            if ($rentalComponcetion < date('d-m-Y', strtotime(now()))) {
                $totalrentalComponcetion = $sell->apartment->apartment_size * $sell->rental_compensation;
            } else {
                $totalrentalComponcetion = 0;
            }
            $saleClients = $sell->sellClients()->where('stage', $sell->sellClient->stage)->get();
        }
        if (!empty($sell)) {
            return PDF::loadview('sales.projects.finalsettlementreportpdf', compact(
                'request',
                'clients',
                'sell',
                'csd_final_costing_demand',
                'csd_final_costing_refund',
                'totalrentalComponcetion',
                'saleClients'
            ))->stream('finalSettlementreportpdf.pdf');
        } else {
            return view('sales.projects.finalsettlementreport', compact('request', 'clients'));
        }
    }


    public function salesinvoice(Sell $sell, $notifyThrough)
    {
        $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        //        $inwords = 'Taka '. Str::title($spell->format($salesCollection->received_amount)).' Only.';
        $paidValue =  SalesCollectionDetails::whereHas('salesCollection', function ($q) use ($sell) {
            $q->where('sell_id', $sell->id);
        })->whereIn('particular', ['Booking Money', 'Down Payment', 'Installment'])
            ->sum('amount');

        $delayChargePaid = SalesCollectionDetails::whereHas('salesCollection', function ($q) use ($sell) {
            $q->where('sell_id', $sell->id);
        })->where('particular', 'Delay Charge')->sum('amount');
        $delayCharge = $sell->salesCollections->pluck('salesCollectionDetails')->flatten()->sum('applied_amount') - $delayChargePaid;

        $bookingSchedule = Sell::where('id', $sell->id)->whereDate('downpayment_date', '>=', date('Y-m-d', strtotime(now())))->first();
        $downPaymentSchedule = Sell::where('id', $sell->id)->whereDate('downpayment_date', '>=', date('Y-m-d', strtotime(now())))->first();
        return  PDF::loadview('sales.projects.salesinvoicepdf', compact('sell', 'delayCharge', 'spell', 'paidValue', 'bookingSchedule', 'downPaymentSchedule'))->stream('salesinvoicepdf_' . $sell->id . now() . '.pdf');
    }

    public function clientpaymenthistory($sell_id)
    {
        $sell = Sell::with('client:id,name', 'apartment', 'salesCollections.salesCollectionDetails')->where('id', $sell_id)->firstOrFail();
        return  view('sells.clientpaymenthistory', compact('sell'));
    }

    public function inventoryreport(Request $request)
    {
        //dd($request->all());
        $reportType = $request->reportType;
        $project_id = $request->project_id;
        $current_category = $request->category;
        $current_status = $request->status;
        $status = ['All', 'Upcoming', 'Ongoing', 'Ready'];
        $categories = ['All', 'Residential', 'Commercial', 'Residential cum Commercial'];
        $projects = Project::withCount(['apartments' => function ($q) {
            $q->where('owner', 1);
        }])
            ->withCount('unsoldApartments')
            ->withSum('unsoldApartments', 'apartment_size')
            ->withAvg('unsoldApartments', 'apartment_rate')
            ->withSum('unsoldApartments', 'parking_price')
            ->withSum('unsoldApartments', 'utility_fees')

            ->when(!empty($project_id) && $current_status && $current_status != "All", function ($q) use ($current_status) {
                if ($current_status == "Upcoming") {
                    return $q->whereNull('innogration_date');
                }
                if ($current_status == "Ongoing") {
                    return $q->whereNull('handover_date')->whereNotNull('innogration_date');
                } else {
                    return $q->whereNull('handover_date');
                }
            })
            ->when($current_category && $current_category != "All", function ($q) use ($current_category) {
                if ($current_category == "Residential") {
                    return $q->whereCategory('Residential');
                }
                if ($current_category == "Commercial") {
                    return $q->whereCategory('Commercial');
                } else {
                    return $q->whereCategory('Residential cum Commercial');
                }
            })
            ->when(!empty($project_id), function ($q) use ($project_id) {
                $q->where('id', $project_id);
            })
            ->get()
            ->map(function ($item) {
                $item['total_parking_utility'] = ($item->unsold_apartments_sum_parking_price + $item->unsold_apartments_sum_utility_fees);
                $item['total_estimated_value'] = ($item->unsold_apartments_sum_apartment_size * $item->unsold_apartments_avg_apartment_rate) + $item->total_parking_utility;
                return $item;
            });
        //        dd($projects->toArray());

        if ($reportType == 'pdf') {
            return  PDF::loadview('sales.projects.projectsinventoryreportpdf', compact('projects', 'status', 'current_status', 'categories', 'current_category'))
                ->stream('projects_inventory_report' . now()->format('d-m-Y') . '.pdf');
        } else {
            return  view('sales.projects.projectsinventoryreport', compact('projects', 'status', 'current_status', 'categories', 'current_category'));
        }
        //        return  PDF::loadview('projects.inventoryreportpdf')->stream('anyname__according_to_taks.pdf');
    }

    public function yearlySalesPlan(Request $request)
    {
        $year = $request->year ? date('Y', strtotime($request->year)) : date('Y', strtotime(now()));
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $budgets = SalesYearlyBudgetDetail::whereHas('salesYearlyBudget', function ($q) use ($year) {
            $q->where('year', $year);
        })->get()->groupBy('salesYearlyBudget.project_id')
            ->map(function ($item, $key) use ($months, $year) {
                $array = array();
                $monthlyTotal = 0;
                foreach ($months as $month) {
                    $detailsData = SalesYearlyBudgetDetail::whereHas('salesYearlyBudget', function ($q) use ($key) {
                        $q->where('project_id', $key);
                    })->where('month', "$year-$month")->first();
                    $collectionData = CollectionYearlyBudgetDetails::whereHas('collectionYearlyBudget', function ($q) use ($key) {
                        $q->where('project_id', $key);
                    })->where('month', "$year-$month")->first();

                    $array[] = [
                        "sales_value" => $detailsData->sales_value ?? 0,
                        "new_collection" => $collectionData->collection_amount ?? 0,
                        "bm" => $detailsData->booking_money ?? 0
                    ];
                }
                $project = Project::where('id', $key)->first();
                $allApartments = count($project->apartments);
                $soldApartments =  count($project->apartments->pluck('sell')->filter());
                return [
                    'projects' => $project->name,
                    'hand_over' => $project->handover_date,
                    'unsold' => $allApartments - $soldApartments,
                    'yearlyBudgets' => $array
                ];
            });


        $oldProjects = InstallmentList::get()->groupBy('sell.apartment.project_id')
            ->map(function ($olditems, $key) use ($months, $year) {
                $oldProjectsArray = [];
                $monthlyTotal = 0;
                foreach ($months as $month) {
                    $installments = InstallmentList::whereHas('sell.apartment', function ($q) use ($key, $year, $month) {
                        $q->where('project_id', $key);
                    })->whereMonth('installment_date', "$year-$month")->sum('installment_amount');
                    $oldProjectsArray[] = [
                        "new_collection" => $installments ?? 0,
                    ];
                }
            });
        // $project = Project::where('id',$key)->first();


        // dd($oldProjects);

        $budgets = SalesYearlyBudgetDetail::whereHas('salesYearlyBudget', function ($q) use($year){
            $q->where('year',$year);
        })->get()->groupBy('sales_yearly_budget_id')
        ->map(function ($item, $key) use($months, $year){
            $array = array();
            $monthlyTotal = 0;
            foreach ($months as $month){
                $detailsData = SalesYearlyBudgetDetail::where('sales_yearly_budget_id', $key)->where('month',"$year-$month")->first();
                $array[] = [
                    "sales_value" => $detailsData->sales_value ?? 0,
                    "bm" => $detailsData->booking_money ?? 0
                ];
            }
            $project = Project::where('id',$key)->first();
            $allApartments = count($project->apartments);
            $soldApartments =  count($project->apartments->pluck('sell')->filter());
            return [
                'projects' => $project->name,
                'hand_over' => $project->handover_date,
                'unsold' => $allApartments - $soldApartments,
                'yearlyBudgets' => $array
            ];
        });
        $monthWiseTotals = SalesYearlyBudgetDetail::whereHas('salesYearlyBudget', function ($q) use($year){
            $q->where('year',$year);
        })->get()->groupBy(function($item){
            return substr($item['month'],5, 2);
        })->map(function($item){
            return [
                'total_sales_value' => $item->sum('sales_value'),
                'total_bm' => $item->sum('booking_money'),
            ];
        });
        if ($request->reportType == 'pdf') {
            return PDF::loadview('sales.projects.yearlySalesPlanpdf', compact('request', 'year', 'budgets', 'months', 'monthWiseTotals'))
                ->setPaper('a4', 'landscape')->stream('yearlySalesReport.pdf');
        } else {
            return view('sales.projects.yearlySalesPlanReport', compact('request', 'year', 'budgets', 'months', 'monthWiseTotals'));
        }
    }

    public function yearlyCollectionPlan(Request $request)
    {
        $year = !empty($request->year) ? $request->year : date('Y', strtotime(now()));
        $previousYear = $year - 1;
        $yearFirstDay = "$year-01-01";
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        //         $collectionProjectIdArray = CollectionYearlyBudget::where('year', $year)->pluck('project_id','project_id');
        //         $existsProjectIdArray = InstallmentList::whereYear('installment_date',$year)->get()->pluck('sell.apartment.project_id','sell.apartment.project_id');
        //         dd($collectionProjectIdArray, $existsProjectIdArray);

        $totalCollection = [];
        $totalBookingMoney = [];
        $totalApproximateCollection = [];

        $totalBmCollection = [];
        $totalNewProjcetCollection = [];
        $totalExistingProjcetCollection = [];

        foreach ($months as $key => $month) {
            $existsTotalCollection = InstallmentList::whereMonth('installment_date', $month)
                ->whereYear('installment_date', $year)
                ->whereHas(
                    'sell',
                    function ($q) use ($yearFirstDay) {
                        $q->where('sell_date', '<', $yearFirstDay);
                    }
                )
                ->get();
            $totalCollection["$year-$month"] = $existsTotalCollection->sum('installment_amount');

            $bookingData = SalesYearlyBudgetDetail::where('month', "$year-$month")->get();
            $totalBookingMoney["$year-$month"] = $bookingData->sum('booking_money');

            $approximateCollectionData = CollectionYearlyBudgetDetails::where('month', "$year-$month")->get();
            $totalApproximateCollection["$year-$month"] = $approximateCollectionData->sum('collection_amount');

            $bmCollection = SalesCollectionDetails::wherehas('salesCollection', function ($q) use ($year, $month, $yearFirstDay) {
                $q->where('particular', 'Booking Money')->whereYear('received_date', $year)->whereMonth('received_date', $month)
                    ->whereRelation('sell', 'sell_date', '<', $yearFirstDay);
            })->get();
            $totalBmCollection["$year-$month"] = $bmCollection->sum('amount');

            $newProjectCollection = SalesCollectionDetails::wherehas('salesCollection', function ($q) use ($year, $month, $yearFirstDay) {
                $q->where('particular', '!=', 'Booking Money')->whereYear('received_date', $year)->whereMonth('received_date', $month)
                    ->whereRelation('sell', 'sell_date', '>=', $yearFirstDay);
            })->get();
            $totalNewProjcetCollection["$year-$month"] = $newProjectCollection->sum('amount');

            $existingProjectCollection = SalesCollectionDetails::wherehas('salesCollection', function ($q) use ($year, $month, $yearFirstDay) {
                $q->where('particular', '!=', 'Booking Money')->whereYear('received_date', $year)->whereMonth('received_date', $month)
                    ->whereRelation('sell', 'sell_date', '<', $yearFirstDay);
            })->get();
            $totalExistingProjcetCollection["$year-$month"] = $existingProjectCollection->sum('amount');
        }

        $projects = Project::with(['sells.installmentList' => function ($q) use ($year, $yearFirstDay) {
            $q->whereYear('installment_date', $year)
                // ->whereRelation('sell', 'sell_date', '<', $yearFirstDay);
                ->whereHas(
                    'sell',
                    function ($q) use ($yearFirstDay) {
                        $q->where('sell_date', '<', $yearFirstDay);
                    }
                );
        }])
            ->with(['collectionYearlyBudget' => function ($q) use ($year) {
                $q->with('collectionYearlyBudgetDetails')->where('year', $year);
            }])->with(['salesYearlyBudget' => function ($q) use ($year) {
                $q->with('salesYearlyBudgetDetails')->where('year', $year);
            }])
            ->get(['id', 'name'])
            ->map(function ($items) use ($months, $year) {
                $existsCollection = [];
                $newCollection = [];
                $bookingMoney = [];

                $installmentAmountMonthWise = $items->sells->pluck('installmentList')->flatten()->groupBy(function ($q) {
                    return Carbon::parse($q->installment_date)->format('Y-m');
                })->map(function ($item, $key) use (&$existsCollection) {
                    return $existsCollection[$key] = $item->sum('installment_amount');
                });

                $approximateAmountMonthWise = $items->collectionYearlyBudget->pluck('collectionYearlyBudgetDetails')->flatten()
                    ->pluck('collection_amount', 'month');

                $bookingMoneyMonthWise = $items->salesYearlyBudget->pluck('salesYearlyBudgetDetails')->flatten()
                    ->pluck('booking_money', 'month');

                $data['project'] = $items->name;
                $data['exitingCollection'] = $installmentAmountMonthWise->toArray();
                $data['approximateCollection'] = $approximateAmountMonthWise->toArray();
                $data['bookingMoney'] = $bookingMoneyMonthWise->toArray();

                // dump($items->sells->pluck('installmentList')->toArray());
                return $data;
            });
        // dd();
        // return $projects;

        if ($request->reportType == 'pdf') {
            return PDF::loadview(
                'sales.projects.yearlyRevenuePlanpdf',
                compact('request', 'year', 'months', 'projects', 'totalCollection', 'totalBookingMoney', 'totalBmCollection', 'totalNewProjcetCollection', 'totalExistingProjcetCollection', 'totalApproximateCollection')
            )
                ->setPaper('a4', 'landscape')->stream('yearlyRevenuePlan.pdf');
        } else {
            return view('sales.projects.yearlyRevenuePlan', compact('request', 'year', 'months', 'projects', 'totalCollection', 'totalBookingMoney', 'totalBmCollection', 'totalNewProjcetCollection', 'totalExistingProjcetCollection', 'totalApproximateCollection'));
        }
    }

    public function monthlySalesReport(Request $request)
    {
        $sales = [];
        if ($request->month) {
            $startOfMonth = Carbon::parse($request->month)->startOfMonth();
            $endOfMonth = Carbon::parse($request->month)->endOfMonth();

            $sales = Sell::with('sellClient.client', 'user.member.team.user', 'apartment.project')
                ->when($startOfMonth && $endOfMonth, function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->whereBetween('sell_date', [$startOfMonth, $endOfMonth]);
                })->get();
        }

        if ($request->reportType == 'pdf') {
            return PDF::loadview('sales.sales-report.monthly-sales-reportpdf', compact('request', 'sales'))
                ->setPaper('a4', 'landscape')
                ->stream('monthly-sales-reportpdf.pdf');
        } else {
            return view('sales.sales-report.monthly-sales-report', compact('request', 'sales'));
        }
    }

    public function collectionForecast(Request $request)
    {
        $sales = [];

        if ($request->month) {
            $fromDate = Carbon::parse($request->month)->startOfDay();
            $tillDate = Carbon::parse($request->month)->endOfDay();

            $fromDate = Carbon::parse("2021-01-01");
            $tillDate = Carbon::parse("2022-12-30");

            $projects = Project::with('apartments')
                ->with(['sells' => function ($sell) use ($fromDate, $tillDate) {
                    $sell->with('sellClient.client')
                        ->with(['installmentList' => function ($installment) use ($fromDate, $tillDate) {
                            $installment->with('installmentCollections')->whereBetween('installment_date', [$fromDate, $tillDate]);
                        }]);
                }])
                ->whereHas('sells')
                ->get();

            $forecasts = $projects->map(function ($project) use ($fromDate, $tillDate) {
                // $customerInfo = [];
                // $customerInfo['customer_name'] = $project->apartment->name;
                // $customerInfo['customer_name'] = $project->apartment->name;

                $projectSells   =   $project->sells();
                $bookingMoney   =   $projectSells->with('bookingMoneyCollections')->whereBetween('booking_money_date', [$fromDate, $tillDate])->get();
                $downPayment    =   $projectSells->with('downpaymentCollections')->whereBetween('downpayment_date', [$fromDate, $tillDate])->get();
                // dd($bookingMoney->first()->apartment);
                $amount = $bookingMoney->sum('booking_money') + $bookingMoney->sum('downpayment');
                $paid = $bookingMoney->pluck('bookingMoneyCollections')->flatten()->sum('amount') + $bookingMoney->pluck('downpaymentCollections')->flatten()->sum('amount');
                return $balance = $amount - $paid;



                // return $sellsInfo;
            });

            return $forecasts->first();
            return $projects->first()->sells;
            return $projects->first()->sells->pluck('installmentList');

            $projectsForecast =  $projects->map(function ($project) {
                $project->sells->map(function ($sell) {
                    $totalValue = $sell->total_value;
                    $collected  = $sell->salesCollections->sum('received_amount');
                    $balance  = $totalValue - $collected;
                    dd($balance);
                    dd($sell->sellClient->client->name);
                });
            });
        }

        // dd($projectsForecast);

        if ($request->reportType == 'pdf') {
            return PDF::loadview('sales.sales-report.monthly-sales-reportpdf', compact('request', 'sales'))
                ->setPaper('a4', 'landscape')
                ->stream('monthly-sales-reportpdf.pdf');
        } else {
            return view('sales.sales-report.collection-forecast', compact('request', 'sales'));
        }
    }

    public function yearlyQuarterlySalesReport($year = null, $print_type = 'list')
    {
        $sales = [];

        $month_quarter  = [
            '1' => '1,2,3',
            '2' => '4,5,6',
            '3' => '7,8,9',
            '4' => '10,11,12',
        ];

        if ($year) {
            foreach ($month_quarter as $key => $value) {
                $sales[$key] = Sell::with('sellClient.client', 'user.member.team.user', 'apartment.project',)
                    ->whereRaw("MONTH(sell_date) IN ($value)")
                    ->whereYear('sell_date', $year)
                    ->get();
            }
        } else {
            $year = Carbon::now()->format('Y');
            foreach ($month_quarter as $key => $value) {
                $sales[$key] = Sell::with('sellClient.client', 'user.member.team.user', 'apartment.project')
                    ->whereRaw("MONTH(sell_date) IN ($value)")
                    ->whereYear('sell_date', Carbon::now()->year)
                    ->get();
            }
        }

        //team wise sales report
        $team_wise_sales = [];
        $teams = Team::with('user.member')->get();
        foreach ($teams as $team) {
            $team_wise_sales[$team->name] = Sell::with('sellClient.client', 'user.member.team.user', 'apartment.project')
                ->whereHas('user.member.team', function ($q) use ($team) {
                    $q->where('id', $team->id);
                })
                ->whereYear('sell_date', $year)
                ->get();
        }

        if ($print_type == 'pdf') {
            return PDF::loadview('sales.sales-report.yearly-quarterly-sales-reportpdf', compact('sales', 'year', 'team_wise_sales'))
                ->setPaper('a4', 'landscape')
                ->stream('yearly-quarterly-sales-reportpdf.pdf');
        } else {
            return view('sales.sales-report.yearly-quarterly-sales-report', compact('sales', 'year', 'team_wise_sales'));
        }
    }

    public function categoryWiseLeadGenerationReport($month = null, $printType = null)
    {
        if ($month) {
            $year_month = explode("-", $month);
            $year = $year_month[0];
            $month = $year_month[1];
            $category_wise_leads = Leadgeneration::whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->groupBy('lead_stage');
        } else {
            $month = Carbon::now($month)->format('m');
            $year = Carbon::now($month)->format('Y');
            $category_wise_leads = Leadgeneration::whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->groupBy('lead_stage');
        }
        if ($printType == 'excel') {
            return Excel::download(new CategoryWiseLeadGenerationExport($category_wise_leads, $year, $month), 'category-wise-lead-generation-report.xlsx');
        } else {
            return view('sales.sales-report.category-wise-lead-generation-report', compact('category_wise_leads', 'month', 'year'));
        }
    }

    public function weeKWiseLeadGenerationReport($month = null, $printType = null)
    {
        $week_list = [
            '1' => '1,2,3,4,5,6,7,8',
            '2' => '9,10,11,12,13,14,15,16',
            '3' => '17,18,19,20,21,22,23',
            '4' => '24,25,26,27,28,29,30,31',
        ];
        $week_wise_leads = [];
        if ($month) {
            $year_month = explode("-", $month);
            $year = $year_month[0];
            $month = $year_month[1];
            foreach ($week_list as $key => $value) {
                $week_wise_leads[$key] = Leadgeneration::whereRaw("DAY(created_at) IN ($value)")
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
            }
        } else {
            $month = Carbon::now($month)->format('m');
            $year = Carbon::now($month)->format('Y');
            foreach ($week_list as $key => $value) {
                $week_wise_leads[$key] = Leadgeneration::whereRaw("DAY(created_at) IN ($value)")
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
            }
        }

        return view('sales.sales-report.week-wise-lead-generation-report', compact('week_wise_leads', 'month', 'year'));
    }
}//class
