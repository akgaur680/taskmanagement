<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(){
        return view('web.report');
    }
    public function store(Request $request){
        try{
            $request->validate([
                'date'=>'required|date',
                'checkIn'=>'required',
                'checkOut'=>'required',
                'project'=>'required|string',
                'taskDetails'=>'required|string',
                'remarks'=>'nullable|string',
            ]);
            $report = $request->all();
            $report['user_id'] = Auth::user()['id'];
    
            Report::create($report);
        }
        

    }
}
