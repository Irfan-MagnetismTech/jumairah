<?php

namespace Modules\HR\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Modules\HR\Entities\Line;
use App\Events\RealTimeMessage;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Notifications\RealTimeNotification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LineController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('line-show');

        // get users who has role Audit

        $users = User::role('Audit')->get();
        // dd($users);

        foreach ($users as $user) {
            $user->notify(new RealTimeNotification(' I am a notification 😄'));
        }

        $lines = Line::latest()->get();
        return view('hr::line.index', compact('lines'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('line-create');
        $formType = 'create';
        return view('hr::line.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


        // return $request->all();
        try {
            $this->authorize('line-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Line::create($input);
            });

            return redirect()->route('lines.index')->with('message', 'Line created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('lines.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('line-edit');
        $formType = 'edit';
        $line = Line::where('com_id', auth()->user()->com_id)->first();
        return view('hr::line.create', compact('formType', 'line'));
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
            $this->authorize('line-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                Line::where('com_id', auth()->user()->com_id)->first()->update($input);
            });

            return redirect()->route('lines.index')->with('message', 'Line updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('lines.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('line-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $line = Line::with('employees')->where('com_id', auth()->user()->com_id)->first();
                // dd($line);
                if ($line->employees->count() === 0) {
                    $line->delete();
                    $message = ['message' => 'Line deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });

            return redirect()->route('lines.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('lines.index')->withErrors($e->getMessage());
        }
    }
}
