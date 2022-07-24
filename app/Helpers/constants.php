<?php

define('DATE_FORMAT', 'd-m-Y');
define('DATE_TIME_FORMAT', 'd-m-Y H:i A');

# Expense Type
define('EXPENSE_TYPE_FUEL', 'fuel');
define('EXPENSE_TYPE_FOOD', 'food');
define('EXPENSE_TYPE_SNACK', 'snack');
define('EXPENSE_TYPE_ENTRY', 'entry');
define('EXPENSE_TYPE_MISC', 'misc');
define('EXPENSE_TYPE_OTHERS', 'others');
define('EXPENSE_TYPES', [
    EXPENSE_TYPE_FUEL => 'Fuel',
    EXPENSE_TYPE_FOOD => 'Food',
    EXPENSE_TYPE_SNACK => 'Snack',
    EXPENSE_TYPE_ENTRY => 'Entry',
    EXPENSE_TYPE_MISC => 'Misc',
    EXPENSE_TYPE_OTHERS => 'Others',
]);
