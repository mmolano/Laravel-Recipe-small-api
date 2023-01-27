<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('recipe', function (Blueprint $table) {
            $table->bigIncrements('id')
                ->autoIncrement();
            $table->string('name');
            $table->string('difficultyType');
            $table->integer('timeToPrepare');
            $table->text('ingredients');
            $table->text('videoLink');
            $table->text('foodCountry');
            $table->timestamp('created_at')
                ->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe');
    }
};
