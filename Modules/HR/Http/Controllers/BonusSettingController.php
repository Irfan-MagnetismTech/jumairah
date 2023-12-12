<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Bonus;
use Modules\HR\Entities\BonusSetting;
use Modules\HR\Entities\Department;
use Modules\HR\Entities\Employee;

class BonusSettingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('bonus-setting-show');
        $bonusSettings = BonusSetting::with('employee', 'bonus')->latest()->get();
        return view('hr::bonus-setting.index', compact('bonusSettings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('bonus-setting-create');
        $formType = 'create';
        $bonuses = Bonus::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        $employees = Employee::pluck('emp_name', 'id');
        return view('hr::bonus-setting.create', compact('bonuses', 'departments', 'formType', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            $this->authorize('bonus-setting-create');
            $input = $request->except('department_id');
            $input['bonus_id'] = json_encode($input['bonus_id']);
            DB::transaction(function () use ($input, $request) {
                if (BonusSetting::where('employee_id', $input['employee_id'])->count() > 0) {
                    $bonusSettings = BonusSetting::where('employee_id', $input['employee_id'])->first();
                    $bonusSettings->update($input);
                } else {
                    BonusSetting::create($input);
                }
            });

            return redirect()->route('bonus-settings.index')->with('message', 'Bonus Setting information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bonus-settings.index')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('bonus-setting-edit');
        $formType = 'edit';
        $bonusSetting = BonusSetting::find($id);
        $bonuses = Bonus::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        $employees = Employee::pluck('emp_name', 'id');
        return view('hr::bonus-setting.create', compact('bonusSetting', 'bonuses', 'departments', 'formType', 'employees'));
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
            $this->authorize('bonus-setting-edit');

            $input = $request->except('department_id');

            if ($input['amount_type'] == 'percentage' && $input['amount'] > 100) {
                $input['amount'] = 100;
            }

            $input['bonus_id'] = json_encode($input['bonus_id']);
            DB::transaction(function () use ($input, $request, $id) {
                $bonusSettings = BonusSetting::findOrFail($id);
                $bonusSettings->update($input);
            });

            return redirect()->route('bonus-settings.index')->with('message', 'Bonus Setting Updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bonus-settings.index')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('bonus-setting-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                BonusSetting::where('com_id', auth()->user()->com_id)->findOrFail($id)->delete();
                $message = ['message' => 'Bonus Setting information deleted successfully.'];
            });

            return redirect()->route('bonus-settings.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('bonus-settings.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
