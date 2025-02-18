<?php

namespace App\Http\Controllers\Payroll;

use App\Payroll\Zktecouser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rats\Zkteco\Lib\ZKTeco;

class ZktecouserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $zk;
    public function __construct(){
//        $zk = new ZKTeco('192.168.88.240'); //magnetism static ip
        $zk = new ZKTeco('192.168.0.103');
        $zk->connect();
        $this->zk = $zk;

    }

    public function index()
    {
        $zkAttendances = $this->zk->getUser();
        dd($zkAttendances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create an user but it isn't working perfectly. After 1 insertation its not working.
//        $this->zk->setUser(15,15, "Narayan", "12345678");




//        $this->zk->removeUser(9);

//        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zktecouser  $zktecouser
     * @return \Illuminate\Http\Response
     */
    public function show(Zktecouser $zktecouser)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zktecouser  $zktecouser
     * @return \Illuminate\Http\Response
     */
    public function edit(Zktecouser $zktecouser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zktecouser  $zktecouser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zktecouser $zktecouser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zktecouser  $zktecouser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zktecouser $zktecouser)
    {
        //
    }
}
