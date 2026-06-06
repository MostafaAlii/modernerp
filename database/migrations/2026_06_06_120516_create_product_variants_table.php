<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('Variant unique identifier');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->comment('Related product');
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete()->comment('Color - null if variant_type=Simple or Size');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete()
                ->comment('Size - null if variant_type=Simple or Color');
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete()->comment('Store/warehouse location');
            $table->string('sku')->nullable()->unique()->comment('Stock Keeping Unit - auto generated or manual');
            $table->string('barcode')->nullable()->unique()->comment('Barcode value');
            $table->integer('quantity')->default(0)->comment('Available stock quantity - can be negative for returns');
            $table->unsignedInteger('min_stock_alert')->default(0)->comment('Minimum stock threshold before alert is triggered');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
            $table->timestamps();

            // منع تكرار نفس الـ combination في نفس المتجر
            $table->unique(
                ['product_id', 'color_id', 'size_id', 'store_id'],
                'variant_combination_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};