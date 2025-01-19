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
        Schema::create('saving_deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('group_id');
            $table->integer('coop_id');
            $table->integer('s_account_id');
            $table->date('deposit_date');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_deposits');
    }
};
