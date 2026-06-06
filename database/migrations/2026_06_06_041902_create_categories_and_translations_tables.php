<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('الشركة');
            $table->foreignId('created_by')->nullable()->constrained('admins')->cascadeOnDelete()->comment('أنشئ بواسطة');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('عدل بواسطة');
            $table->timestamps();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unique(['category_id', 'locale']);
            $table->index(['category_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
    }
};