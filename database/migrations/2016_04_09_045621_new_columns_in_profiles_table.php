<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewColumnsInProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('partying_id')->nullable()->default(null)->unsigned();
            $table->integer('alcohol_id')->nullable()->default(null)->unsigned();
            $table->integer('smoking_id')->nullable()->default(null)->unsigned();
            $table->integer('imprecation_id')->nullable()->default(null)->unsigned();
            $table->integer('plannings_id')->nullable()->default(null)->unsigned();
            $table->integer('plans_id')->nullable()->default(null)->unsigned();
            $table->integer('vegetarian_id')->nullable()->default(null)->unsigned();
            $table->integer('flexibility_id')->nullable()->default(null)->unsigned();
            $table->integer('plans_change_id')->nullable()->default(null)->unsigned();
            $table->integer('verbosity_id')->nullable()->default(null)->unsigned();
            $table->integer('vigor_id')->nullable()->default(null)->unsigned();
            $table->integer('cool_id')->nullable()->default(null)->unsigned();
            $table->integer('rules_id')->nullable()->default(null)->unsigned();
            $table->integer('opinions_id')->nullable()->default(null)->unsigned();
            $table->integer('tolerance_id')->nullable()->default(null)->unsigned();
            $table->integer('compromise_id')->nullable()->default(null)->unsigned();
            $table->integer('feelings_id')->nullable()->default(null)->unsigned();
            $table->integer('emergency_id')->nullable()->default(null)->unsigned();

            $table->foreign('partying_id')->on('profiles_partying')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('alcohol_id')->on('profiles_alcohol')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('smoking_id')->on('profiles_smoking')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('imprecation_id')->on('profiles_imprecation')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('plannings_id')->on('profiles_plannings')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('plans_id')->on('profiles_plans')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vegetarian_id')->on('profiles_vegetarian')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('flexibility_id')->on('profiles_flexibility')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('plans_change_id')->on('profiles_plans_change')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('verbosity_id')->on('profiles_verbosity')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vigor_id')->on('profiles_vigor')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cool_id')->on('profiles_cool')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('rules_id')->on('profiles_rules')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('opinions_id')->on('profiles_opinions')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tolerance_id')->on('profiles_tolerance')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('compromise_id')->on('profiles_compromise')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('feelings_id')->on('profiles_feelings')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('emergency_id')->on('profiles_emergency')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
