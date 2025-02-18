<?php

namespace App\Http\Controllers;

use App\Http\Requests\OffdockRequest;
use App\Imports\OffdocksImport;
use App\Offdock;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OffdockController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:offdock-create|offdock-edit|offdock-view|offdock-delete', ['only' => ['index','show']]);
        $this->middleware('permission:offdock-create', ['only' => ['create','store']]);
        $this->middleware('permission:offdock-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:offdock-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offdocks = Offdock::all();
        return view('offdocks.index', compact('offdocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('offdocks.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OffdockRequest $request)
    {
        $offDockData = $request->only('code', 'name', 'location','phone');
        try{
            Offdock::create($offDockData);
            return redirect()->route('offdocks.index')->with('message','Offdock Created Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offdock  $offdock
     * @return \Illuminate\Http\Response
     */
    public function show(Offdock $offdock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offdock  $offdock
     * @return \Illuminate\Http\Response
     */
    public function edit(Offdock $offdock)
    {
        $formType = 'edit';
        return view('offdocks.create', compact('formType', 'offdock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offdock  $offdock
     * @return \Illuminate\Http\Response
     */
    public function update(OffdockRequest $request, Offdock $offdock)
    {
        $offDockData = $request->only('code', 'name', 'location','phone');
        try{
            $offdock->update($offDockData);
            return redirect()->route('offdocks.index')->with('message','Offdock Updated Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offdock  $offdock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offdock $offdock)
    {
        try{
            $offdock->delete();
            return redirect()->route('offdocks.index')->with('message','Offdock Deleted Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function import(){


        Excel::import(new OffdocksImport(),request()->file('file'));


        return back()->with('success','The File Uploaded Successfully');



    }


}
