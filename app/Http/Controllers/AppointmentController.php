<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function save(Request $request){
        // dd($request->all());
        $patient = new Appointment([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'timing' => $request->get('timing')
        ]);
        $patient->save();

        return redirect()->back();
    }

    public function showdash (){
        $appoint = DB::table('appointment')->get();
        return view('doctor.dashboard', ['appoint'=> $appoint]);
    }
}
