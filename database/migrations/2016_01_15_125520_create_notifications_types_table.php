<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_types', function(Blueprint $table)
        {
            $table->string('type_id', 50);
            $table->string('name', 50);
            $table->enum('action', ['redirect'])->default('redirect');
            $table->primary('type_id');
        });

        /**
         * Default inserts
         */
        DB::table('notifications_types')->insert([
            'type_id'   => 'mail.new',
            'name'      => '{{ $name }} send you new message',
            'action'    => 'redirect'
        ]);

    }
}
