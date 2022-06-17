<?php

namespace App\Http\Controllers;

use App\Models\Invicies;
use App\Models\Invoices_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Invoices_attachmentController extends Controller
{
    public function store(Request $request){
        if ($request->hasFile('file_name')) {

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
         Invoices_attachment::create([
             'file_name'=>$file_name,
             'invoices_number'=>$request->invoice_number,
             'invoices_id'=>$request->invoice_id,
             'created_by'=>(Auth::user()->name)
         ]);
         $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);
        }
         session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    
}
