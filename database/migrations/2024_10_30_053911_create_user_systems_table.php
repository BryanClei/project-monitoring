<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("user_systems", function (Blueprint $table) {
            $table->increments("id");

            $table->unsignedInteger("user_id")->index();
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users");

            $table->unsignedInteger("system_id")->index();
            $table
                ->foreign("system_id")
                ->references("id")
                ->on("projects");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("user_systems");
    }
};
