<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use Exception;
use App\Project;
use App\Sells\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Boq\Departments\Eme\BoqEmeUtilityBill;
use App\Http\Requests\Boq\Eme\BoqEmeUtilityBillRequest;
use Spatie\Permission\Traits\HasRoles;

class UtilityBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:boq-eme-utility-bill-view|boq-eme-utility-bill-create|boq-eme-utility-bill-edit|boq-eme-utility-bill-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-utility-bill-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-utility-bill-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-utility-bill-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $utilityBills = BoqEmeUtilityBill::orderBy('id', 'DESC')->paginate(15);
        return view('eme.utility_bill.index', compact('utilityBills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $formType = 'create';
        return view('eme.utility_bill.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqEmeUtilityBillRequest $request)
    {
        //
        try {
            $utilitybilldata = $request->only('client_id', 'project_id', 'apartment_id', 'period', 'previous_reading', 'present_reading', 'electricity_rate', 'common_electric_amount', 'total_bill', 'total_electric_amount_aftervat', 'due_amount', 'delay_charge_percent', 'pfc_charge_percent', 'demand_charge_percent', 'vat_tax_percent', 'meter_no');
            $utilitybilldetails = [];
            foreach ($request->other_cost_name as $key => $value) {
                $utilitybilldetails[] = [
                    'other_cost_name' => $request->other_cost_name[$key],
                    'other_cost_amount' => $request->other_cost_amount[$key]
                ];
            }
            DB::beginTransaction();
            $utility = BoqEmeUtilityBill::create($utilitybilldata);
            $utility->eme_utility_bill_detail()->createMany($utilitybilldetails);
            DB::commit();
            return redirect()->route('eme.utility_bill.index')->with('message', 'Data has been inserted successfully');
        } catch (Exception $err) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BoqEmeUtilityBill $utility_bill)
    {
        return view('eme.utility_bill.show', compact('utility_bill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BoqEmeUtilityBill $utility_bill)
    {
        //
        $formType = 'edit';
        $apartment = Apartment::query()
            ->where('project_id', $utility_bill->project_id)
            ->whereHas('sell.sellClients', function ($query) use ($utility_bill) {
                $query->where('client_id', $utility_bill->client_id);
            })->pluck('name', 'id');
        return view('eme.utility_bill.create', compact('formType', 'utility_bill', 'apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoqEmeUtilityBillRequest $request, BoqEmeUtilityBill $utility_bill)
    {
        //
        try {
            $utilitybilldata = $request->only('client_id', 'apartment_id', 'period', 'previous_reading', 'present_reading', 'electricity_rate', 'common_electric_amount', 'total_bill', 'total_electric_amount_aftervat', 'due_amount', 'delay_charge_percent', 'pfc_charge_percent', 'demand_charge_percent', 'vat_tax_percent', 'meter_no');
            $utilitybilldetails = [];
            foreach ($request->other_cost_name as $key => $value) {
                $utilitybilldetails[] = [
                    'other_cost_name' => $request->other_cost_name[$key],
                    'other_cost_amount' => $request->other_cost_amount[$key]
                ];
            }
            DB::beginTransaction();
            $utility_bill->update($utilitybilldata);
            $utility_bill->eme_utility_bill_detail()->delete();
            $utility_bill->eme_utility_bill_detail()->createMany($utilitybilldetails);
            DB::commit();
            return redirect()->route('eme.utility_bill.index')->with('message', 'Data has been updated successfully');
        } catch (Exception $err) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoqEmeUtilityBill $utility_bill)
    {
        try {
            $utility_bill->delete();
            return redirect()->route('eme.utility_bill.index')->with('message', 'Data has been deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $BoqEmeUtilityBill = BoqEmeUtilityBill::findOrFail($id);
        $BoqEmeUtilityBill->load('eme_utility_bill_detail');
        // return view('boq.departments.electrical.utility_bill.pdf', compact('BoqEmeUtilityBill'));
        $pdf = \PDF::loadview('eme.utility_bill.pdf', compact('BoqEmeUtilityBill'))->setPaper('A4', 'portrait');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.15, "Multiply");

        $canvas->page_text(
            $width / 3,
            $height / 2,
            config('company_info.company_name'),
            null,
            55,
            array(0, 0, 0),
            2,
            2,
            -30
        );
        return $pdf->stream('BoqEmeUtilityBill.pdf');
    }
}
