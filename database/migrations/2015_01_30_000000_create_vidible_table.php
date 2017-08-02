<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
