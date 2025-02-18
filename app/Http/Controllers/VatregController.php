<?php

namespace App\Http\Controllers;

use App\Http\Requests\VatregRequest;
use App\Imports\VatRegImport;
use App\Vatreg;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VatregController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vatreg-create|vatreg-edit|vatreg-view|vatreg-delete', ['only' => ['index','show']]);
        $this->middleware('permission:vatreg-create', ['only' => ['create','store']]);
        $this->middleware('permission:vatreg-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:vatreg-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name= $request->name;
        $bin= $request->bin;
        $vatregs = Vatreg::where('NAME', 'LIKE', "%$name%")->where('BIN', 'LIKE', "%$bin%")->paginate();
        return view('vatregs.index', compact('vatregs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('vatregs.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VatregRequest $request)
    {
        try{
            $data = $request->all();
            Vatreg::create($data);
            return redirect()->route('vatregs.index')->with('message','Registration Entered Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vatreg $vatreg)
    {
        $formType = 'edit';
        return view('vatregs.create', compact('vatreg', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VatregRequest $request, Vatreg $vatreg)
    {
        try{
            $data = $request->all();
            $vatreg->update($data);
            return redirect()->route('vatregs.index')->with('message','Registration Updated Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importVatRegsExcel()
    {
        Excel::import(new VatRegImport(),request()->file('file'));
        return back();
    }
    
}
