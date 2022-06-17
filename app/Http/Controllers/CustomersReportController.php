<?php

namespace App\Http\Controllers;

use App\Models\Invicies;
use App\Models\Sections;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    public function customers_reports()
    {
        $sections = Sections::all();
        return view('invoices_reports.customers_reports',compact('sections'));

    }
    public function Search_customers(Request $request)
    {
        $sections = Sections::all();

        if($request->Section &&$request->product && $request->start_at =='' && $request->end_at=='')
        {
            $invoices = Invicies::where('product',$request->product)->get();
            return view('invoices_reports.customers_reports', compact('sections'))->withDetails($invoices);
        }
        else{
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invicies::whereBetween('invoice_Date',[$start_at,$end_at])->where('product','=',$request->product)->get();
            // return $report;
            return view('invoices_reports.customers_reports', compact('sections','start_at','end_at'))->withDetails($invoices);
        }

    }
}
