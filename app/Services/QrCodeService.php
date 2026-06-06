<?php
namespace App\Services;
use App\Models\ProductVariant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class QrCodeService {
    /**
     * توليد QR Code للـ variant
     */
    public function generateForVariant(ProductVariant $variant): ?string
    {
        // البيانات اللي هتتخزن في الـ QR
        $qrData = json_encode([
            'type'       => 'product_variant',
            'id'         => $variant->id,
            'sku'        => $variant->sku,
            'barcode'    => $variant->barcode,
            'product_id' => $variant->product_id,
        ]);
        
        // توليد الـ QR Code كـ PNG
        $qrCodePng = QrCode::format('svg')
            ->size(500)
            ->errorCorrection('H')
            ->margin(2)
            ->generate($qrData);
        
        // إنشاء ملف مؤقت من الـ PNG
        $tempPath = storage_path('app/temp/qr_' . $variant->id . '_' . time() . '.svg');
        
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0777, true);
        }
        
        file_put_contents($tempPath, $qrCodePng);
        
        // تحويل الملف المؤقت إلى UploadedFile
        $uploadedFile = new UploadedFile(
            $tempPath,
            'qr_' . $variant->sku . '.svg',
            'image/svg+xml',
            null,
            true
        );
        
        // استخدام الـ trait بتاعك
        $fileName = $variant->uploadSingleMedia(
            baseFolder: 'qrcodes',
            file: $uploadedFile,
            model: $variant,
            column: null,
            relation: 'media',
            useStorage: true,           // true عشان يحفظ في public_path
            generateThumbnail: false,
            collectionName: 'qr_code',  // الـ collection_name هيكون qr_code
            addWatermark: false
        );
        
        // حذف الملف المؤقت
        if (file_exists($tempPath)) {
            unlink($tempPath);
        }
        
        // تحديث الـ variant بمسار الـ QR
        $variant->update([
            'qr_code' => "uploads/qrcodes/{$fileName}"
        ]);
        
        return $fileName;
    }
    
    /**
     * حذف QR Code للـ variant
     */
    public function deleteForVariant(ProductVariant $variant): void
    {
        $variant->deleteExistingMedia(
            baseFolder: 'qrcodes',
            model: $variant,
            column: null,
            relation: 'media',
            useStorage: true,
            collectionName: 'qr_code'
        );
        
        $variant->update(['qr_code' => null]);
    }
    
    /**
     * تجديد QR Code للـ variant
     */
    public function regenerateForVariant(ProductVariant $variant): ?string
    {
        $this->deleteForVariant($variant);
        return $this->generateForVariant($variant);
    }
}