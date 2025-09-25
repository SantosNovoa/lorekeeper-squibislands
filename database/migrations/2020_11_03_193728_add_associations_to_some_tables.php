<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssociationsToSomeTables extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('event_prompts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('prompt_id')->unsigned();
        });

        Schema::create('event_newses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('news_id')->unsigned();
        });

        Schema::create('location_prompts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('prompt_id')->unsigned();
        });

        Schema::table('faunas', function (Blueprint $table) {
            $table->string('scientific_name')->nullable();
        });

        Schema::table('floras', function (Blueprint $table) {
            $table->string('scientific_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::dropIfExists('location_prompts');
        Schema::dropIfExists('event_newses');
        Schema::dropIfExists('event_prompts');

        Schema::table('faunas', function (Blueprint $table) {
            $table->dropColumn('scientific_name');
        });

        Schema::table('floras', function (Blueprint $table) {
            $table->dropColumn('scientific_name');
        });
    }
}
