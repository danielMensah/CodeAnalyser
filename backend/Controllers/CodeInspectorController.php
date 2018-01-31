<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 16/01/2018
 * Time: 12:11
 */

class CodeInspectorController {

    public function Inspector($code) {
        $codeAsArray = explode("\n", $code);

        if (self::isCodeValid($codeAsArray) && self::codeIsNotEmpty($codeAsArray)) {
            return json_encode(array(
                "response" => "Valid java code",
                "valid" => true
            ));
        }

        throw new PDOException("You may have pass an empty string or invalid Java code!", 409);
    }

    /**
     * @param $codeAsArray
     * @return bool
     *
     * If code is file, check extension
     */
    public function isCodeValid($codeAsArray) {
        $codeIsValid = true;
        $gluedCode  = '';

        foreach ($codeAsArray as $line) {
            if (strpos($line, 'var') !== false) {
                $codeIsValid = false;
                break;
            } else if (strpos($line, "$") !== false && strpos(trim($line), "$") == 0) {
                $codeIsValid = false;
                break;
            }

            $gluedCode = $gluedCode . "\n" . $line;
        }

        if (strpos($gluedCode, 'public class') === false && $codeIsValid) {
            $codeIsValid = false;
        }

        return $codeIsValid;
    }

    /**
     * @param $codeAsArray
     * @return bool
     */
    public function codeIsNotEmpty($codeAsArray) {
        return !!sizeof($codeAsArray);
    }

}