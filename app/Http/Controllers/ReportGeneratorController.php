<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Report;

class ReportGeneratorController extends Controller
{
    /**
     * Generate a new report
     * @param Illuminate\Http\Request $request
     */
    public function __invoke(Request $request)
    {
        // get the products from the user
        $products = \Auth::user()->products;
        
        $min_products = 10;
        // check if there are the minimum number of products necessary to generate a report
        if (sizeof($products) < $min_products) {
            return back()->withErrors([
                'no_enough_products' => 'Could not generate a report.<br> Need at least '. $min_products .' products'
            ]);
        }

        $from_date = \Auth::user()->created_at;
        $to_date = now();
        
        // create a name as from the dates
        $from_date = $from_date->year .'-'. $from_date->month .'-'. $from_date->day;
        $to_date = $to_date->year .'-'. $to_date->month .'-'. $to_date->day;

        // create a new report
        $report = new Report();
        $report->name = $from_date .'_'. $to_date;
        $report->from_date = Carbon::parse($from_date);
        $report->to_date = Carbon::parse($to_date);
        $report->user_id = \Auth::id();
        $report->save();
        
        // add the products from the user to the report created
        $report->products()->attach($products);

        // calculate the stats from the report
        // by categories
        $category_stats = DB::table('reports_products')
            ->leftJoin('products', 'reports_products.product_id', '=', 'products.id')
            ->select(
                'reports_products.report_id as report_id',
                'products.category_id as category_id',
                DB::raw('COUNT(products.id) as value')
            )
            ->where('reports_products.report_id', $report->id)
            ->groupByRaw('products.category_id, reports_products.report_id')
            ->get();
        
        $report->category_stats()->attach(json_decode( json_encode($category_stats), true));

        // by conditon
        $condition_stats = DB::table('reports_products')
        ->leftJoin('products', 'reports_products.product_id', '=', 'products.id')
        ->select(
            'reports_products.report_id as report_id',
            'products.condition_id as condition_id',
            DB::raw('COUNT(products.id) as value')
        )
        ->where('reports_products.report_id', $report->id)
        ->groupByRaw('products.condition_id, reports_products.report_id')
        ->get();

        $report->condition_stats()->attach(json_decode( json_encode($condition_stats), true));

        // by state
        $state_stats = DB::table('reports_products')
        ->leftJoin('products', 'reports_products.product_id', '=', 'products.id')
        ->select(
            'reports_products.report_id as report_id',
            'products.state_id as state_id',
            DB::raw('COUNT(products.id) as value')
        )
        ->where('reports_products.report_id', $report->id)
        ->groupByRaw('products.state_id, reports_products.report_id')
        ->get();
        
        $report->state_stats()->attach(json_decode( json_encode($state_stats), true));

        $report->save();
        
        return redirect()->route('report', ['report' => $report->id]);
    }
}
