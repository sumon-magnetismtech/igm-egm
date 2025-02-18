<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Imports\CommoditysImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CommodityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:commodity-create|commodity-edit|commodity-view|commodity-delete', ['only' => ['index','show']]);
        $this->middleware('permission:commodity-create', ['only' => ['create','store']]);
        $this->middleware('permission:commodity-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:commodity-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commoditys = Commodity::all();
        return view('commoditys.index', compact('commoditys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('commoditys.create', compact('formType'));
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

            "commoditycode" => 'required | unique:commodities',
            "commoditydescription" => 'required'

        ]);
        $data = $request->all();

        Commodity::create($data);

        return redirect(route('commoditys.index'))->with('message', 'Commodity Created Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {
        $formType = 'edit';
        return view('commoditys.create', compact('formType', 'commodity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commodity $commodity)
    {
        $request->validate([

            'commoditycode' => 'required',
            'commoditydescription' => 'required'

        ]);

        $data = $request->all();

        $commodity->update($data);

        return redirect()->route('commoditys.index')->with('message', 'Commodity Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commodity $commodity
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Commodity $commodity)
    {
        $commodity->delete();
        return redirect()->route('commoditys.index')->with('message', 'Commodity Deleted Successfully');
    }


    public function import(){

        Excel::import(new CommoditysImport(),request()->file('file'));
        return back()->with('success','The File Uploaded Successfully');

    }
}
