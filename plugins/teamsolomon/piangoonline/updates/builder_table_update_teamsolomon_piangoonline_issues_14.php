<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTeamsolomonPiangoonlineIssues14 extends Migration
{
    public function up()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->string('nlu_name', 255)->default('NULL')->change();
        });
    }
    
    public function down()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->string('nlu_name', 10)->default('\'NULL\'')->change();
        });
    }
}
