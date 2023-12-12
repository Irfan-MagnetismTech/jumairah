<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\BusStop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BusStopController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('busstop-show');
        $busStops = BusStop::latest()->get();
        return view('hr::bus-stop.index', compact('busStops'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('busstop-create');
        $formType = "create";
        return view('hr::bus-stop.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('busstop-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                BusStop::create($input);
            });

            return redirect()->route('bus-stops.index')->with('message', 'Bus stop created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bus-stops.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('busstop-edit');
        $formType = "edit";
        $busStop = BusStop::findOrFail($id);
        return view('hr::bus-stop.create', compact('formType', 'busStop'));
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
            $this->authorize('busstop-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                BusStop::findOrFail($id)->update($input);
            });

            return redirect()->route('bus-stops.index')->with('message', 'Bus stop updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bus-stops.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('busstop-delete');
            DB::transaction(function () use ($id) {
                BusStop::findOrFail($id)->delete();
            });

            return redirect()->route('bus-stops.index')->with('message', 'Bus stop deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->route('bus-stops.index')->withErrors($e->getMessage());
        }
    }
}
