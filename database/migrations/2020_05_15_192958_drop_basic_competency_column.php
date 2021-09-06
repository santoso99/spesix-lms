<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBasicCompetencyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_topics', function (Blueprint $table) {
            $table->dropColumn('basic_competency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_topics', function (Blueprint $table) {
            $table->text('basic_competency')->after('user_id');
        });
    }
}
