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

function removeComments($codeAsArray, $commentArray) {
    if (!$commentArray) return $codeAsArray;
    
    $newCodeAsArray = array();

    foreach ($commentArray as $comment) {
        if ($comment['type'] === 'inline') $codeAsArray = removeInlineComments($codeAsArray, $comment);
        if ($comment['type'] === 'block') $codeAsArray = removeBlockComments($codeAsArray, $comment);
    }

    //Doing this otherwise some indexes will be unset e.g. missing index 11
    foreach ($codeAsArray as $line) array_push($newCodeAsArray, $line);

    return $newCodeAsArray;
}

/**
 * @param $codeAsArray
 * @param $comment
 * @return array
 */
function removeInlineComments($codeAsArray, $comment) {
    $commentLine = $comment['line'] - 1;
    $commentIsDoubleSlash =  strstr($codeAsArray[$commentLine], "//", true);

    if ($commentIsDoubleSlash) {
        $codeAsArray[$commentLine] = trim($commentIsDoubleSlash);
    } else {
        $codeAsArray[$commentLine] = trim(strstr($codeAsArray[$commentLine], "/*", true));
    }

    return $codeAsArray;
}

/**
 * @param $codeAsArray
 * @param $comment
 * @return array
 */
function removeBlockComments($codeAsArray, $comment) {
    $start = $comment['line']['start'] - 1;
    $end = $comment['line']['end'] - 1;

    while ($start <= $end) {
        unset($codeAsArray[$start]);
        $start++;
    }

    return $codeAsArray;
}

/**
 * @param $string
 * @return string
 */
function removeStringBetweenQuotes($string) {
    if (preg_match('/"([^"]+)"/', $string, $m)) {
        return str_replace($m, '', $string);
    }

    return $string;
}

/**
 * @param $line
 * @param $keywords
 * @param null|string $match
 * @return null
 */
function returnFoundKeyword($line, $keywords, string &$match = null) {
    foreach ($keywords as $keyword) {
        if (contains($line, $keyword)) {
            $match = $keyword;
            break;
        };
    }

    return $match;
}