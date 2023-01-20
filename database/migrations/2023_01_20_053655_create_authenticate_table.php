<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Authenticate', function (Blueprint $table) {
            $table->bigIncrements('id')
                ->autoIncrement();
            $table->string('name');
            $table->text('routes');
            $table->string('token');
            $table->timestamp('created_at')
                ->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Authenticate');
    }
};
