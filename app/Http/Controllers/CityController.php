<?php

namespace App\Http\Controllers;

use App\Models\Api\City;
use Illuminate\Http\Request;
use App\Http\Traits\MessageTrait;
use Illuminate\Support\Facades\{
    Validator, DB
};

class CityController extends Controller
{
    use MessageTrait;

    private $City;

    private $Fields = [
        'cities.id',
        'city',
        'state',
        'country',
    ];

    private $Rules = [
        'country_id' => 'required|integer|exists:App\Models\Api\Country,id',
        'state_id' => 'required|integer|exists:App\Models\Api\State,id',
    ];

    public function __construct(City $city, Request $request)
    {
        $this->City = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            DB::table('cities')
              ->join('countries', 'countries.id', 'country_id')
              ->join('states', 'states.id', 'state_id')
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
        $validator = Validator::make($request->all(), $this->Rules);
        if ($validator->fails())
            return $this->msgMissingValidator($validator);

        $this->City->country_id = $request->country_id;
        $this->City->state_id = $request->state_id;

        if (($request->has('City')) && ($request->city <> '')) {
            $duplicatedCity = $this->City->selectRaw($this->fields)
                                         ->where('city', $request->city)
                                         ->first();
            if (!$duplicatedCity) {
                $this->City->city = $request->city;
                $this->City->fcity = $request->city;
                $this->City->save();
            }
        }

        if ($duplicatedCity)
            return $this->msgDuplicatedField('city', $duplicatedCity);
        else
            return $this->msgInclude($this->City);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($id, int $iid = 0)
    {
        if (is_numeric($id))
            return response()->json(
                DB::table('cities')
                  ->join('countries', 'countries.id', 'country_id')
                  ->join('states', 'states.id', 'state_id')
                  ->select($this->Fields)
                  ->where('id', $id)
                  ->get()
                  ->toArray()
            );

        elseif ($id=='help')
            return $this->help();
        else {
            $fCity = phonetics($id);
            return response()->json(
                DB::table('cities')
                  ->join('countries', 'countries.id', 'country_id')
                  ->join('states', 'states.id', 'state_id')
                  ->select($this->Fields)
                  ->where('fcity', 'like', "%{$fCity}%")
                  ->orderBy('city')
                  ->get()
                  ->toArray()
            );
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Api\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(int $id = 0, Request $request)
    {
        $requiredField = count($request->all()) > 0;
        if ($requiredField == 0)
            return $this->msgNoParameterInformed();

        $aCity = $this->City->find($id);
        if (!$aCity)
            return $this->msgRecordNotFound();

        if ($request->has('state_id')) {
            $validator = Validator::make($request->all(),
                ['state_id' => $this->Rules['state_id']]);

            if ($validator->fails())
                return $this->msgMissingField('state_id', $validator);

            $aCity->state_id = $request->state_id;
        }

        if ($request->has('country_id')) {
            $validator = Validator::make($request->all(),
                ['country_id' => $this->Rules['country_id']]);

            if ($validator->fails())
                return $this->msgMissingField('country_id', $validator);

            $aCity->country_id = $request->country_id;
        }

        if (($request->has('city')) && ($request->city <> '')) {
            $duplicatedCity = $this->City->selectRaw($this->fields)
                                         ->where('city', $request->city)
                                         ->first();
            if (!$duplicatedCity) {
                $aCity->city = $request->city;
                $aCity->fcity = $request->city;
                $aCity->save();
            }
        }

        if ($duplicatedCity)
            return $this->msgDuplicatedField('City', $duplicatedCity);
        else
            return $this->msgUpdated($aCity);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id = 0)
    {
        return $this->msgNotAuthorized();
    }

    private function help()
    {
        return response()->json([
            'data' => [
                '[ GET ]  /city/help'   => 'Informações sobre o point solicitado.',
                '[ GET ]  /city'        => 'Apresenta todas as cidades cadastradas no sistema.',
                '[ GET ]  /city/{ID}'   => 'Apresenta cidade pelo id',
                '[ GET ]  /city/{name}' => 'Apresenta cidde informada pelo nome inteiro ou parcial.',
                '[ POST ] /city' => [
                    '{state_id}',
                    '{country_id}',
                    '{city}',
                ],
                '[ PUT ] /city/{ID}' => [
                    'state_id',
                    'country_id',
                    'city'
                ],
            ]
        ]);
    }


}
