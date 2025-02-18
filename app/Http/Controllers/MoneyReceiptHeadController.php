<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyReceiptHeadRequest;
use App\MoneyReceiptHead;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MoneyReceiptHeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:moneyreceipthead-create|moneyreceipthead-edit|moneyreceipthead-view|moneyreceipthead-delete', ['only' => ['index','show']]);
        $this->middleware('permission:moneyreceipthead-create', ['only' => ['create','store']]);
        $this->middleware('permission:moneyreceipthead-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:moneyreceipthead-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moneyreceiptheads=MoneyReceiptHead::all();
        return view('moneyreceiptheads.index', compact('moneyreceiptheads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('moneyreceiptheads.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MoneyReceiptHeadRequest $request)
    {
        $moneyreceiptheaddata = $request->only('name', 'description');
        try{
            MoneyReceiptHead::create($moneyreceiptheaddata);
            return redirect()->route('moneyreceiptheads.index')->with('message','MR Head Created Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MoneyReceiptHead  $moneyreceipthead
     * @return \Illuminate\Http\Response
     */
    public function show(MoneyReceiptHead $moneyreceipthead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MoneyReceiptHead  $moneyreceipthead
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyReceiptHead $moneyreceipthead)
    {
        $formType = 'edit';
        return view('moneyreceiptheads.create', compact('formType', 'moneyreceipthead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MoneyReceiptHead  $moneyreceipthead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MoneyReceiptHead $moneyreceipthead)
    {
        $moneyreceiptheaddata = $request->only('name', 'description');
        try{
            $moneyreceipthead->update($moneyreceiptheaddata);
            return redirect()->route('moneyreceiptheads.index')->with('message','MR Head Update Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MoneyReceiptHead  $moneyreceipthead
     * @return \Illuminate\Http\Response
     */
    public function destroy(MoneyReceiptHead $moneyreceipthead)
    {
        try{
            $moneyreceipthead->delete();
            return redirect()->route('moneyreceiptheads.index')->with('message','MR Head Deleted Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
