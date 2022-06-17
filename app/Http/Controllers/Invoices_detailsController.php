<?php

namespace App\Http\Controllers;

use App\Models\Invicies;
use App\Models\Invoices_attachment;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;


class Invoices_detailsController extends Controller
{
    public function edit($id)
    {
        $invoices = Invicies::with('sections')->where('id',$id)->first();
        // $invoices = Invicies::where('id',$id)->first();
        $details = Invoices_details::where('id_invoices',$id)->get();
        $attachments = Invoices_attachment::where('invoices_id',$id)->get();
        // return $invoices->sections->section_name;
        return view('invoices.invoices_details',compact('invoices','details','attachments'));
    }
    public function open_file($invoices_number , $file_name){
        // you must add config in filesystems.php
        // $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPerfix($invoices_number.'/'.$file_name);
        
        // return response()->file($files);
        

    }
    public function get_file($invoices_number , $file_name){
        // you must add config in filesystems.php
        // $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPerfix($invoices_number.'/'.$file_name);
        // return response()->file($files);

        // $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoices_number.'/'.$file_name);
        // return response()->file($files);


    }
    public function getdata(Request $request){
        return $request;

    }
    public function delete(Request $request)
    {
        $invoices = Invoices_attachment::findOrFail($request->id_file);
        $invoices->delete();
        // return $request;
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();


    }
}
