<?php

namespace redzjovi\php;

class ArrayHelper
{
    /**
     * @param array $array
     * @param array $permissions
     * @param string $oldkey
     * @param string $newkey
     * @return void
     */
    public static function addKeyVisible($array, $permissions = [], $oldkey = 'auth_item_name', $newkey = 'visible')
    {
        if (is_array($array)) {
            foreach ((array) $array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::addKeyVisible($value, $permissions, $oldkey, $newkey);
                } else {
                    if (empty($array[$oldkey])) {
                        $array[$newkey] = true;
                    } else if ($permissions) {
                        $array[$newkey] = in_array($array[$oldkey], $permissions);
                    } else {
                        $array[$newkey] = false;
                    }
                }
            }
        }

        return $array;
    }

    /**
     * @param array $array
     * @return integer
     */
    public static function arraySumRecursive(array $array) : int
    {
        foreach ($array as $value)
        {
            if (is_array($value)) {
                $sum[] = self::arraySumRecursive($value);
            } else {
                $sum[] = $value;
            }
        }

        return array_sum($sum);
    }

    /**
     * array_merge_recursive does indeed merge arrays, but it converts values with duplicate
     * keys to arrays rather than overwriting the value in the first array with the duplicate
     * value in the second array, as array_merge does. I.e., with array_merge_recursive,
     * this happens (documented behavior):
     *
     * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('org value', 'new value'));
     *
     * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
     * Matching keys' values in the second array overwrite those in the first array, as is the
     * case with array_merge, i.e.:
     *
     * array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('new value'));
     *
     * Parameters are passed by reference, though only for performance reasons. They're not
     * altered by this function.
     *
     * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
     * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
     *
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    public static function array_merge_recursive_distinct(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = self::array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    /**
     * @param array $elements
     * @param integer $parent
     * @return array
     */
    public static function buildTree($elements = [], $parent = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parent) {
                $children = self::buildTree($elements, $element['id']);
                if ($children)  {
                    $element['child'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * @param array $array
     * @param string $oldkey
     * @param string $newkey
     * @return array
     */
    public static function changeKeyName($array, $oldkey, $newkey)
    {
        if (is_array($array)) {
            foreach ((array) $array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::changeKeyName($value, $oldkey, $newkey);
                } else {
                    $array[$newkey] = $array[$oldkey];
                }
            }
        }

        unset($array[$oldkey]);
        return $array;
    }

    /**
     * @param array $array
     * @param string $oldkey
     * @param string $newkey
     * @return array
     */
    public static function copyKeyName($array, $oldkey, $newkey)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::copyKeyName($value, $oldkey, $newkey);
                } else {
                    $array[$newkey] = isset($array[$oldkey]) ? $array[$oldkey] : '';
                }
            }
        }

        return $array;
    }

    /**
     * get all parents (child-parent)
     * @param integer $id
     * @param array $data
     * @param array $parents
     * @return array $parents
     *
     * @example
     $categories = [
         ['id' => 5, 'parent_id' => 4, 'name' => 'Bedroom wear'],
         ['id' => 6, 'parent_id' => 3, 'name' => 'Rolex'],
         ['id' => 1, 'parent_id' => 0, 'name' => 'Men'],
         ['id' => 2, 'parent_id' => 0, 'name' => 'Women'],
         ['id' => 3, 'parent_id' => 1, 'name' => 'Watches'],
         ['id' => 4, 'parent_id' => 2, 'name' => 'Bras'],
         ['id' => 7, 'parent_id' => 2, 'name' => 'Jackets'],
     ];
     getParent(6, $categories);
     */
    public static function getParent($id, $data, $parents = [])
    {
        $index = array_search($id, array_column($data, 'id'));
        $parent_id = $data[$index]['parent_id'];

        if ($parent_id > 0) {
            $parent_index = array_search($parent_id, array_column($data, 'id'));
            array_unshift($parents, $parent_index);
            return self::getParent($parent_id, $data, $parents);
        }

        return $parents;
    }

    /**
     * @param array $elements
     * @param string $prefix
     * @param integer $parent
     * @param array $branch
     * @return array
     */
    public static function printTree($elements, $prefix = '-', $parent = 0, $branch = [])
    {
        foreach ($elements as $element) {
            $tree_prefix = ($element['parent'] == 0) ? '' : $prefix;
            $branch[$element['id']] = $element;
            $branch[$element['id']]['tree_name'] = isset($element['name']) ? $tree_prefix.$element['name'] : '';
            $branch[$element['id']]['tree_prefix'] = $tree_prefix;
            if (isset($element['child'])) {
                $branch = self::printTree($element['child'], $tree_prefix.$prefix, $element['parent'], $branch);
            }
        }

        return $branch;
    }
}
