<?php

return [
    // Titles
    'inv_uom' => 'وحدة قياس',
    'inv_uoms' => 'وحدات القياس',
    'create' => 'إضافة وحدة قياس جديدة',
    'edit' => 'تعديل وحدة القياس',
    'delete' => 'حذف وحدة القياس',

    // Fields
    'name' => 'اسم الوحدة',
    'is_active' => 'الحالة',
    'is_master' => 'نوع الوحدة',
    'master' => 'رئيسية',
    'sub' => 'فرعية',
    'company' => 'الشركة',
    'date' => 'التاريخ',

    // Messages
    'created_successfully' => 'تم إنشاء وحدة القياس بنجاح',
    'updated_successfully' => 'تم تعديل وحدة القياس بنجاح',
    'deleted_successfully' => 'تم حذف وحدة القياس بنجاح',
    'status_updated' => 'تم تحديث حالة وحدة القياس بنجاح',
    'master_updated' => 'تم تحديث نوع وحدة القياس بنجاح',
    'delete_confirm' => 'هل أنت متأكد من حذف وحدة القياس ":name"؟',
    'select_company' => 'اختار الشركه...',

    // Actions
    'add_new' => 'إضافة وحدة قياس',
    'edit_action' => 'تعديل',
    'delete_action' => 'حذف',

    // Badges
    'active' => 'نشط',
    'inactive' => 'غير نشط',

    // Validation
    'validation' => [
        'name_required' => 'اسم وحدة القياس باللغة :locale مطلوب',
        'name_string' => 'اسم وحدة القياس باللغة :locale يجب أن يكون نصاً',
        'name_max' => 'اسم وحدة القياس باللغة :locale يجب ألا يزيد عن :max حرف',
        'date_valid' => 'التاريخ يجب أن يكون تاريخاً صحيحاً',
        'is_active_boolean' => 'حالة التفعيل يجب أن تكون نشط أو غير نشط',
        'is_master_boolean' => 'نوع الوحدة يجب أن يكون رئيسية أو فرعية',
    ],
];