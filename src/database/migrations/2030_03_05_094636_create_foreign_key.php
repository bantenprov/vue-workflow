<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transition_states', function(Blueprint $table){
            $table->foreign('history_id')
            ->references('id')
            ->on('histories')
            ->onDelete('set null')
            ->onUpdate('restrict');
        });
        Schema::table('histories', function(Blueprint $table){
            $table->foreign('workflow_id')
            ->references('id')
            ->on('workflows')
            ->onDelete('set null')
            ->onUpdate('restrict');
        });
        Schema::table('histories', function(Blueprint $table){
            $table->foreign('workflow_transition_id')
            ->references('id')
            ->on('workflow_transition')
            ->onDelete('set null')
            ->onUpdate('restrict');
        });
        Schema::table('workflow_transition', function(Blueprint $table){
            $table->foreign('workflow_id')
            ->references('id')
            ->on('workflows')
            ->onDelete('set null')
            ->onUpdate('restrict');
        });
        Schema::table('workflow_state', function(Blueprint $table){
            $table->foreign('workflow_id')
            ->references('id')
            ->on('workflows')
            ->onDelete('set null')
            ->onUpdate('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transition_states', function(Blueprint $table) {
            $table->dropForeign('transition_states_history_id_foreign');         
        });
        Schema::table('histories', function(Blueprint $table) {
            $table->dropForeign('histories_workflow_id_foreign');
        });
        Schema::table('histories', function(Blueprint $table) {
            $table->dropForeign('histories_workflow_transition_id_foreign');
        });
        Schema::table('workflow_state', function(Blueprint $table) {
            $table->dropForeign('workflow_state_workflow_id_foreign');
        });
        Schema::table('workflow_transition', function(Blueprint $table) {
            $table->dropForeign('workflow_transition_workflow_id_foreign');
        });
    }
}
