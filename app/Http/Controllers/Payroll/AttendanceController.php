<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Payroll\Attendance;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestType = request()->requestType;
        $dateType = request()->dateType;
        $fromDate = request()->fromDate ? Carbon::createFromFormat('d/m/Y', request()->fromDate)->startOfDay() : null;
        $tillDate = request()->tillDate ? Carbon::createFromFormat('d/m/Y', request()->tillDate)->endOfDay() : null;

        $attendances = Attendance::latest()->get();
//        dd($attendances);
//        dd($attendances);

        return view('payroll.attendances.index', compact('requestType','dateType','fromDate','tillDate', 'attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('payroll.attendances.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $officeInTime = Carbon::createFromFormat('H:i', '9:30');
        $officeOutTime = Carbon::createFromFormat('H:i', '17:30');

        $inTime = Carbon::createFromFormat('H:i', $request->in_time);
        $outTime = Carbon::createFromFormat('H:i', $request->out_time);

        $late = $officeInTime->diffInMinutes($inTime, false);
        $early = $outTime->diffInMinutes($officeOutTime, false);

        try{
            $attendanceData = $request->only('date','employee_id','status','in_time','out_time');
            $attendanceData['late'] = $late > 0 ? $late : null;
            $attendanceData['early'] = $early > 0 ? $early : null;
            Attendance::create($attendanceData);
            return redirect()->route('attendances.index')->with('message','Attendance Created Successfully');

        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $formType = 'edit';
        return view('payroll.attendances.create', compact('formType', 'attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $officeInTime = Carbon::createFromFormat('H:i', '9:30');
        $officeOutTime = Carbon::createFromFormat('H:i', '17:30');

        $inTime = Carbon::createFromFormat('H:i', $request->in_time);
        $outTime = Carbon::createFromFormat('H:i', $request->out_time);

        $late = $officeInTime->diffInMinutes($inTime, false);
        $early = $outTime->diffInMinutes($officeOutTime, false);

        try{
            $attendanceData = $request->only('date','employee_id','status','in_time','out_time');
            $attendanceData['late'] = $late > 0 ? $late : null;
            $attendanceData['early'] = $early > 0 ? $early : null;

            $attendance->update($attendanceData);
            return redirect()->route('attendances.index')->with('message','Attendance Updated Successfully');

        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function attendancereport()
    {
        $now = Carbon::createFromFormat('F', 'April');
        echo $now;

dd();
        return view('payroll.attendances.index', compact('requestType','dateType','fromDate','tillDate', 'attendances'));
    }

    public function attendanceszkteco(){
        $zk = new ZKTeco('192.168.88.240'); //magnetism static ip
//        $zk = new ZKTeco('192.168.0.103'); //sumon home ip
        $zk->connect();
        $zkAttendances = $zk->getAttendance();

//        $zkAttendances = [
//            ['timestamp' => '2021-03-04 9:20:00','id' => '1'],
//            ['timestamp' => '2021-03-04 9:22:00','id' => '1'],
//            ['timestamp' => '2021-03-04 9:31:00','id' => '1'],
//            ['timestamp' => '2021-03-04 9:40:00','id' => '2'],
//            ['timestamp' => '2021-03-04 11:00:00','id' => '3'],
//            ['timestamp' => '2021-03-04 11:40:00','id' => '4'],

//            ['timestamp' => '2021-03-04 15:00:00','id' => '1'],
//            ['timestamp' => '2021-03-04 17:30:00','id' => '2'],
//            ['timestamp' => '2021-03-04 17:32:00','id' => '2'],
//            ['timestamp' => '2021-03-04 17:45:00','id' => '2'],
//            ['timestamp' => '2021-03-04 18:40:00','id' => '3'],
//            ['timestamp' => '2021-03-04 19:00:00','id' => '4'],
//        ];
//        dd($zkAttendances);

        $officeInTime = Carbon::createFromFormat('H:i', '9:30');
        $officeOutTime = Carbon::createFromFormat('H:i', '17:30');

        try{
            foreach($zkAttendances as $zkAttendance){
                $punchDate = Carbon::parse($zkAttendance['timestamp'])->format('Y-m-d');
                $punchTime = Carbon::createFromFormat('Y-m-d H:i:s', $zkAttendance['timestamp']);
                $attendance = Attendance::where('date', $punchDate)->where('employee_id', $zkAttendance['id'])->first();

                if($attendance!==null){
                    $lastPunch = Carbon::createFromFormat('H:i:s', $attendance->in_time);
                    $punchBreak = $punchTime->diffInMinutes($lastPunch);
                    if($punchBreak > 10){
                        $early = $punchTime->diffInMinutes($officeOutTime, false);

                        $attendance->update([
                            'out_time' => $punchTime,
                            'early' => $early > 0 ? $early : null,
                            'status' => $attendance->status == "absent" || $early > 120 ? "absent" : "present",
                        ]);
                    }
                }else{
                    $late = $officeInTime->diffInMinutes($punchTime->format('H:i'), false);
                    $data = [
                        'employee_id' => $zkAttendance['id'],
                        'date' => $punchDate,
                        'in_time' => Carbon::parse($zkAttendance['timestamp'])->format('H:i'),
                        'late' => $late > 0 ? $late : null,
                        'status' => $late > 120 ? "absent" : "present",
                    ];
                    Attendance::create($data);
                }
            }
            $zk->clearAttendance();
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

}
