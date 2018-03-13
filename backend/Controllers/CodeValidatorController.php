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
     * @param $language
     * @return bool If code is file, check extension
     *
     * If code is file, check extension
     */
    public function validateCode($codeAsArray, $language) {
        $codeIsValid = true;
        $gluedCode  = '';
        $counter = 0;

        $classType = json_decode(file_get_contents(
            __DIR__ . '/../util/LanguageStyles.json'), true)[$language]['class'];

        if (self::codeIsNotEmpty($codeAsArray)) {
            foreach ($codeAsArray as $line) {
                if (strpos($line, 'var ') !== false
                    || (strpos($line, "$") !== false && strpos(trim($line), "$") == 0)) {

                    $codeIsValid = false;
                    break;
                }

                $gluedCode = $gluedCode . "\n" . $line;
                $counter++;
            }

            if (!arr_contains($gluedCode, $classType)) {
                $codeIsValid = false;
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

}