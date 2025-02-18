<?php

namespace App\Http\Controllers\Ctrack;

use App\Ctrack\EmptyContainer;
use App\Http\Controllers\Controller;
use App\MLO\Blcontainer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class EmptyContainerController extends Controller
{

    public function index()
    {
        $containerGroup = '';
        $containerList = '';
        return view('ctrack/emptyContainers.containerList', compact('containerList', 'containerGroup'));
    }

    public function searchContainer(Request $request)
    {
        $bolreference = $request->bolreference;

        $containerList = Blcontainer::with('emptyContainers')
            ->whereHas('mloblinformation', function($q) use ($bolreference){
                            $q->where('bolreference', $bolreference);
                        })
            ->get();

        $containerGroup = $containerList->groupBy('containerStatus', true)->map(function($item){
            return count($item);
        });


        if($containerList){
            return view('ctrack/emptyContainers.containerList', compact('containerList', 'bolreference', 'containerGroup'));
        }else{
            return redirect()->back()->withErrors("Sorry no data found based on the information given.");
        }
    }

    public function searchContainerByConRef(Request $request)
    {
        $bolreference = $request->bolreference;
        $containerGroup = '';


//        Excel Experiment
        $contRefs = explode(' ',$request->contRef);
        $containerList = Blcontainer::join('mloblinformations', 'mloblinformations.id',  'mloblinformation_id')
            ->where('mloblinformations.bolreference', $bolreference)
            ->whereIn('contref', $contRefs)
            ->get();
//        Excel Experiment



//        $containerList = Blcontainer::join('mloblinformations', 'mloblinformations.id',  'mloblinformation_id')
//            ->where('mloblinformations.bolreference', $bolreference)
//            ->where('contref', 'like', '%'.$contRef.'%')
//            ->get();



        if($containerList){
            return view('ctrack/emptyContainers.containerList', compact('containerList', 'bolreference', 'containerGroup'));
        }else{
            return redirect()->back()->withErrors("Sorry no data found based on the information given.");
        }
    }



    public function bulkEdit(Request $request)
    {

//        dd($request->all());

        try{
            $data = $request->only('blcontainer_id', 'bolreference', 'location', 'depoName');
            $data['date'] = date('Y-m-d', strtotime(request('date')));
            $data['emptyStatus'] = 'Empty';
            $data['chassisDelivery'] = $request->has('chassisDelivery') ? 1 : 0;

            Blcontainer::whereIn('id', $request->blcontainer_id)->update(['containerStatus'=>$request->movementType]);
            foreach($request->contref as $key => $contref){
                EmptyContainer::create(
                    [
                        'blcontainer_id' => $request->blcontainer_id[$key],
                        'contref' => $contref,
                        'bolreference' => $data['bolreference'],
                        'date' => $data['date'],
                        'location' => $data['location'],
                        'depoName' => $data['depoName'],
                        'chassisDelivery' => $data['chassisDelivery'],
                        'containerStatus' => $request->movementType,
                    ]
                );
            }
            return redirect()->back()->with('message','Empty date updated successfully.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

}
