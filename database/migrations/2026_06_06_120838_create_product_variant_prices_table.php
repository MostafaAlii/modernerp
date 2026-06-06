<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variant_prices', function (Blueprint $table) {
            $table->id();
                        $table->uuid()->unique()->comment('Variant unique identifier');
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete()
                ->comment('Related product variant');
            $table->foreignId('sales_unit_id')
                ->constrained('sales_units')
                ->cascadeOnDelete()
                ->comment('Unit type - piece / wholesale / half wholesale');
            $table->decimal('price', 10, 2)
                ->default(0)
                ->comment('Selling price for this unit type');
            $table->decimal('cost_price', 10, 2)
                ->default(0)
                ->comment('Cost price for profit calculation');
            $table->timestamps();

            $table->unique(
                ['product_variant_id', 'sales_unit_id'],
                'variant_unit_price_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variant_prices');
    }
};