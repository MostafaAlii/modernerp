<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('treasuries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_master')->default(false)->comment('خزينة رئيسية أم فرعية');
            $table->unsignedInteger('last_exchange_receipt')->default(0)->comment('رقم آخر إيصال صرف');
            $table->unsignedInteger('last_collect_receipt')->default(0)->comment('رقم آخر إيصال تحصيل');
            $table->date('date')->nullable();
            $table->boolean('is_active')->default(true)->comment('الحالة');
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('treasury_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treasury_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['treasury_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_translations');
        Schema::dropIfExists('treasuries');
    }
};
