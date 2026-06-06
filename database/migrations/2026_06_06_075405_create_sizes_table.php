<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('الشركة');
            $table->foreignId('created_by')->nullable()->constrained('admins')->cascadeOnDelete()->comment('أنشئ بواسطة');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('عدل بواسطة');
            $table->timestamps();
        });

        Schema::create('size_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('size_id')->constrained('sizes')->cascadeOnDelete();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->unique(['size_id', 'locale']);
            $table->index(['size_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('size_translations');
        Schema::dropIfExists('sizes');
    }
};