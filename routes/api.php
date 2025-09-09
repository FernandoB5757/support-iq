<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tickets', TicketController::class)
    ->middleware('api');

Route::name('tickets.classify')
    ->post('tickets/{ticket}/classify', [TicketController::class, 'classify'])
    ->middleware(['api', 'throttle:api.openai']);
