<?php
return [
    // general
    'treasuries'            => 'Treasuries',
    'treasury'              => 'Treasury',
    'create'                => 'Add Treasury',
    'edit'                  => 'Edit Treasury',
    'show'                  => 'Treasury Details',
    'delete'                => 'Delete Treasury',

    // fields
    'name'                  => 'Treasury Name',
    'is_master'             => 'Type',
    'is_active'             => 'Status',
    'last_exchange_receipt' => 'Last Exchange Receipt No.',
    'last_collect_receipt'  => 'Last Collect Receipt No.',
    'receipts'              => 'Last Receipts No.',
    'last_collect_receipt'  => 'Collect',
    'last_exchange_receipt' => 'Exchange',
    'no_receipt'            => 'N/A',
    'date'                  => 'Date',
    'company'               => 'Company',
    'created_by'            => 'Created By',
    'updated_by'            => 'Updated By',
    'created_at'            => 'Created At',
    'updated_at'            => 'Updated At',

    // type
    'master'                => 'Main',
    'sub'                   => 'Sub',

    // messages
    'created_successfully'  => 'Treasury created successfully',
    'updated_successfully'  => 'Treasury updated successfully',
    'deleted_successfully'  => 'Treasury deleted successfully',
    'restored_successfully' => 'Treasury restored successfully',
    'status_updated'        => 'Status updated successfully',
    'not_found'             => 'Treasury not found',

    'delete_confirm' => 'Are you sure you want to delete ":name"?',

    'validation' => [
        'name_required' => 'Treasury name in :locale is required',
        'name_string'   => 'Treasury name in :locale must be a string',
        'name_max'      => 'Treasury name in :locale must not exceed 255 characters',
        'receipt_integer'  => 'Receipt number must be an integer',
    'receipt_min'      => 'Receipt number must be greater than or equal to zero',
    ],
];