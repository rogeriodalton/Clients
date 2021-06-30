<?php

namespace App\Http\Controllers;

use App\Models\Api\Neighborhood;
use Illuminate\Http\Request;
use App\Http\Traits\MessageTrait;
use Illuminate\Support\Facades\DB;

class NeighborhoodController extends Controller
{
    use MessageTrait;

    private $Neighborhood;

    private $Fields = [
        'id',
        'neighborhood',
    ];

    public function __construct(Neighborhood $neighborhood, Request $request)
    {
        $this->Neighborhood = $neighborhood;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            DB::table('neighborhoods')
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
        if  ((!$request->has('neighborhood')) || ($request->neighborhood == ''))
            return $this->msgMissingRequest($request);

        $phrase = phonetics($request->neighborhood);
        $duplicatedNeighborhood  = $this->Neighborhood->selectRaw($this->Fields)
                                                       ->where('fneighborhood', $phrase)
                                                       ->first();

        if (!$duplicatedNeighborhood) {
            $this->Neighborhood->neighborhood = $request->neighborhood;
            $this->Neighborhood->fneighborhood = $request->neighborhood;
            $this->Neighborhood->save();
        }

        if ($duplicatedNeighborhood)
            return $this->msgDuplicatedField('Neighborhood', $duplicatedNeighborhood);
        else
            return $this->msgInclude($this->Neighborhood);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function show($id, int $iid = 0)
    {
        if (is_numeric($id))
            return response()->json(
                DB::table('neighborhoods')
                  ->select($this->Fields)
                  ->where('id', $id)
                  ->get()
                  ->toArray()
            );
        elseif ($id == 'help')
            return $this->help();
        else {
            $phrase = phonetics($id);
            return response()->json(
                DB::table('neighborhoods')
                  ->select($this->Fields)
                  ->where('fneighborhood', 'like', "%{$phrase}%")
                  ->get()
                  ->toArray()
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Api\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function edit(Neighborhood $neighborhood)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id = 0, Request $request)
    {
        $requiredField = count($request->all()) > 0;
        if ($requiredField == 0)
            return $this->msgNoParameterInformed();

        $aNeighborhood = $this->Neighborhood->find($id);
        if (!$aNeighborhood)
            return $this->msgRecordNotFound();

        if (($request->has('neighborhood')) && ($request->neighborhood <> '')) {
            $phrase = phonetics($request->neighborhood);
            $duplicatedNeighborhood = $this->Neighborhood->selectRaw($this->Fields)
                                           ->where('fneighborhood', $phrase)
                                           ->first();

            if (!$duplicatedNeighborhood) {
                $aNeighborhood->neighborhood = $request->neighborhood;
                $aNeighborhood->fneighborhood = $request->neighborhood;
                $aNeighborhood->save();
            }
        }

        if ($duplicatedNeighborhood)
            return $this->msgDuplicatedField('Neighborhood', $duplicatedNeighborhood);
        else
            return $this->msgUpdated($aNeighborhood);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Neighborhood $neighborhood)
    {
        return $this->msgNotAuthorized();
    }

    private function help()
    {
        return response()->json([
            'data' => [
                '[ GET ]  /neighborhood/help'   => 'Informações sobre o point solicitado.',
                '[ GET ]  /neighborhood'        => 'Apresenta todos os bairros que são utilizado em cadastros',
                '[ GET ]  /neighborhood/{name}' => 'Apresenta todos os bairros disponiveis por nome',
                '[ POST ] /neighborhood' => [
                    '{neighborhood}'
                ],
                '[ PUT ]  /neighborhood/ID' => [
                    'neighborhood'
                ],
            ]
        ]);
    }

}
