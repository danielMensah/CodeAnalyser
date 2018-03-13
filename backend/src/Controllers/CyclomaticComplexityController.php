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
        $doWhile = false;

        $methodAsArray = removeComments($methodAsArray, $commentArray);
        $lastKeyword = "";

        for ($i = 0; $i<sizeof($methodAsArray); $i++) {
            $line = removeStringBetweenQuotes($methodAsArray[$i]);
            if (returnFoundKeyword($line, $keywords, $keyword)) {
                if ($doWhile && $keyword === 'while') {
                    $lastKeyword = self::lastStm($line, $lastKeyword);
                } else {
                    $cyclomaticComplexity += self::keywordsCount($line);
                    $lastKeyword = self::lastStm($line, $lastKeyword);
                }

                $doWhile += $keyword === 'do' ? 1 : 0;
                $keyword = null;
            }
        }

        if ($lastKeyword === 'return') $cyclomaticComplexity--;

        return $cyclomaticComplexity;
    }

    /**
     * @param $line
     * @return int
     */
    public function keywordsCount($line) {
        $counter = 0;
        $keywords = $this->rulesFile['keywords'];

        if (contains($line, 'case') && contains($line, ':')) return 1;
        foreach ($keywords as $keyword) $counter += substr_count($line, $keyword);

        return $counter;
    }

    /**
     * @param $line
     * @param $lastKeyword
     * @return mixed
     */
    public function lastStm($line, $lastKeyword) {
        $avoid = $this->rulesFile['avoidKeys'];
        $stm = explode(" ", trim($line));

        return arr_contains($stm[0], $avoid) ? $lastKeyword : $stm[0];
    }

}