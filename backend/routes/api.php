<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupeController;
use App\Http\Controllers\API\EtudiantController;
use App\Http\Controllers\API\AbsenceController;

Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('groupes', GroupeController::class);

Route::apiResource('etudiants', EtudiantController::class);

Route::get(
    '/groupes/{groupe_id}/etudiants',
    [AbsenceController::class, 'getEtudiantsByGroupe']
);

Route::post('/absences', [AbsenceController::class, 'store']);