<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index(){
        $sections = Sections::get();
        return view('sections.sections',compact('sections'));

    }
    public function store(SectionRequest $request)
    {
        // $input = $request->all();

        // $b_exists = Sections::where('section_name','=',$input['section_name'])->exists();
        
        // if($b_exists){
        //     session()->flash('error' , 'خطأ القسم مسجل مسبقا');
        //     return redirect('/sections');
        // }
        // else{
        //     Sections::create([
        //         'section_name'=>$request->section_name,
        //         'description'=>$request->description,
        //         'created_by'=>(Auth::User()->name),
        //     ]);
        //     session()->flash('add','تم اضافة القسم بنجاح');
        //     return redirect('sections');
        // }



        Sections::create([
                    'section_name'=>$request->section_name,
                    'description'=>$request->description,
                    'created_by'=>(Auth::User()->name),
                ]);
                session()->flash('add','تم اضافة القسم بنجاح');
                return redirect('sections');

    }

    public function update(SectionRequest $request ){

        $section = Sections::find($request->id);
        $section->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description,
        ]);
        session()->flash('update','تم تعديل القسم بنجاح');
        return redirect('sections');

    }

    public function delete($id)
    {
        $section = Sections::find($id);
        $section->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('sections');


    }
}
