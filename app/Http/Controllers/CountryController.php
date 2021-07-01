<?php

namespace App\Http\Controllers;

use App\Models\Api\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Validator, DB
};

class CountryController extends Controller
{
    private $Country;

    private $Fields = [
        'id',
        'country',
    ];

    public function __construct(Country $country, Request $request)
    {
        $this->Country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            DB::table('countries')
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
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails())
            return $this->msgMissingValidator($validator);

        if (($request->has('Country')) && ($request->Country <> '')) {
            $duplicatedCountry = $this->Country->selectRaw($this->Fields)
                                               ->where('Country', $request->country)
                                               ->first();
            if (!$duplicatedCountry) {
                $this->Country->country = $request->country;
                $this->Country->fcountry = $request->country;
                $this->Country->save();
            }
        }

        if ($duplicatedCountry)
            return $this->msgDuplicatedField('country', $duplicatedCountry);
        else
            return $this->msgInclude($this->Country);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($id, int $iid = 0)
    {
        if ($id == 'help')
            return $this->help();
        else
            return $this->msgNotAuthorized();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Api\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        return $this->msgNotAuthorized();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        return $this->msgNotAuthorized();
    }

    private function help()
    {
        return response()->json([
            'data' => [
                '[ GET ]  /country/help' => 'Informações sobre o point solicitado.',
                '[ GET ]  /country'      => 'Apresenta Países',
                '[ POST ] /country' => [
                    '{country}',
                ],
                '[ PUT ] /country/{ID}' => [
                    'country',
                ],

            ]
        ]);
    }

}
