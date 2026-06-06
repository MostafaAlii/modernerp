<?php

return [
    // Titles
    'category' => 'قسم',
    'categories' => 'الأقسام',
    'create' => 'إضافة قسم جديد',
    'edit' => 'تعديل القسم',
    'delete' => 'حذف القسم',
    'type_main' => 'قسم رئيسي',
'type_sub' => 'قسم فرعي',
'cannot_delete_with_children' => 'لا يمكن حذف القسم لأنه يحتوي على أقسام فرعية',
    // Fields
    'name' => 'اسم القسم',
    'short_description' => 'وصف مختصر',
    'description' => 'الوصف',
    'parent' => 'القسم الرئيسي',
    'is_active' => 'الحالة',
    'company' => 'الشركة',
    'date' => 'التاريخ',

    // Messages
    'created_successfully' => 'تم إنشاء القسم بنجاح',
    'updated_successfully' => 'تم تعديل القسم بنجاح',
    'deleted_successfully' => 'تم حذف القسم بنجاح',
    'status_updated' => 'تم تحديث حالة القسم بنجاح',
    'delete_confirm' => 'هل أنت متأكد من حذف القسم ":name"؟',

    // Actions
    'add_new' => 'إضافة قسم',
    'edit_action' => 'تعديل',
    'delete_action' => 'حذف',

    // Badges
    'active' => 'نشط',
    'inactive' => 'غير نشط',

    // Validation
    'validation' => [
        'name_required' => 'اسم القسم باللغة :locale مطلوب',
        'name_string' => 'اسم القسم باللغة :locale يجب أن يكون نصاً',
        'name_max' => 'اسم القسم باللغة :locale يجب ألا يزيد عن :max حرف',

        'short_description_max' => 'الوصف المختصر يجب ألا يزيد عن :max حرف',
        'description_string' => 'الوصف يجب أن يكون نصاً',

        'parent_exists' => 'القسم الرئيسي غير صحيح أو غير موجود',

        'is_active_boolean' => 'حالة التفعيل يجب أن تكون نشط أو غير نشط',
    ],
];