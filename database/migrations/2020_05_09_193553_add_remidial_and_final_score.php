<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemidialAndFinalScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->tinyInteger('remedial_score')->default(0)->after('is_remedial');
            $table->float('final_score')->default(0)->after('remedial_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->dropColumn(['remedial_score', 'final_score']);
        });
    }
}
