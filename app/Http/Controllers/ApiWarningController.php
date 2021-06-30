<?php

namespace App\Http\Controllers;

class ApiWarningController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Controllers\ApiWarning  $ApiWarning
     * @return \Illuminate\Http\Response
     */
    public function warning()
    {
        return response()->json(['message' => 'Atenção: O ID alvo para essa requisição não foi informado.']);
    }

    /**
     * Rota sem acesso
     *
     * @param  App\Http\Controllers\ApiWarning  $ApiWarning
     * @return \Illuminate\Http\Response
     */
    public function noAccess()
    {
        return response()->json(['message' => 'Atenção: Requisição não autorizada.']);
    }

}
