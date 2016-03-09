<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateVidibleTable.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class CreateVidibleTable extends Migration
{
    public function up()
    {
        Schema::create('vidible_video', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->integer('vidible_id')->unsigned()->nullable();
            $table->string('vidible_type')->nullable();

            $table->string('slot')->nullable();

            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();

            $table->string('mime_type');
            $table->string('extension');
            $table->string('orientation');

            $table->timestamps();

            // Indexes
            $table->unique(['vidible_id', 'vidible_type', 'slot'], 'U_vidible_slot');
        });
    }

    public function down()
    {
        Schema::drop('vidible_video');
    }
}
