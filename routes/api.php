<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::resource('tickets', TicketController::class);
