<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'spaces' => [
        'name' => 'Spaces',
        'index_title' => 'Spaces List',
        'new_title' => 'New Space',
        'create_title' => 'Create Space',
        'edit_title' => 'Edit Space',
        'show_title' => 'Show Space',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],

    'trips' => [
        'name' => 'Trips',
        'index_title' => 'Trips List',
        'new_title' => 'New Trip',
        'create_title' => 'Create Trip',
        'edit_title' => 'Edit Trip',
        'show_title' => 'Show Trip',
        'inputs' => [
            'space_id' => 'Space',
            'name' => 'Name',
            'description' => 'Description',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
        ],
    ],

    'expenses' => [
        'name' => 'Expenses',
        'index_title' => 'Expenses List',
        'new_title' => 'New Expense',
        'create_title' => 'Create Expense',
        'edit_title' => 'Edit Expense',
        'show_title' => 'Show Expense',
        'inputs' => [
            'trip_id' => 'Trip',
            'user_id' => 'User',
            'description' => 'Description',
            'type' => 'Type',
            'amount' => 'Amount',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
