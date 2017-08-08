<?php

namespace App\Http\Controllers;

use Request;
use App\College;
use App\Http\Requests\CollegeRequest;
use Session;

class CollegesController extends Controller
{
    public function index(){
        $colleges = College::paginate(10);
        return view('colleges.index')->with('colleges', $colleges);
    }
    public function create(){
        $college = new College();
        return view('colleges.create')->with('college', $college);
    }
    public function store(CollegeRequest $request){
        $inputs = $request->all();
        College::create($inputs);
        Session::flash('info', 'College was added!');
        return redirect()->route('admin::colleges.create');
    }
    public function edit($college_id){
        $college = College::find($college_id);
        return view('colleges.edit')->with('college', $college);
    }
    public function update(CollegeRequest $request, $college_id){
        $inputs = $request->all();
        $college = College::find($college_id);        
        $college->update($inputs);
        Session::flash('info', 'College was Updated!');
        return redirect()->route('admin::colleges.index');
    }
    public function destroy($college_id){
        $college = College::find($college_id);
        if($college->users->count() > 0){
            Session::flash('info', "The college has registered users and can't be deleted!");
        }
        else{
            College::destroy($college_id);
            Session::flash('info', "College was deleted!");            
        }
        return redirect()->back();         
    }
}
