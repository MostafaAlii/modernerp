<?php

return [
    // Titles
    'store' => 'مخزن',
    'stores' => 'المخازن',
    'create' => 'إضافة مخزن جديد',
    'edit' => 'تعديل المخزن',
    'delete' => 'حذف المخزن',

    // Fields
    'name' => 'اسم المخزن',
    'phone' => 'رقم الهاتف',
    'address' => 'العنوان',
    'is_active' => 'الحالة',
    'company' => 'الشركة',
    'date' => 'التاريخ',

    // Messages
    'created_successfully' => 'تم إنشاء المخزن بنجاح',
    'updated_successfully' => 'تم تعديل المخزن بنجاح',
    'deleted_successfully' => 'تم حذف المخزن بنجاح',
    'status_updated' => 'تم تحديث حالة المخزن بنجاح',
    'delete_confirm' => 'هل أنت متأكد من حذف المخزن ":name"؟',

    // Actions
    'add_new' => 'إضافة مخزن',
    'edit_action' => 'تعديل',
    'delete_action' => 'حذف',

    // Badges
    'active' => 'نشط',
    'inactive' => 'غير نشط',

    'validation' => [
        'name_required' => 'اسم المخزن باللغة :locale مطلوب',
        'name_string' => 'اسم المخزن باللغة :locale يجب أن يكون نصاً',
        'name_max' => 'اسم المخزن باللغة :locale يجب ألا يزيد عن :max حرف',

        'phone_regex' => 'رقم الهاتف يجب أن يكون بصحيح (مثال: 0123456789 أو +20123456789)',
        'phone_min' => 'رقم الهاتف يجب ألا يقل عن :min أرقام',
        'phone_max' => 'رقم الهاتف يجب ألا يزيد عن :max رقم',

        'date_valid' => 'التاريخ يجب أن يكون تاريخاً صحيحاً',
        'address_string' => 'العنوان يجب أن يكون نصاً',
        'address_max' => 'العنوان يجب ألا يزيد عن :max حرف',
        'is_active_boolean' => 'حالة التفعيل يجب أن تكون نشط أو غير نشط',
    ],
];