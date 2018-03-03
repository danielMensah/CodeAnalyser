<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 12/02/2018
 * Time: 18:26
 */

class CyclomaticComplexityController {

    private $rulesFile;

    /**
     * CyclomaticComplexityController constructor.
     * @param $language
     */
    public function __construct($language) {
        $this->rulesFile = json_decode(file_get_contents(
            __DIR__ . '/../../util/LanguageStyles.json'), true)[$language];
    }

    /**
     * @param array $methodAsArray
     * @param array $commentArray
     * @return int
     */
    public function calculateCyclomaticComplexity($methodAsArray, $commentArray = null) {
        $cyclomaticComplexity = 1;
        $keywords = $this->rulesFile['keywords'];

        $methodAsArray = $commentArray ? removeComments($methodAsArray, $commentArray) : $methodAsArray;
        $lastKeyword = "";

        for ($i = 0; $i<sizeof($methodAsArray); $i++) {
            $line = removeStringBetweenQuotes($methodAsArray[$i]);
            foreach ($keywords as $keyword) {
                if (contains($line, $keyword)) {
                    $cyclomaticComplexity += substr_count($line, $keyword);
                    $lastKeyword =  self::lastStm($line, $lastKeyword);
                }
            }
        }

        if (contains($lastKeyword, 'return')) $cyclomaticComplexity--;

        return $cyclomaticComplexity;
    }

    public function lastStm($line, $lastKeyword) {
        $avoid = $this->rulesFile['avoidKeys'];
        $stm = explode(" ", trim($line));

        return arr_contains($stm[0], $avoid) ? $lastKeyword : $stm[0];
    }

}