<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('sales_matrial_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_active')->default(true)->comment('الحالة');
            $table->date('date')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('الشركة');
            $table->foreignId('created_by')->nullable()->constrained('admins')->cascadeOnDelete()->comment('أنشئ بواسطة');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('عدل بواسطة');
            $table->timestamps();
        });
        Schema::create('sales_matrial_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_matrial_type_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['sales_matrial_type_id', 'locale'],'smt_type_locale_unique');
        });
    }

    public function down(): void {
        Schema::dropIfExists('sales_matrial_type_translations');
        Schema::dropIfExists('sales_matrial_types');
    }
};
