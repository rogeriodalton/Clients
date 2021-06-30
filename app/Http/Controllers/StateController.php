<?php

namespace App\Http\Controllers;

use App\Models\Api\State;
use Illuminate\Http\Request;
use App\Http\Traits\MessageTrait;
use Illuminate\Support\Facades\{
    Validator, DB
};

class StateController extends Controller
{
    use MessageTrait;

    private $State;

    private $Fields = [
        'country',
        'state',
        'uf',
    ];

    private $Rules = [
        'country_id'   => 'required|integer|exists:App\Models\Api\Country,id',
    ];

    public function __construct(State $state, Request $request)
    {
        $this->State = $state;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            DB::table('states')
              ->join('countries', 'countries.id', 'states.country_id')
              ->select($this->Fields)
              ->get()
              ->toArray()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->msgNotAuthorized();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show($id, int $iid = 0)
    {
        if (is_numeric($id))
            return response()->json(
                DB::table('states')
                ->join('countries', 'countries.id', 'states.country_id')
                ->select($this->Fields)
                ->where('id', $id)
                ->get()
                ->toArray()
            );
        elseif ($id=='help')
            return $this->help();
        else {
            //$id é um texto. Testar se é UF caso contrário faz a pesquisa em fonética
            $aUf = strtoupper($id);
            if (strlen($aUf) == 2)
                return response()->json(
                    DB::table('states')
                    ->join('countries', 'countries.id', 'states.country_id')
                    ->select($this->Fields)
                    ->where('uf', $aUf)
                    ->get()
                    ->toArray()
                );

            $fState = phonetics($id);
            return response()->json(
                DB::table('states')
                ->join('countries', 'countries.id', 'states.country_id')
                ->select($this->Fields)
                ->where('fstate', 'like' , "%{$fState}%")
                ->get()
                ->toArray()
            );
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Api\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        return $this->msgNotAuthorized();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        return $this->msgNotAuthorized();
    }

    private function help()
    {
        return response()->json([
            'data' => [
                '[ GET ]  /state/help'   => 'Informações sobre o point solicitado.',
                '[ GET ]  /state'        => 'Apresenta todos os estados brasileiros',
                '[ GET ]  /state/{ID}'   => 'Apresenta estado pelo id',
                '[ GET ]  /state/{name}' => 'Apresenta estado pelo UF caso tenha 2 letras ou pesquisa fonéticamente o estado quanto tem mais de duas letras.',
                ]
        ]);
    }

}
