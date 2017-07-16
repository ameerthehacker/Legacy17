<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table){
            $table->increments('id');
            $table->integer('category_id');    
            $table->string('title');            
            $table->text('description');
            $table->string('image_name')->nullable();                        
            $table->text('rules');                                    
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');            
            $table->integer('min_members');
            $table->integer('max_members');           
            $table->integer('max_limit');
            $table->string('contact_email');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
