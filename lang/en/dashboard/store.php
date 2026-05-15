<?php

return [
    // Titles
    'store' => 'Store',
    'stores' => 'Stores',
    'create' => 'Add New Store',
    'edit' => 'Edit Store',
    'delete' => 'Delete Store',

    // Fields
    'name' => 'Store Name',
    'phone' => 'Phone Number',
    'address' => 'Address',
    'is_active' => 'Status',
    'company' => 'Company',
    'date' => 'Date',

    // Messages
    'created_successfully' => 'Store created successfully',
    'updated_successfully' => 'Store updated successfully',
    'deleted_successfully' => 'Store deleted successfully',
    'status_updated' => 'Store status updated successfully',
    'delete_confirm' => 'Are you sure you want to delete store ":name"?',

    // Actions
    'add_new' => 'Add Store',
    'edit_action' => 'Edit',
    'delete_action' => 'Delete',

    // Badges
    'active' => 'Active',
    'inactive' => 'Inactive',

    'validation' => [
        'name_required' => 'Store name in :locale is required',
        'name_string' => 'Store name in :locale must be a string',
        'name_max' => 'Store name in :locale must not exceed :max characters',

        'phone_regex' => 'Phone number must be valid (e.g., 0123456789 or +20123456789)',
        'phone_min' => 'Phone number must be at least :min digits',
        'phone_max' => 'Phone number must not exceed :max digits',

        'date_valid' => 'Date must be a valid date',
        'address_string' => 'Address must be a string',
        'address_max' => 'Address must not exceed :max characters',
        'is_active_boolean' => 'Status must be active or inactive',
    ],
];