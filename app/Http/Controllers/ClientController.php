<?php

namespace App\Http\Controllers;

use App\Models\Api\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Validator, Hash, DB
};

class ClientController extends Controller
{
    private $Client;

    private $Fields = [
        'clients.id',
        'name',
        'email',
        'phone',
        'zipcode',
        'address',
        'address_number',
        'city',
        'states.state',
        'country'
    ];

    private $Rules = [
        'city_id'   => 'required|integer|exists:App\Models\Api\City,id',
        'neighborhood_id' => 'required|integer|exists:App\Models\Api\Neighborhood,id',
        'name' => 'required|string|max:80',
        'email' => 'required|string|max:50',
        'password' => 'required|string|max:50',
        'phone' => 'required|string|max:20',
        'zipcode' => 'required|string|max:8',
        'address_number' => 'required|string|max:10',
        'address' => 'required|string|max:80',
    ];

    public function __construct(Client $client)
    {
        $this->Client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            DB::table('clients')
              ->join('neighborhoods', 'neighborhoods.id', 'clients.neighborhood_id')
              ->join('cities', 'cities.id', 'clients.city_id')
              ->join('states', 'states.id', 'cities.state_id')
              ->join('countries', 'countries.id', 'cities.country_id')
              ->select($this->Fields)
              ->where('clients.active', '1')
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
     */
    public function store(string $id = '', Request $request)
    {
        $validator = Validator::make($request->all(), $this->Rules);

        if ($validator->fails())
            return $this->msgMissingValidator($validator);

        $this->Client->city_id = $request->city_id;
        $this->Client->neighborhood_id = $request->neighborhood_id;
        $this->Client->name = $request->name;
        $this->Client->fname = $request->name;
        $this->Client->email = $request->email;
        $this->Client->password = Hash::make($request->password);
        $this->Client->phone = $request->phone;
        $this->Client->zipcode = $request->zipcode;
        $this->Client->address_number = $request->address_number;
        $this->Client->address = $request->address;

        if ($request->has('receive_news'))
            $this->Client->receive_news = $request->receive_news;

        if ($request->has('active'))
                $this->Client->active = $request->active;

        $this->Collaborator->save();
        return $this->msgInclude($this->Client);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, int $iid = 0)
    {
        if (is_numeric($id))
            return response()->json(
                DB::table('clients')
                ->join('neighborhoods', 'neighborhoods.id', 'clients.neighborhood_id')
                ->join('cities', 'cities.id', 'collaborators.city_id')
                ->join('states', 'states.id', 'cities.state_id')
                ->join('countries', 'countries.id', 'cities.country_id')
                ->select($this->Fields)
                ->where('clients.active', '1')
                ->get()
                ->toArray()
            );
        elseif ($id=='help')
            return $this->help();
        else {
            $phonetics = phonetics($id);
            return response()->json(
                DB::table('clients')
                ->join('neighborhoods', 'neighborhoods.id', 'clients.neighborhood_id')
                ->join('cities', 'cities.id', 'clients.city_id')
                ->join('states', 'states.id', 'cities.state_id')
                ->join('countries', 'countries.id', 'cities.country_id')
                ->select($this->Fields)
                ->where('collaborators.fname','like', "%{$phonetics}%")
                ->get()
                ->toArray()
            );
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Api\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
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

        $aClient = $this->Client->find($id);
        if (!$aClient)
            return $this->msgRecordNotFound();

        if ($request->has('city_id')) {
            $validator = Validator::make($request->all(),
                ['city_id' => $this->Rules['city_id']]);

            if ($validator->fails())
                return $this->msgMissingField('city_id', $validator);

            $aClient->city_id = $request->city_id;
        }

        if ($request->has('neighborhood_id')) {
            $validator = Validator::make($request->all(),
                ['neighborhood_id' => $this->rules['neighborhood_id']]);

            if ($validator->fails())
                return $this->msgMissingField('neighborhood_id', $validator);

            $aClient->neighborhood_id = $request->neighborhood_id;
        }

        if ($request->has('name')) {
            $aClient->name = $request->name;
            $aClient->fname = $request->name;
        }

        if ($request->has('email'))
            $aClient->email = $request->email;

        if ($request->has('phone'))
            $aClient->phone = $request->phone;

        if ($request->has('zipcode'))
            $aClient->zipcode = $request->zipcode;

        if ($request->has('address'))
            $aClient->address = $request->address;

        if ($request->has('address_number'))
            $aClient->address_number = $request->address_number;

        if ($request->has('password'))
            $aClient->password = Hash::make($request->password);

        if ($request->has('receive_news'))
            $aClient->receive_news = $request->receive_news;

        $aClient->save();

        return $this->msgUpdated($aClient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id = 0)
    {
        $aClient = $this->Client->find($id);
        if (!$aClient)
            return $this->msgRecordNotFound();

        $aClient->active = 0;
        $aClient->save();
        return $this->msgRecordDisabled($aClient);
    }

    private function help()
    {
        return response()->json([
            'data' => [
                '[ GET ]  /client/help'   => 'Informações sobre o point solicitado.',
                '[ GET ]  /client'        => 'Apresenta os clientes',
                '[ GET ]  /client/{ID}'   => 'Apresenta o cliente pelo id',
                '[ GET ]  /client/{name}' => 'Apresenta cliente pelo nome',
                '[ POST ] /client' => [
                        '{city_id}',
                        '{neighborhood_id}',
                        '{name}',
                        '{email}',
                        '{password}',
                        '{zipcode}',
                        '{phone}',
                        '{address_number}',
                        '{address}',
                        'receive_news',
                        'active',
                ],
                '[ PUT ] /client/{ID}' => [
                        'city_id',
                        'neighborhood_id',
                        'name',
                        'email',
                        'password',
                        'zipcode',
                        'phone',
                        'address_number',
                        'address',
                        'receive_news',
                        'active',
                ],
                '[DELETE] /client/{ID}' => 'Desabilita sem excluir o registro selecionado.',
            ],
        ]);
    }


}
