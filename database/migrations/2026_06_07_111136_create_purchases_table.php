<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->comment('Unique purchase identifier');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete()->comment('المورد');
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete()->comment('الفرع / المخزن');
            $table->string('invoice_number')->unique()->nullable()->comment('رقم فاتورة المورد');
            $table->date('invoice_date')->nullable()->comment('تاريخ الفاتورة');
            $table->decimal('total_amount', 10, 2)->default(0)->comment('إجمالي الفاتورة قبل الخصم');
            $table->decimal('discount', 10, 2)->default(0)->comment('الخصم');
            $table->decimal('net_amount', 10, 2)->default(0)->comment('الإجمالي بعد الخصم');
            $table->decimal('paid_amount', 10, 2)->default(0)->comment('المبلغ المدفوع');
            $table->decimal('remaining_amount', 10, 2)->default(0)->comment('المبلغ المتبقي');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=Draft, 2=Confirmed, 3=Cancelled');
            $table->text('notes')->nullable()->comment('ملاحظات');
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('الشركة');
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete()->comment('أنشئ بواسطة');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('عدل بواسطة');
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->comment('Unique purchase identifier');
            $table->foreignId('purchase_id')->constrained('purchases')->cascadeOnDelete()->comment('الفاتورة');
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete()->comment('الـ variant المشترى');
            $table->foreignId('sales_unit_id')->constrained('sales_units')->cascadeOnDelete()->comment('وحدة البيع - قطعة / جملة / نص جملة');
            $table->integer('quantity')->default(1)->comment('الكمية المشتراة');
            $table->decimal('unit_price', 10, 2)->default(0)->comment('سعر الوحدة');
            $table->decimal('total_price', 10, 2)->default(0)->comment('الإجمالي = quantity × unit_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
    }
};
