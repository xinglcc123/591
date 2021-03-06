<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\get591Controller;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Artisan::command('get591', function () {
//     $app = $this->comment(new get591Controller());
//     $app->get591();
// });

Artisan::command('get591', function () {
    $this->comment((new get591Controller())->get591());
});

Artisan::command('get59102', function() {
    $app = new \App\Http\Controllers\get591;
    $app->get591();
});

Artisan::command('sortgame', function() {
    $app = new \App\Http\Controllers\sortgame;
    $app->sortgame();
});