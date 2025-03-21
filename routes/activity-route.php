<?php


Route::group(['middleware' => ['auth', 'preventBackHistory']], function () {

    Route::get('users/log/{id}', 'FRDActivityLogController@userlog');
    Route::get('masterbls/log/{id}', 'FRDActivityLogController@masterlog');
    Route::get('housebls/log/{id}', 'FRDActivityLogController@housebllog');
    Route::get('egmhousebls/log/{id}', 'FRDActivityLogController@egmhousebllog');
    Route::get('egmmoneyreceipts/log/{id}', 'FRDActivityLogController@egmmoneyreceiptlog');
    Route::get('moneyreceipts/log/{id}', 'FRDActivityLogController@moneyreceiptlog');
    Route::get('deliverorders/log/{id}', 'FRDActivityLogController@deliveryorderlog');
    Route::get('egmdeliveryorders/log/{id}', 'FRDActivityLogController@egmdeliveryorderlog');

    Route::get('feeders/log/{id}', 'MLO\MLOActivityLogController@feederslog');
    Route::get('egmfeeders/log/{id}', 'MLO\MLOActivityLogController@egmfeederslog');
    Route::get('blinformations/log/{id}', 'MLO\MLOActivityLogController@blinformationslog');
    Route::get('egmmloblinformations/log/{id}', 'MLO\MLOActivityLogController@egmblinformationslog');
    Route::get('mlomoneyreceipts/log/{id}', 'MLO\MLOActivityLogController@mlomoneyreceiptslog');
    Route::get('egmmlomoneyreceipts/log/{id}', 'MLO\MLOActivityLogController@egmmlomoneyreceiptslog');
    Route::get('mlodeliverorders/log/{id}', 'MLO\MLOActivityLogController@mlodeliverorderslog');
    Route::get('egmmlodeliverorders/log/{id}', 'MLO\MLOActivityLogController@egmmlodeliverorderslog');
});
