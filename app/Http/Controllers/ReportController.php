<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Get a report and send to the details view
     * @param Illuminate\Http\Request $request
     */
    public function show(Request $request)
    {
        $report_id = $request->input('report');

        $report = Report::where('id', $report_id)->firstOrFail();

        return view('report_details')->with([
            'report' => $report
        ]);
    }

    /**
     * 
     * @param Illuminate\Http\Request $request
     */
    public function details(Request $request)
    {
        $report_id = $request->input('report');

        $report = Report::where('id', $report_id)->firstOrFail();

        return response()->json([
            'categories' => $report->category_stats,
            'conditions' => $report->condition_stats,
            'states' => $report->state_stats
        ]);
    }
}
