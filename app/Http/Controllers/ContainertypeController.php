<?php

namespace App\Http\Controllers;

use App\Containertype;
use App\Imports\ContainertypesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ContainertypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:containertype-create|containertype-edit|containertype-view|containertype-delete', ['only' => ['index','show']]);
        $this->middleware('permission:containertype-create', ['only' => ['create','store']]);
        $this->middleware('permission:containertype-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:containertype-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $containertypes = Containertype::all();
        return view('containertypes.index', compact('containertypes', $containertypes));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('containertypes.create', compact('formType'));
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
            'isocode' => 'required| unique:containertypes',
            'dimension' => 'required',
            'description' => 'required',
            ]);
        $data = $request->all();

        Containertype::create($data);
        return redirect()->route('containertypes.create')->with('message', 'Container Type Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Containertype  $containertype
     * @return \Illuminate\Http\Response
     */
    public function show(Containertype $containertype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Containertype  $containertype
     * @return \Illuminate\Http\Response
     */
    public function edit(Containertype $containertype)
    {
        $formType = 'edit';
        return view('containertypes.create', compact('formType', 'containertype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Containertype  $containertype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Containertype $containertype)
    {
        $request->validate([
            'isocode' => "required| unique:containertypes,isocode,$request->id",
            'dimension' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        $containertype->update($data);
        return redirect()->route('containertypes.index')->with('message', 'Container Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Containertype $containertype
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Containertype $containertype)
    {
        $containertype->delete();

        return redirect('containertypes')->with('message', 'The Item Deleted Successfully');

    }


    public function import()
    {
        Excel::import(new ContainertypesImport(), \request()->file('file'));
        return redirect(route('containertypes.index'))->with('message', 'The Excel File Uploaded Successfully');
    }


}
