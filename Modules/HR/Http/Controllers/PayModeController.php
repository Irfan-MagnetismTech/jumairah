<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\PayMode;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PayModeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('paymode-show');
        $pay_mode = PayMode::latest()->get();
        return view('hr::pay-mode.index', compact('pay_mode'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('paymode-create');
        $formType = 'create';
        return view('hr::pay-mode.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('paymode-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                PayMode::create($input);
            });

            return redirect()->route('pay-modes.index')->with('message', 'Pay Mode created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('pay-modes.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('paymode-edit');
        $formType = 'edit';
        $pay_mode = PayMode::findOrFail($id);
        return view('hr::pay-mode.create', compact('formType', 'pay_mode'));
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
            $this->authorize('paymode-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $paymode = PayMode::findOrFail($id);
                $paymode->update($input);
            });

            return redirect()->route('pay-modes.index')->with('message', 'Pay Mode updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('pay-modes.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('paymode-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $paymode = PayMode::with('employee_bank_infos')->findOrFail($id);

                if ($paymode->employee_bank_infos->count() === 0) {
                    $paymode->delete();
                    $message = ['message' => 'Pay Mode deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });

            return redirect()->route('pay-modes.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('pay-modes.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
