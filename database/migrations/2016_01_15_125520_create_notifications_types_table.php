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
        Schema::create('notifications_types', function(Blueprint $table) {
            $table->string('type_id', 50);
            $table->string('name', 100);
            $table->enum('action', ['redirect'])->default('redirect');
            $table->primary('type_id');
        });

        /**
         * Default inserts
         */
        DB::table('notifications_types')->insert(['type_id' => 'mail.new', 'name' => '{{ $name }} send you new message', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.update', 'name' => 'Wydarzenie {{ $event }} zostało zmodyfikowane', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.members.new', 'name' => '{{ $user }} dołączył do wydarzenia {{ $event }}', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.members.join.member', 'name' => '{{ $user }} chce dołączyć do wydarzenia', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.members.join.follower', 'name' => '{{ $user }} obserwuje wydarzenie {{ $event }}', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.comment', 'name' => '{{ $user }} dodał komentarz do wydarzenia {{ $event }}', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.members.accept', 'name' => 'Zostałeś dodany do wydarzenia {{ $event }}', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.resign', 'name' => '{{ $user }} zrezygnował z wydarzenia {{ $event }}', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.limit', 'name' => 'Wydarzenie {{ $event }} ma komplet użytkowników', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.starting', 'name' => 'Wydarzenie {{ $event }} zaczęło się dzisiaj', 'action' => 'redirect']);
        DB::table('notifications_types')->insert(['type_id' => 'events.ending', 'name' => 'Wydarzenie {{ $event }} skończyło się dzisiaj', 'action' => 'redirect']);
    }
}
