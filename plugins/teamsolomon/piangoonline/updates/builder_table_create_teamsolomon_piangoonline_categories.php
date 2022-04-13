<?php namespace TeamSolomon\PiangoOnline\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTeamsolomonPiangoonlineCategories extends Migration
{
    public function up()
    {
        Schema::create('teamsolomon_piangoonline_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('teamsolomon_piangoonline_categories');
    }
}
