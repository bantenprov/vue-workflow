<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('content_type');
            $table->integer('content_id');
            $table->integer('workflow_id')->unsigned()->nullable();           
            $table->integer('workflow_transition_id')->unsigned()->nullable();            
            $table->integer('from_state');
            $table->integer('to_state');
            $table->integer('user_id');
            $table->text('message');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('histories'); 
    }
}
