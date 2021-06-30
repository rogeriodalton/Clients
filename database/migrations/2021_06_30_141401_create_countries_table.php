<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('country', 30)->unique();
            $table->string('fcountry', 30);
            $table->timestamps();
        });

        $f = [
            'Brasil' => phonetics('Brasil')
        ];

        DB::table('countries')->insert([
            [
                'country' => 'Brasil',
                'fcountry' => $f['Brasil'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
