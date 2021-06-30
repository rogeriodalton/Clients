<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('city', 50)->unique();;
            $table->string('fcity', 50);
            $table->timestamps();
        });

        $f = [
            'Rio de Janeiro' => phonetics('Rio de Janeiro'),
            'Curitiba' => phonetics('Curitiba')
        ];

        DB::table('cities')->insert([
            ['state_id' => 19,
            'country_id' => 1,
            'city' => 'Rio de Janeiro',
            'fcity' => $f['Rio de Janeiro'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ],

            ['state_id' => 16,
             'country_id' => 1,
             'city' => 'Curitiba',
             'fcity' => $f['Curitiba'],
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
        Schema::dropIfExists('cities');
    }
}
