<?php

use App\Http\Controllers\MidtransController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('callback',[MidtransController::class,'Callback']);
