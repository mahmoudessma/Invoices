<?php

namespace App\Http\Controllers;

use App\Models\Invicies;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    //
    public function invoices_reports()
    {
        return view('invoices_reports.invoices_report');
    }


    public function search_reports(Request $request){

        $radio = $request->rdio;


        // return $request;
        if($radio == 1)
        {
            // not select date
            if($request->type && $request->start_at =='' && $request->end_at =='' )
            {
                $report = Invicies::select('*')->where('Status' , $request->type)->get();
                $type = $request->type;
                return view('invoices_reports.invoices_report',compact('type'))->withDetails($report);
            }
            else{

                $type = $request->type;
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);

                $report = Invicies::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
                // return $report;
                return view('invoices_reports.invoices_report',compact('type','start_at','end_at'))->withDetails($report);

            }
        }
        else{

            $invoices_number = $request->invoice_number;
            $report = Invicies::select('*')->where('invoice_number',$invoices_number)->get();
            // return $report;
            return view('invoices_reports.invoices_report')->withDetails($report);
        }
    }
}
