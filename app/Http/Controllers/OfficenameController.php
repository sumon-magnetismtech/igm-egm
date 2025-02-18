<?php

namespace App\Http\Controllers;

use App\Exports\OfficenamesExport;
use App\Officename;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OfficenameController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:officename-create|officename-edit|officename-view|officename-delete', ['only' => ['index','show']]);
        $this->middleware('permission:officename-create', ['only' => ['create','store']]);
        $this->middleware('permission:officename-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:officename-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officenames = Officename::all();
        return view('officenames.index', compact('officenames', $officenames));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('officenames.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validate
        $request->validate([

            'officecode' => 'required',
            'officename' => 'required',

        ]);

        $data = $request->all();
        Officename::create($data);
        return redirect()->route('officenames.index')->withMessage('Office Name Created Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Officename  $officename
     * @return \Illuminate\Http\Response
     */
    public function show(Officename $officename)
    {
//        return view('officenames.show', compact('officename', $officename));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Officename  $officename
     * @return \Illuminate\Http\Response
     */
    public function edit(Officename $officename)
    {
        $formType = 'edit';
        return view('officenames.create', compact('formType', 'officename'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Officename  $officename
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Officename $officename)
    {
        //Validate
        $request->validate([
            'officecode' => 'required',
            'officename' => 'required',
        ]);

        $data = $request->all();
        $officename->update($data);
        $request->session()->flash('message', 'Successfully modified the information!');
        return redirect('officenames');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Officename $officename
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Officename $officename)
    {
        $officename->delete();
        return redirect('officenames')->withMessage('Deleted Successfully "'.$officename->officecode ." ".$officename->officename.'"');

    }

//    public function downloadExcel($type){
//
//        $data = Officename::get()->toArray();
//
//        return Excel::store('itsolutionstuff_example', function($excel) use ($data) {
//
//            $excel->sheet('mySheet', function($sheet) use ($data)
//
//            {
//
//                $sheet->fromArray($data);
//
//            });
//
//        })->download($type);
//


//
//    }

    public function downloadExcel(){


        return Excel::download(new OfficenamesExport, 'Office_names.xlsx');

    }
}
