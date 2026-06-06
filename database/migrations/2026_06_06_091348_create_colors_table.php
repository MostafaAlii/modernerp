<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('hex_code', 7)->default('#000000')->comment('كود اللون');
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('الشركة');
            $table->foreignId('created_by')->nullable()->constrained('admins')->cascadeOnDelete()->comment('أنشئ بواسطة');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('عدل بواسطة');
            $table->timestamps();
        });

        Schema::create('color_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->unique(['color_id', 'locale']);
            $table->index(['color_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_translations');
        Schema::dropIfExists('colors');
    }
};