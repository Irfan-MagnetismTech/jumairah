<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Bonus;

class BonusController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('bonus-show');
        $bonuses = Bonus::latest()->get();
        return view('hr::bonus.index',compact('bonuses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('bonus-create');
        $formType = 'create';
        return view('hr::bonus.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('bonus-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Bonus::create($input);
            });

            return redirect()->route('bonuses.index')->with('message', 'Bonus information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bonuses.index')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('bonus-edit');
        $formType = 'edit';
        $bonus = Bonus::find($id);
        return view('hr::bonus.create', compact('formType','bonus'));
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
            $this->authorize('bonus-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $bonus = Bonus::findOrFail($id);
                $bonus->update($input);
            });

            return redirect()->route('bonuses.index')->with('message', 'Bonus information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bonuses.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('bonus-delete');
            $message = 0;
            $bonus = Bonus::with('bonusSettings')->findOrFail($id);
            //dd($bonus->bonusSettings());
            if ($bonus->bonusSettings()->count() === 0) {
                $bonus->delete();
                $message = ['message'=>'Bonus Information deleted successfully.'];
            } else {
                $message = ['error'=>'This data has some dependency.'];
            }

            return redirect()->route('bonuses.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('bonuses.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
