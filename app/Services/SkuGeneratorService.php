<?php

namespace App\Services;

use App\Models\{Product,ProductVariant};
class SkuGeneratorService {
    public function generateProductSku(Product $product): string {
        $prefix = 'PRD';
        $productId = str_pad($product->id, 5, '0', STR_PAD_LEFT);
        $random = strtoupper(substr(uniqid(), -4));    
        return "{$prefix}-{$productId}-{$random}";
    }
    
    public function generateVariantSku(Product $product, array $variantData): string {
        $productCode = str_pad($product->id, 4, '0', STR_PAD_LEFT);
        $identifier = '';
        if (!empty($variantData['color_id'])) {
            $identifier .= "C{$variantData['color_id']}";
        }
        if (!empty($variantData['size_id'])) {
            $identifier .= "S{$variantData['size_id']}";
        }
        if (empty($identifier)) {
            $identifier = 'DEF';
        }
        $random = strtoupper(substr(uniqid(), -4));
        $sku = "SKU-{$productCode}-{$identifier}-{$random}";
        return $this->makeUniqueSku($sku);
    }

    public function generateBarcode(): string {
        do {
            $barcode = '62' . str_pad(random_int(1, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (ProductVariant::where('barcode', $barcode)->exists());
        return $barcode;
    }
    
    /**
     * التأكد من أن الـ SKU مش مكرر
     */
    private function makeUniqueSku(string $baseSku): string {
        $counter = 1;
        $sku = $baseSku;        
        while (ProductVariant::where('sku', $sku)->exists()) {
            $sku = $baseSku . '-' . $counter;
            $counter++;
        }
        return $sku;
    }
}