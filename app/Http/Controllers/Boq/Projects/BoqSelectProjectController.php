<?php

namespace App\Http\Controllers\Boq\Projects;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class BoqSelectProjectController extends Controller
{
    public function index(){

        $projects = Project::all();
        return view('boq.projects.select-project', compact('projects'));
    }
}
