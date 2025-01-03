<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('No title');
            $table->string('snippet')->nullable();
            $table->string('image')->default('https://picsum.photos/600/250');
            $table->longText('content')->nullable();
            $table->enum('source', ['news-api', 'the-guardian', 'new-york-times'])->index();
            $table->string('author')->nullable()->index();
            $table->string('category')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('articles');
    }
};
