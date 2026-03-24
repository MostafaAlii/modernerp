<?php

return [
    // عام
    'treasuries'            => 'الخزائن',
    'treasury'              => 'خزينة',
    'create'                => 'إضافة خزينة',
    'edit'                  => 'تعديل خزينة',
    'show'                  => 'تفاصيل خزينة',
    'delete'                => 'حذف خزينة',

    // الحقول
    'name'                  => 'اسم الخزينة',
    'is_master'             => 'النوع',
    'is_active'             => 'الحالة',
    'last_exchange_receipt' => 'رقم آخر إيصال صرف',
    'last_collect_receipt'  => 'رقم آخر إيصال تحصيل',
    'receipts'              => 'رقم آخر إيصال',
    'last_collect_receipt'  => 'تحصيل',
    'last_exchange_receipt' => 'صرف',
    'no_receipt'            => 'لا يوجد',
    'date'                  => 'التاريخ',
    'company'               => 'الشركة',
    'created_by'            => 'أنشئ بواسطة',
    'updated_by'            => 'عدل بواسطة',
    'created_at'            => 'تاريخ الإنشاء',
    'updated_at'            => 'تاريخ التعديل',

    // النوع
    'master'                => 'رئيسية',
    'sub'                   => 'فرعية',

    // رسائل
    'created_successfully'  => 'تم إضافة الخزينة بنجاح',
    'updated_successfully'  => 'تم تعديل الخزينة بنجاح',
    'deleted_successfully'  => 'تم حذف الخزينة بنجاح',
    'restored_successfully' => 'تم استعادة الخزينة بنجاح',
    'status_updated'        => 'تم تحديث الحالة بنجاح',
    'not_found'             => 'الخزينة غير موجودة',

    'delete_confirm' => 'هل أنت متأكد من حذف ":name"؟',


    'validation' => [
        'name_required' => 'اسم الخزينة باللغة :locale مطلوب',
        'name_string'   => 'اسم الخزينة باللغة :locale يجب أن يكون نصاً',
        'name_max'      => 'اسم الخزينة باللغة :locale يجب ألا يتجاوز 255 حرفاً',
    ],
];