<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OnpeController extends Controller
{
    // 1. Participación Ciudadana (Total Nacional o Extranjero)
    public function getVotos($tipo = 'nacional')
    {
        $inicio = ($tipo === 'extranjero') ? 26 : 1;
        $fin    = ($tipo === 'extranjero') ? 30 : 25;

        $votos = DB::select('call sp_getVotos(?, ?)', [$inicio, $fin]);

        return response()->json([
            'success' => !empty($votos),
            'data'    => $votos,
            'message' => !empty($votos) ? 'Registros encontrados' : 'No se encontraron datos'
        ], !empty($votos) ? 200 : 404);
    }

    // 2. Votos por Departamento
    public function getVotosDepartamento($departamento)
    {
        $votos = DB::select('call sp_getVotosDepartamento(?)', [$departamento]);

        return response()->json([
            'success' => !empty($votos),
            'data'    => $votos,
            'message' => !empty($votos) ? 'Registros encontrados' : 'No se encontraron datos'
        ], !empty($votos) ? 200 : 404);
    }

    // 3. Votos por Provincia
    public function getVotosProvincia($provincia)
    {
        $votos = DB::select('call sp_getVotosProvincia(?)', [$provincia]);

        return response()->json([
            'success' => !empty($votos),
            'data'    => $votos,
            'message' => !empty($votos) ? 'Registros encontrados' : 'No se encontraron datos'
        ], !empty($votos) ? 200 : 404);
    }

    // 4. Consulta de Acta por Número (ej. '000169')
    public function getGrupoVotacion($id)
    {
        $acta = DB::selectOne('call sp_getGrupoVotacion(?)', [$id]);

        return response()->json([
            'success' => !empty($acta),
            'data'    => $acta,
            'message' => !empty($acta) ? 'Acta encontrada' : 'Acta no encontrada'
        ], !empty($acta) ? 200 : 404);
    }

    // 5. Ubigeo: Departamentos
    public function getDepartamentos($ambito = 'peru')
    {
        $inicio = ($ambito === 'extranjero') ? 26 : 1;
        $fin    = ($ambito === 'extranjero') ? 30 : 25;

        $departamentos = DB::select('call sp_getDepartamentos(?, ?)', [$inicio, $fin]);

        return response()->json([
            'success' => !empty($departamentos),
            'data'    => $departamentos
        ], 200);
    }

    // 6. Ubigeo: Provincias por Departamento
    public function getProvinciasByDepartamento($departamento)
    {
        $provincias = DB::select('call sp_getProvinciasByDepartamento(?)', [$departamento]);

        return response()->json([
            'success' => !empty($provincias),
            'data'    => $provincias
        ], 200);
    }

    // 7. Ubigeo: Distritos por Provincia
    public function getDistritosByProvincia($provincia)
    {
        $distritos = DB::select('call sp_getDistritosByProvincia(?)', [$provincia]);

        return response()->json([
            'success' => !empty($distritos),
            'data'    => $distritos
        ], 200);
    }

    // 8. Ubigeo: Locales de Votación
    public function getLocalesVotacion($provincia, $distrito)
    {
        $locales = DB::select('call sp_getLocalesVotacionByDistrito(?, ?)', [$provincia, $distrito]);

        return response()->json([
            'success' => !empty($locales),
            'data'    => $locales
        ], 200);
    }

    // 9. Ubigeo: Grupos de Votación (Mesas)
    public function getGruposVotacion($provincia, $distrito, $local)
    {
        $grupos = DB::select('call sp_getGruposVotacionByProvinciaDistritoLocal(?, ?, ?)', [
            $provincia,
            $distrito,
            $local
        ]);

        return response()->json([
            'success' => !empty($grupos),
            'data'    => $grupos
        ], 200);
    }
}