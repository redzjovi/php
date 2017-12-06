<?php 

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use redzjovi\php\ArrayHelper;

$categories = [
    ['id' => 5, 'parent_id' => 4, 'name' => 'Bedroom wear'],
    ['id' => 6, 'parent_id' => 3, 'name' => 'Rolex'],
    ['id' => 1, 'parent_id' => 0, 'name' => 'Men'],
    ['id' => 2, 'parent_id' => 0, 'name' => 'Women'],
    ['id' => 3, 'parent_id' => 1, 'name' => 'Watches'],
    ['id' => 4, 'parent_id' => 2, 'name' => 'Bras'],
    ['id' => 7, 'parent_id' => 2, 'name' => 'Jackets'],
];
$parents = ArrayHelper::getParent(6, $categories);

echo '<pre>';
var_dump($parents);
