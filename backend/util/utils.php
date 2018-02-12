<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 06/02/2018
 * Time: 16:33
 */

/**
 * @param $str
 * @param array $arr
 * @return bool
 */
function arr_contains($str, array $arr) {
    foreach($arr as $a) {
        if (stripos($str,$a) !== false) return true;
    }
    return false;
}

/**
 * @param $str1
 * @param $str2
 * @return bool
 */
function contains($str1, $str2) {
    return stripos($str1, $str2) !== false;
}

/**
 * @param $object
 * @return array
 */
function dismount($object) {
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();

    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);

        if (is_object($property->getValue($object))) {
            $array[$property->getName()] = dismount($property->getValue($object));
        } else if (is_array($property->getValue($object))) {
            $bArray = array();
            foreach ($property->getValue($object) as $item) {
                 is_object($item) ? array_push($bArray, dismount($item)) : array_push($bArray, $item);
            }

            $array[$property->getName()] = $bArray;

        } else  {
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

    }

    return $array;
}