<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\EmployeeType;
use Modules\HR\Entities\SalarySetting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalarySettingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('salary-setting-show');
        $salarySettings = SalarySetting::where('com_id', auth()->user()->com_id)->with('employeeType')->latest()->get();
        return view('hr::salary-setting.index', compact('salarySettings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('salary-setting-create');
        $formType = 'create';
        $employeeTypes = EmployeeType::orderBy('name')->pluck('name','id');
        return view('hr::salary-setting.create', compact('formType','employeeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try{
            $this->authorize('salary-setting-create');
            $input = $request->all();
            DB::transaction(function() use($input){
                SalarySetting::create($input);
            });
            return redirect()->route('salary-settings.index')->with('success','Salary Setting Created Successfully');
        } catch(\Exception $e){
            return redirect()->back()->with('error','Something went wrong');
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
        $this->authorize('salary-setting-edit');
        $employeeTypes = EmployeeType::orderBy('name')->pluck('name','id');
        $salarySetting = SalarySetting::where('com_id', auth()->user()->com_id)->findOrFail($id);
        $formType = 'edit';
        return view('hr::salary-setting.create', compact('formType','employeeTypes','salarySetting'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try{
            $this->authorize('salary-setting-edit');
            $input = $request->all();
            DB::transaction(function() use($input,$id){
                SalarySetting::where('com_id', auth()->user()->com_id)->findOrFail($id)->update($input);
            });
            return redirect()->route('salary-settings.index')->with('success','Salary Setting Updated Successfully');
        } catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try{
            $this->authorize('salary-setting-delete');
            DB::transaction(function() use($id){
                SalarySetting::where('com_id', auth()->user()->com_id)->findOrFail($id)->delete();
            });
            return redirect()->route('salary-settings.index')->with('success','Salary Setting Deleted Successfully');
        } catch(\Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
}
