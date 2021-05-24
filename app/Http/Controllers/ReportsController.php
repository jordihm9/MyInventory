<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;

class ReportsController extends Controller
{
    /**
     * Return the view sending all the reports from the current logged user
     */
    public function show()
    {
        return view('reports')->with([
            'reports' => \Auth::user()->reports,
        ]);
    }

    /**
     * Delete a report
     * @param Illuminate\Http\Request $request
     */
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'report' => ['required'],
        ]);

        $report = Report::where('id', $request->input('report'))->first();

        $report->delete();

        return back();
        // return response('Report deleted', 200);
    }
}
