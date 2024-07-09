<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ReportGenerator;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/report-generator', ReportGenerator::class);