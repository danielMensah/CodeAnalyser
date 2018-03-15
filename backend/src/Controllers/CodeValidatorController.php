<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 16/01/2018
 * Time: 12:11
 */

class CodeValidatorController {
    /**
     * @param $codeAsArray
     * @return bool If code is file, check extension
     *
     * If code is file, check extension
     */
    public function validateCode($codeAsArray) {
        $codeIsValid = true;

        if (self::codeIsNotEmpty($codeAsArray)) {
            foreach ($codeAsArray as $line) {
                if (self::checkIfLineContainsUnsupportedSyntax($line)) {
                    $codeIsValid = false;
                    break;
                }
            }

        } else {
            return false;
        }

        return $codeIsValid;
    }

    /**
     * @param $codeAsArray
     * @return bool
     */
    private function codeIsNotEmpty($codeAsArray) {
        return !!sizeof($codeAsArray);
    }

    /**
     * @param $line
     * @return bool
     */
    private function checkIfLineContainsUnsupportedSyntax($line) {
        return contains($line, 'var ') || (contains($line, '$') && strpos(trim($line), '$') == 0);
    }

}
