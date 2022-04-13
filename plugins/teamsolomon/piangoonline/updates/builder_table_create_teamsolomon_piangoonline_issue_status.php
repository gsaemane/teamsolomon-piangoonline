<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTeamsolomonPiangoonlineIssueStatus extends Migration
{
    public function up()
    {
        Schema::create('teamsolomon_piangoonline_issue_status', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('issue_id');
            $table->integer('status_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('teamsolomon_piangoonline_issue_status');
    }
}
