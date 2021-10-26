<?php

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => 'web'], function () {

    /**
     * 顯示所有任務
     */
    Route::get('/', function () {
        //
    });

    /**
     * 增加新的任務
     */
    Route::post('/task', function (Request $request) {
        //
    });

    /**
     * 刪除任務
     */
    Route::delete('/task/{task}', function (Task $task) {
        //
    });
});