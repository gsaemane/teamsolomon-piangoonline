<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTeamsolomonPiangoonlineIssues9 extends Migration
{
    public function up()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->dateTime('due_date')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->dateTime('due_date')->nullable(false)->change();
        });
    }
}
