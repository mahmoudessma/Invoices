<?php

namespace App\Http\Controllers;

use App\Models\Invicies;
use App\Models\Invoices_attachment;
use App\Models\Invoices_details;
use App\Models\Products;
use App\Models\Sections;
use App\Models\User;
use App\Notifications\AddInvoices;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class InviciesController extends Controller
{
    //
    public function index()
    {
        $invoices = Invicies::with('sections')->get();
        // return $invoices->sections->section_name;
        return view('invoices.invoices',compact('invoices'));
    }

    public function create()
    {

        $sections = Sections::all();
        return view ('invoices.addinvoices',compact('sections'));
    }

    public function store(Request $request)
    {
        Invicies::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invicies::latest()->first()->id;
        Invoices_details::create([
            'id_invoices' => $invoice_id,
            'invoices_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invicies::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoices_number = $invoice_number;
            $attachments->created_by= Auth::user()->name;
            $attachments->invoices_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        //    $user = User::first();
        //    $user->notify(new AddInvoices($invoice_id));
           
        //    FacadesNotification::send($user, new AddInvoices($invoice_id));

        // $user = User::get();
        // $invoices = invoices::latest()->first();
        // Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

     




        
        // event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }
    public function edit($id){
        $invoices = Invicies::with('sections')->where('id',$id)->first();
        $sections = Sections::all();
        return view('invoices.updateinvoices',compact('invoices','sections'));

    }
    public function update(Request $request){
        $invoices = Invicies::find($request->id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();

    }

    public function destroy(Request $request)
    {
        $invoices = Invicies::find($request->invoice_id);
        $invoices->forceDelete();

        session()->flash('delete_invoices');
        return redirect('/invoices');
       
    }

    public function payshow($id)
    {
        $invoices = Invicies::find($id);

        return view('invoices.status-payment',compact('invoices'));

    }

    public function payment_update($id , Request $request)
    {
        // return $request;
        $invoices = Invicies::find($id);
        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_invoices' => $request->invoice_id,
                'invoices_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_invoices' => $request->invoice_id,
                'invoices_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');






    }

    public function invoice_paid(){
        $invoices = Invicies::where('Value_Status',1)->get();
        return view('invoices.invoice_paid',compact('invoices'));

    }
    public function invoice_unpaid(){
        $invoices = Invicies::where('Value_Status',2)->get();
        return view('invoices.invoice_paid',compact('invoices'));

    }
    public function invoice_partial(){
        $invoices = Invicies::where('Value_Status',3)->get();
        return view('invoices.invoice_paid',compact('invoices'));

    }

    public function invoice_archive_show()
    {
        $invoices = Invicies::onlyTrashed()->get();
        return view('invoices.invoice_trashed',compact('invoices'));
    
    }
    public function invoice_archive(Request $request){

        // return $request;
        $invoices = Invicies::find($request->invoice_id);
        $invoices->Delete();

        session()->flash('archive_invoices');
        return redirect('/invoices');

    }
    public function invoice_archive_restore(Request $request){

        // return $request;
        $id = $request->invoice_id;
         $flight = Invicies::withTrashed()->where('id', $id)->restore();
         session()->flash('restore_invoice');
         return redirect('/invoices');

    }
    public function invoice_archive_delete(Request $request){

        // return $request;
        $invoices = Invicies::withTrashed()->where('id',$request->invoice_id)->first();
        $invoices->forceDelete();

        session()->flash('delete_invoice');
        return back();

    }
    public function getproduct($id)
    {
        $products = DB::table("products")->where("section_id",$id)->pluck("product_name","id");
        // $section_id =$products->sections->section_id;
        // $sections = Sections::with('products')->get();
        return json_encode($products);

    }

    public function print_invoices($id){

        $invoices=Invicies::where('id',$id)->first();

        return view('invoices.print_invoices',compact('invoices'));

    }
}
