<?php


Route::group(['middleware'=>['auth', 'preventBackHistory']], function(){
    Route::get('/attendanceszkteco', 'Payroll\AttendanceController@attendanceszkteco')->name('attendanceszkteco');


    Route::get('attendancereport', 'Payroll\AttendanceController@attendancereport');
    Route::resource('attendances', 'Payroll\AttendanceController');

    //this route is for creating user on zkteco machine but setUser function isn't working perfectly.
    Route::resource('zktecousers', 'Payroll\ZktecouserController');
});

