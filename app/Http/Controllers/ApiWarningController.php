<?php

namespace App\Http\Controllers;

use App\Models\Api\ApiWarning;
use Illuminate\Http\Request;

class ApiWarningController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Controllers\ApiWarning  $ApiWarning
     * @return \Illuminate\Http\Response
     */
    public function warning(ApiWarning $apiWarning)
    {
        return response()->json(['message' => 'Atenção: O ID alvo para essa requisição não foi informado.']);
    }

    /**
     * Rota sem acesso
     *
     * @param  App\Http\Controllers\ApiWarning  $ApiWarning
     * @return \Illuminate\Http\Response
     */
    public function noAccess(ApiWarning $apiWarning)
    {
        return response()->json(['message' => 'Atenção: Requisição não autorizada.']);
    }

}
