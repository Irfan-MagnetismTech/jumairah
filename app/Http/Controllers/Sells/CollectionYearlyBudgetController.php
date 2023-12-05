<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionYearlyBudgetRequest;
use App\Sells\CollectionYearlyBudget;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionYearlyBudgetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collection-yearly-budget-view|collection-yearly-budget-create|collection-yearly-budget-update|collection-yearly-budget-delete', ['only' => ['index','show']]);
        $this->middleware('permission:collection-yearly-budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:collection-yearly-budget-update', ['only' => ['edit','update']]);
        $this->middleware('permission:collection-yearly-budget-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $budgets = CollectionYearlyBudget::with('collectionYearlyBudgetDetails','project')->latest()->get();
        return view('sales/collection-yearly-budgets/index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.collection-yearly-budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionYearlyBudgetRequest $request)
    {
        try {
            $data = $request->only('year','project_id');
            $data['user_id'] = auth()->user()->id;
            $detailsArray = array();
            foreach ($request->month as  $key => $detail) {
                $detailsArray[] = [
                    'month'                 =>  $request->month[$key],
                    'collection_amount'     =>  $request->collection_amount[$key],
                ];
            }
            DB::transaction(function() use ($detailsArray, $data) {
                $collectionYearlyBudget = CollectionYearlyBudget::create($data);
                $collectionYearlyBudget->collectionYearlyBudgetDetails()->createMany($detailsArray);
            });
            return redirect()->route('collection-yearly-budgets.index')->with('message', 'Budget has been added successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CollectionYearlyBudget  $collectionYearlyBudget
     * @return \Illuminate\Http\Response
     */
    public function show(CollectionYearlyBudget $collectionYearlyBudget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CollectionYearlyBudget  $collectionYearlyBudget
     * @return \Illuminate\Http\Response
     */
    public function edit(CollectionYearlyBudget $collectionYearlyBudget)
    {
        return view('sales.collection-yearly-budgets.create', compact('collectionYearlyBudget'));
    }


    public function update(CollectionYearlyBudgetRequest $request, CollectionYearlyBudget $collectionYearlyBudget)
    {
        try {
            $data = $request->only('year');
            $detailsArray = array();
            foreach ($request->month as  $key => $detail) {
                $detailsArray[] = [
                    'month'                 =>  $request->month[$key],
                    'collection_amount'     =>  $request->collection_amount[$key],
                ];
            }
            DB::transaction(function() use ($detailsArray, $data, $collectionYearlyBudget) {
                $collectionYearlyBudget->update($data);
                $collectionYearlyBudget->collectionYearlyBudgetDetails()->delete();
                $collectionYearlyBudget->collectionYearlyBudgetDetails()->createMany($detailsArray);
            });
            return redirect()->route('collection-yearly-budgets.index')->with('message', 'Budget has been Updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(CollectionYearlyBudget $collectionYearlyBudget)
    {
        try {
            $collectionYearlyBudget->delete();
            return redirect()->route('collection-yearly-budgets.index')->with('message', 'Budget has been Deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
