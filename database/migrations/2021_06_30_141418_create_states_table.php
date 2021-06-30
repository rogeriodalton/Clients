<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('state', 30)->unique();
            $table->string('fstate', 30);
            $table->string('uf', 2)->unique();
            $table->timestamps();
         });

        $f = [
            'AC' => phonetics('Acre'),
            'AL' => phonetics('Alagoas'),
            'AP' => phonetics('Amapá'),
            'AM' => phonetics('Amazonas'),
            'BA' => phonetics('Bahia'),
            'CE' => phonetics('Ceará'),
            'DF' => phonetics('Distrito Federal'),
            'ES' => phonetics('Espírito Santo'),
            'GO' => phonetics('Goiás'),
            'MA' => phonetics('Maranhão'),
            'MT' => phonetics('Mato Grosso'),
            'MS' => phonetics('Mato Grosso do Sul'),
            'MG' => phonetics('Minas Gerais'),
            'PA' => phonetics('Pará'),
            'PB' => phonetics('Paraíba'),
            'PR' => phonetics('Paraná'),
            'PE' => phonetics('Pernambuco'),
            'PI' => phonetics('Piauí'),
            'RJ' => phonetics('Rio de Janeiro'),
            'RN' => phonetics('Rio Grande do Norte'),
            'RS' => phonetics('Rio Grande do Sul'),
            'RO' => phonetics('Rondônia'),
            'RR' => phonetics('Roraima'),
            'SC' => phonetics('Santa Catarina'),
            'SP' => phonetics('São Paulo'),
            'SE' => phonetics('Sergipe'),
            'TO' => phonetics('Tocantins')
        ];

        DB::table('states')->insert([
            ['country_id' => 1,
             'state' => 'Acre',
             'fstate' => $f['AC'],
             'uf' => 'AC',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Alagoas',
             'fstate' => $f['AL'],
             'uf' => 'AL',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Amapá',
             'fstate' => $f['AP'],
             'uf' => 'AP',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Amazonas',
             'fstate' => $f['AM'],
             'uf' => 'AM',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Bahia',
             'fstate' => $f['BA'],
             'uf' => 'BA',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Ceará',
             'fstate' => $f['CE'],
             'uf' => 'CE',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Distrito Federal',
             'fstate' => $f['DF'],
             'uf' => 'DF',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Espírito Santo',
             'fstate' => $f['ES'],
             'uf' => 'ES',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Goiás',
             'fstate' => $f['GO'],
             'uf' => 'GO',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Maranhão',
             'fstate' => $f['MA'],
             'uf' => 'MA',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Mato Grosso',
             'fstate' => $f['MT'],
             'uf' => 'MT',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Mato Grosso do Sul',
             'fstate' => $f['MS'],
             'uf' => 'MS',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Minas Gerais',
             'fstate' => $f['MG'],
             'uf' => 'MG',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Pará',
             'fstate' => $f['PA'],
             'uf' => 'PA',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Paraíba',
             'fstate' => $f['PB'],
             'uf' => 'PB',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Paraná',
             'fstate' => $f['PR'],
             'uf' => 'PR',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Pernambuco',
             'fstate' => $f['PE'],
             'uf' => 'PE',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Piauí',
             'fstate' => $f['PI'],
             'uf' => 'PI',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Rio de Janeiro',
             'fstate' => $f['RJ'],
             'uf' => 'RJ',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Rio Grande do Norte',
             'fstate' => $f['RN'],
             'uf' => 'RN',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Rio Grande do Sul',
             'fstate' => $f['RS'],
             'uf' => 'RS',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Rondônia',
             'fstate' => $f['RO'],
             'uf' => 'RO',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Roraima',
             'fstate' => $f['RR'],
             'uf' => 'RR',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Santa Catarina',
             'fstate' => $f['SC'],
             'uf' => 'SC',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'São Paulo',
             'fstate' => $f['SP'],
             'uf' => 'SP',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Sergipe',
             'fstate' => $f['SE'],
             'uf' => 'SE',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],

             ['country_id' => 1,
             'state' => 'Tocantins',
             'fstate' => $f['TO'],
             'uf' => 'TO',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now(),
            ],
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
