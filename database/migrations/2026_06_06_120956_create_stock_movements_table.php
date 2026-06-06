<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete()
                ->comment('Related product variant');
            $table->foreignId('store_id')
                ->nullable()
                ->constrained('stores')
                ->nullOnDelete()
                ->comment('Store/warehouse where movement happened');
            $table->unsignedTinyInteger('type')
                ->comment('1=Purchase, 2=Sale, 3=Return, 4=Adjustment');
            $table->integer('quantity')
                ->comment('Quantity moved - positive=in, negative=out');
            $table->integer('quantity_before')
                ->default(0)
                ->comment('Stock quantity before this movement');
            $table->integer('quantity_after')
                ->default(0)
                ->comment('Stock quantity after this movement');
            $table->decimal('unit_price', 10, 2)
                ->default(0)
                ->comment('Price per unit at time of movement');
            $table->text('notes')
                ->nullable()
                ->comment('Optional notes about this movement');
            $table->nullableMorphs('reference');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete()
                ->comment('User who created this movement');
            $table->timestamps();

            $table->index(['product_variant_id', 'type']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};