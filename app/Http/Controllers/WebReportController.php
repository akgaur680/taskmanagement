<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WebReportController extends Controller
{
    public function index()
    {
        // Get the start and end dates of the current month
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        // Fetch all reports for the current user within the current month
        $reports = Report::where('user_id', Auth::user()->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date'); // Key by date for easy lookup

        // Generate all dates of the current month
        $allDates = [];
        $currentDate = $startDate;
        while (strtotime($currentDate) <= strtotime($endDate)) {
            $allDates[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return view('web.report', compact('allDates', 'reports'));
    }

    public function store(Request $request)
    {
        try {
            $today = date('Y-m-d');
    
            $request->validate([
                'date' => [
                    'required',
                    'date',
                    'before_or_equal:' . $today,
                    Rule::unique('report')->where(function ($query) use ($request) {
                        return $query->where('user_id', Auth::id())->where('date', $request->date);
                    }),
                ],
                'checkIn' => 'required',
                'checkOut' => 'required',
                'project' => 'required|string',
                'taskDetails' => 'required|string',
                'remarks' => 'nullable|string',
            ]);
    
            $report = $request->all();
            $report['user_id'] = Auth::user()->id;
            $savedReport = Report::create($report);
    
            // Return success message with details
            return response()->json([
                'message' => 'Daily Task Added Successfully',
                'id' => $savedReport->id,
                'date' => $savedReport->date,
                'checkIn' => $savedReport->checkIn,
                'checkOut' => $savedReport->checkOut,
                'project' => $savedReport->project,
                'taskDetails' => $savedReport->taskDetails,
                'remarks' => $savedReport->remarks,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    



    public function edit(Request $request, $id)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'checkIn' => 'required',
                'checkOut' => 'required',
                'project' => 'required|string',
                'taskDetails' => 'required|string',
                'remarks' => 'nullable|string',
            ]);
            $report = $request->all();
            $report['user_id'] = Auth::user()['id'];
            $report_id = Report::findOrFail($id);
            $report_id->update($report);
            return redirect()->back()->with('success', 'Daily Task Updated Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function delete($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->back()->with('success', 'Daily Task Deleted Successfully');
    }
}
