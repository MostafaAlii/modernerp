<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('Unique product identifier');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete()->comment('Product category');
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete()->comment('Brand of product (optional)');
            $table->unsignedTinyInteger('variant_type')->default(0)->comment('0=Simple, 1=Color, 2=Size, 3=Color+Size');
            $table->boolean('has_barcode')->default(true)->comment('Enable barcode generation');
            $table->boolean('has_qr')->default(false)->comment('Enable QR code generation');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete()->comment('Company owner');
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete()->comment('User created this product');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete()->comment('Last user updated this product');
            $table->timestamps();
        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->comment('Related product');
            $table->string('locale')->comment('Language code (ar, en)');
            $table->string('name')->comment('Product name in specific language');
            $table->text('description')->nullable()->comment('Product description');
            $table->unique(['product_id', 'locale']);
            $table->index(['product_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('products');
    }
};