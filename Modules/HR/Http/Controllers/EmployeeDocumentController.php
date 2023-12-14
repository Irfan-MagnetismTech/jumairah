<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\AppointmentLetter;
use Modules\HR\Entities\Employee;
use Modules\SoftwareSettings\Entities\CompanyInfo;
use PDF;

class EmployeeDocumentController extends Controller
{
    public function appointmentLetterGenerationForm(Request $request)
    {
        return view("hr::idcard-appointment-letter.appointment-letter-generation");
    }

    function appointmentLetterGeneration(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string',
            'employee_address' => 'required|string',
            'employee_department' => 'required|string',
            'employee_designation' => 'required|string',
            'employee_job_location' => 'required|string',
            'posted_to_company_name' => 'required|string',
            'terms_and_conditions' => 'required|string',
            'letter_issue_date' => 'date|string',
            'letter_issuer_name' => 'required|string',
            'letter_issuer_designation' => 'required|string',
            'letter_carbon_copy_to' => 'required|string',
        ]);

        $appointment_letter = new AppointmentLetter();

        $appointment_letter->employee_name = $request->employee_name;
        $appointment_letter->employee_address = $request->employee_address;
        $appointment_letter->employee_department = $request->employee_department;
        $appointment_letter->employee_designation = $request->employee_designation;
        $appointment_letter->employee_job_location = $request->employee_job_location;
        $appointment_letter->employee_joining_date = $request->employee_joining_date;
        $appointment_letter->posted_to_company_name = $request->posted_to_company_name;
        $appointment_letter->terms_and_conditions = $request->terms_and_conditions;
        $appointment_letter->letter_issue_date = $request->letter_issue_date;
        $appointment_letter->letter_issuer_name = $request->letter_issuer_name;
        $appointment_letter->letter_issuer_designation = $request->letter_issuer_designation;
        $appointment_letter->letter_carbon_copy_to = $request->letter_carbon_copy_to;
        $appointment_letter->letter_creator_id = auth()->user()->id;

        // $emp_code_initial = CompanyInfo::where('com_id', auth()->user()->com_id)->first()->emp_code_initial;


        $lastInsertedLetter = DB::table('appointment_letters')->where('com_id', auth()->user()->com_id)->orderBy('id', 'desc')->first();

        !empty($lastInsertedLetter) ? $lastInsertedLetterID = $lastInsertedLetter->id + 1 :  $lastInsertedLetterID = 1;

        $appointment_letter->letter_no = '12313' . "/AppointmentLetter/" . $lastInsertedLetterID;

        $appointment_letter->save();

        try {

            $pdf = PDF::loadView(
                'hr::idcard-appointment-letter.print-appointmentletter',
                compact('appointment_letter'),
                [],
                [
                    'title' => 'Employee Appointment Letter',
                    'format' => 'A4',
                    'orientation' => 'P'
                ]
            );

            return $pdf->stream('appointment_letter.pdf');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    function appointmentLetterView($id)
    {
        $appointment_letter = AppointmentLetter::find($id);

        $pdf = PDF::loadView(
            'hr::idcard-appointment-letter.print-appointmentletter',
            compact('appointment_letter'),
            [],
            [
                'title' => 'Employee Appointment Letter',
                'format' => 'A4',
                'orientation' => 'P'
            ]
        );

        return $pdf->stream('appointment_letter.pdf');
    }
}
