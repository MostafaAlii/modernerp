<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inv_uoms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_active')->default(true)->comment('الحالة');
            $table->boolean('is_master')->default(false)->comment('نوع الوحدة: رئيسية أو فرعية');
            $table->date('date')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('الشركة');
            $table->foreignId('created_by')->nullable()->constrained('admins')->cascadeOnDelete()->comment('أنشئ بواسطة');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('عدل بواسطة');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `inv_uoms` COMMENT 'جدول وحدات القياس'");
        Schema::create('inv_uom_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_uom_id')->constrained('inv_uoms')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name')->comment('اسم الوحدة');
            $table->unique(['inv_uom_id', 'locale'], 'inv_uom_locale_unique');
        });
        DB::statement("ALTER TABLE `inv_uom_translations` COMMENT 'جدول ترجمات وحدات القياس'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_uom_translations');
        Schema::dropIfExists('inv_uoms');
    }
};