<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTeamsolomonPiangoonlineIssues extends Migration
{
    public function up()
    {
        Schema::create('teamsolomon_piangoonline_issues', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('issue_id');
            $table->string('title');
            $table->text('description');
            $table->integer('nlu_id');
            $table->string('file');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('teamsolomon_piangoonline_issues');
    }
}
