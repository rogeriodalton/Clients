<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNeighborhoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('neighborhood', 50)->unique();;
            $table->string('fneighborhood', 50);
            $table->timestamps();
        });

        $f = [
            'Centro' => phonetics('Centro'),
        ];

        DB::table('neighborhoods')->insert([
            ['neighborhood' => 'Centro',
            'fneighborhood' => $f['Centro'],
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
        Schema::dropIfExists('neighborhoods');
    }
}
