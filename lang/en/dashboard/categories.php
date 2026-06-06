<?php

return [
    // Titles
    'category' => 'Category',
    'categories' => 'Categories',
    'create' => 'Create New Category',
    'edit' => 'Edit Category',
    'delete' => 'Delete Category',

    // Fields
    'name' => 'Category Name',
    'short_description' => 'Short Description',
    'description' => 'Description',
    'parent' => 'Parent Category',
    'is_active' => 'Status',
    'company' => 'Company',
    'date' => 'Date',

    // Messages
    'created_successfully' => 'Category created successfully',
    'updated_successfully' => 'Category updated successfully',
    'deleted_successfully' => 'Category deleted successfully',
    'status_updated' => 'Category status updated successfully',
    'delete_confirm' => 'Are you sure you want to delete category ":name"?',

    // Actions
    'add_new' => 'Add Category',
    'edit_action' => 'Edit',
    'delete_action' => 'Delete',

    // Badges
    'active' => 'Active',
    'inactive' => 'Inactive',
    'type_main' => 'Main Category',
'type_sub' => 'Sub Category',
'cannot_delete_with_children' => 'Cannot delete category because it has sub categories',

    // Validation
    'validation' => [
        'name_required' => 'Category name in :locale is required',
        'name_string' => 'Category name in :locale must be a string',
        'name_max' => 'Category name in :locale must not exceed :max characters',

        'short_description_max' => 'Short description must not exceed :max characters',
        'description_string' => 'Description must be a string',

        'parent_exists' => 'Invalid parent category selected',

        'is_active_boolean' => 'Status must be active or inactive',
    ],
];