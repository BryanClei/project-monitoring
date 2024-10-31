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
        Schema::create("monitoring", function (Blueprint $table) {
            $table->increments("id");
            $table->string("system_id");
            $table->string("user_id");
            $table->string("module");
            $table->string("description");
            $table->date("raise_date");
            $table->date("start_date");
            $table->date("end_date");
            $table->longText("remarks");
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("monitoring");
    }
};
