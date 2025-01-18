<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('m_code');
            $table->string('m_nid');
            $table->string('m_phone');
            $table->string('address');
            $table->integer('group_id');
            $table->integer('coop_id');
            $table->string('spouse_relation')->nullable();
            $table->string('spouse_name')->nullable();
            $table->integer('gender')->comment("1=Male,2=Female");
            $table->integer('status')->default(1)->comment("1=Active,2=Inactive");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
