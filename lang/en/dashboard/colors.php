<?php
return [
    'color'   => 'Color',
    'colors'  => 'Colors',
    'create'  => 'Add New Color',
    'edit'    => 'Edit Color',
    'delete'  => 'Delete Color',

    'name'      => 'Color Name',
    'hex_code'  => 'Color Code',
    'is_active' => 'Status',
    'company'   => 'Company',
    'date'      => 'Date',

    'created_successfully' => 'Color created successfully',
    'updated_successfully' => 'Color updated successfully',
    'deleted_successfully' => 'Color deleted successfully',
    'status_updated'       => 'Color status updated successfully',
    'delete_confirm'       => 'Are you sure you want to delete color ":name"?',

    'add_new'       => 'Add Color',
    'edit_action'   => 'Edit',
    'delete_action' => 'Delete',

    'active'   => 'Active',
    'inactive' => 'Inactive',

    'validation' => [
        'name_required'     => 'Color name in :locale is required',
        'name_string'       => 'Color name in :locale must be a string',
        'name_max'          => 'Color name in :locale must not exceed :max characters',
        'hex_code_required' => 'Color code is required',
        'hex_code_invalid'  => 'Color code is invalid, must be in #RRGGBB format',
        'is_active_boolean' => 'Status must be active or inactive',
    ],
];