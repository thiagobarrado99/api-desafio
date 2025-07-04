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
        Schema::create('bill_historics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("bill_id");
            $table->string("type");
            $table->string("status");
            $table->string("payload");
            $table->timestamps();

            $table->foreign("bill_id")->references("id")->on("bills")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_historics');
    }
};
