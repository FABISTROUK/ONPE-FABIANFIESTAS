<?php

use App\Http\Controllers\api\OnpeController;
use Illuminate\Support\Facades\Route;

Route::controller(OnpeController::class)->group(function () {
    // 1. Participación Ciudadana (Votos)
    Route::get('votos/{tipo?}', 'getVotos');
    Route::get('votos/departamento/{departamento}', 'getVotosDepartamento');
    Route::get('votos/provincia/{provincia}', 'getVotosProvincia');

    // 2. Consulta directa de Acta
    Route::get('acta/{id}', 'getGrupoVotacion');

    // 3. Ubigeo dinámico
    Route::get('departamentos/{ambito?}', 'getDepartamentos');
    Route::get('provincias/{departamento}', 'getProvinciasByDepartamento');
    Route::get('distritos/{provincia}', 'getDistritosByProvincia');
    Route::get('locales/{provincia}/{distrito}', 'getLocalesVotacion');
    Route::get('grupos/{provincia}/{distrito}/{local}', 'getGruposVotacion');
});