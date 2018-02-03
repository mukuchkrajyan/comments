<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->charset = 'utf8';
            $table->increments('commentid');
            //$table->primary('commentid');
            $table->integer('item_id');
            $table->mediumText('description')->nullable(false);
            $table->integer('userid')->nullable(false);
            $table->timestamp('date')->nullable(false);

            $table->index('userid');
            $table->index('item_id');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE comments ADD FULLTEXT comments_fts(description)');

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
