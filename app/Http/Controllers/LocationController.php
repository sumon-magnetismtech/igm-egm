<?php

namespace App\Http\Controllers;

use App\Imports\LocationsImport;
use App\Location;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:location-create|location-edit|location-view|location-delete', ['only' => ['index','show']]);
        $this->middleware('permission:location-create', ['only' => ['create','store']]);
        $this->middleware('permission:location-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:location-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        //$locations=Location::paginate(10);
        $portcode = request()->portcode;
        $description=\request()->description;

        $locations = Location::where('portcode', 'LIKE', "%$portcode%")->where('description', 'LIKE', "%$description%")->paginate(10);

        return view('locations.index', compact('locations', $locations))
            ->with('i', (request()->input('page',1)-1)*10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('locations.create', compact('formType'));
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
            'portcode' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        Location::create($data);
        return redirect()->route('locations.index')->withMessage('Location Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
//        return view('locations.show', compact('location', $location));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $formType = 'edit';
        return view('locations.create', compact('location', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //Validate
        $request->validate([

            'portcode' => 'required',
            'description' => 'required',

        ]);

        $data = $request->all();
        $location->update($data);
        $request->session()->flash('message', 'Location modified Successfully.');
        return redirect('locations');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location $location
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect('locations')->withMessage('Location Deleted Successfully "'.$location->portcode ." ".$location->description.'"');
    }


    /**

     * @return \Illuminate\Support\Collection

     */

    public function import()
    {
        Excel::import(new LocationsImport(),request()->file('file'));
        return back();

    }
}
