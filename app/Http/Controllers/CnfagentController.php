<?php

namespace App\Http\Controllers;

use App\Cnfagent;
use App\Housebl;
use App\Imports\CnfagentImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class CnfagentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cnfagent-create|cnfagent-edit|cnfagent-view|cnfagent-delete', ['only' => ['index','show']]);
        $this->middleware('permission:cnfagent-create', ['only' => ['create','store']]);
        $this->middleware('permission:cnfagent-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:cnfagent-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cnfagents = Cnfagent::all();
        return view('cnfagents.index', compact('cnfagents'));
    }

    public function create()
    {
        $formType = 'create';
        return view('cnfagents.create',compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "cnfagent" => 'required | unique:cnfagents',
            "contact" => 'required'
        ]);

        $requestData = $request->all();
        Cnfagent::create($requestData);
        return redirect(route('cnfagents.index'))->with('message', 'Cnf Agent Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cnfagent  $cnfagent
     * @return \Illuminate\Http\Response
     */
    public function show(Cnfagent $cnfagent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cnfagent  $cnfagent
     * @return \Illuminate\Http\Response
     */
    public function edit(Cnfagent $cnfagent)
    {
        $formType = 'edit';
        return view('cnfagents.create',compact('formType','cnfagent'));
    }

    public function update(Request $request, Cnfagent $cnfagent)
    {
        $request->validate([
            "cnfagent" => 'required',
            "contact" => 'required'
        ]);
        $data = $request->all();
        $cnfagent->update($data);
        return redirect()->route('cnfagents.index')->with('message', 'Cnf Agent Updated Successfully');
    }

    public function destroy(Cnfagent $cnfagent)
    {
        $cnfagent->delete();
        return redirect()->route('cnfagents.index')->with('message', 'Cnf Agent  Deleted Successfully');
    }

    public function import(){
         Excel::import(new CnfagentImport(),request()->file('file'));
         return back()->with('success','The File Uploaded Successfully');
    }

}
