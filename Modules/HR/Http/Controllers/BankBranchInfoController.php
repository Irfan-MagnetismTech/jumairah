<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Bank;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\BankBranchInfo;
use Illuminate\Contracts\Support\Renderable;

class BankBranchInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bankBranchInfos = BankBranchInfo::with('bank')->latest()->get();
        return view('hr::bank-branch-info.index', compact('bankBranchInfos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $banks = Bank::orderBy('name')->pluck('name', 'id');
        return view('hr::bank-branch-info.create', compact('formType', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {

            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                BankBranchInfo::create($input);
            });

            return redirect()->route('bank-branch-info.index')->with('message', 'bank branch information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bank-branch-info.index')->withInput()->withErrors($e->getMessage());
        }




    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $formType = "edit";
        $banks = Bank::orderBy('name')->pluck('name', 'id');
        $bankBranchInfo = BankBranchInfo::findOrFail($id);
        return view('hr::bank-branch-info.create', compact('formType', 'banks', 'bankBranchInfo'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {

            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $bankBranchInfo = BankBranchInfo::findOrFail($id);
                $bankBranchInfo->update($input);
            });

            return redirect()->route('bank-branch-info.index')->with('message', 'bank branch information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bank-branch-info.index')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        try {
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $bankbranchInfo = BankBranchInfo::with('bank', 'employeebankBranchs')->findOrFail($id);
                // dd($bankbranchInfo->bank->count());
                if ($bankbranchInfo->bank->count() === 0 && $bankbranchInfo->employeebankBranchs->count() === 0) {
                    $bankbranchInfo->delete();        
                    $message = ['message'=>'Bank branch information deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });
            
            return redirect()->route('bank-branch-info.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('bank-branch-info.index')->withInput()->withErrors($e->getMessage());
        }
    }

    public function fetchBankBranch(Request $request)
    {
        $bank_id = $request->input('bank_id');

        $branches = BankBranchInfo::where('bank_id', $bank_id)->get();

        // Return the HTML for the Division dropdown options
        if (count($branches)>0) {
            $html = '<option value="">Select a division</option>';
            foreach ($branches as $branch) {
                $html .= '<option value="' . $branch->id . '">' . $branch->branch . '</option>';
            }
        }
        else{
            $html = '<option value="">No Post Offices</option>';
        }
        return $html;
    }
}
