<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HashIt
 *
 * @author user
 */
class HashIt {

    /**
     * Sets a value in a nested array based on path
     * See http://stackoverflow.com/a/9628276/419887
     *
     * @param array $array The array to modify
     * @param string $path The path in the array
     * @param mixed $value The value to set
     * @param string $delimiter The separator for the path
     * @return The previous value
     */
    public static function set_nested_array_value(&$array, $path, $value, $delimiter = '/') {
        $pathParts = explode($delimiter, $path);

        $current = &$array;
        foreach ($pathParts as $key) {
            if(!is_array($current)){
                $current = [];
            }
            if(!isset($current[$key])){
                $current[$key] = [];
            }
            $current = &$current[$key];
        }

        $backup = $current;
        $current = $value;

        return $backup;
    }

}
