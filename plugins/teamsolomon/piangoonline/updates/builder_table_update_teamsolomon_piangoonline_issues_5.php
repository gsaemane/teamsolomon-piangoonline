<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTeamsolomonPiangoonlineIssues5 extends Migration
{
    public function up()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->dropColumn('status');
            $table->dropColumn('due_date');
        });
    }
    
    public function down()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->string('status', 191);
            $table->dateTime('due_date');
        });
    }
}
