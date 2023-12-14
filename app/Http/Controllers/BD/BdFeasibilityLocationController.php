<?php

namespace App\Http\Controllers\Bd;

use App\BD\BdLeadGeneration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BdFeasibilityLocationController extends Controller
{
    public function index()
    {
        $bd_lead_locations = BdLeadGeneration::orderBy('id', 'desc')->get();
        return view('bd.feasibility.location.index', compact('bd_lead_locations'));
    }

    public function dashboard($location)
    {
        $bd_lead_location_name = BdLeadGeneration::where('id', $location)->get();
        return view('bd.feasibility.location.dashboard', compact('location', 'bd_lead_location_name'));
    }
}
