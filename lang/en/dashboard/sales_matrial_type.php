<?php
return [
    // general
    'sales_matrial_types'   => 'Sales Invoice Categories',
    'sales_matrial_type'    => 'Sales Invoice Category',
    'create'                => 'Add Category',
    'edit'                  => 'Edit Category',
    'show'                  => 'Category Details',
    'delete'                => 'Delete Category',

    // fields
    'name'                  => 'Category Name',
    'is_active'             => 'Status',
    'company'               => 'Company',
    'created_by'            => 'Created By',
    'updated_by'            => 'Updated By',
    'created_at'            => 'Created At',
    'updated_at'            => 'Updated At',

    // messages
    'created_successfully'  => 'Category created successfully',
    'updated_successfully'  => 'Category updated successfully',
    'deleted_successfully'  => 'Category deleted successfully',
    'restored_successfully' => 'Category restored successfully',
    'status_updated'        => 'Status updated successfully',
    'not_found'             => 'Category not found',
    'delete_confirm'        => 'Are you sure you want to delete ":name"?',

    // validation
    'validation' => [
        'name_required' => 'Category name in :locale is required',
        'name_string'   => 'Category name in :locale must be a string',
        'name_max'      => 'Category name in :locale must not exceed 255 characters',
    ],
];