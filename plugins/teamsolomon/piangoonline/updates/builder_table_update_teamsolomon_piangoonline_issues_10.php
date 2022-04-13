<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTeamsolomonPiangoonlineIssues10 extends Migration
{
    public function up()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->string('country');
            $table->string('category');
            $table->string('nlu_submit_description');
            $table->renameColumn('nlu', 'nlu_name');
        });
    }
    
    public function down()
    {
        Schema::table('teamsolomon_piangoonline_issues', function($table)
        {
            $table->dropColumn('country');
            $table->dropColumn('category');
            $table->dropColumn('nlu_submit_description');
            $table->renameColumn('nlu_name', 'nlu');
        });
    }
}
