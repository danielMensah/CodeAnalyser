<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 20/02/2018
 * Time: 17:51
 */

require_once __DIR__ . "/../Models/FunctionModel.php";
require_once __DIR__ . "/CyclomaticComplexityController.php";
require_once __DIR__ . "/Abstracts/FeedbackAbstract.php";

class FunctionController extends FeedbackAbstract {

    private $language;

    /**
     * @param $codeAsArray
     * @param $commentArray
     * @param $language
     * @param $className
     * @return array
     */
    public function getFunctions($codeAsArray, $commentArray, $language, $className) {
        $this->language = $language;

        $rulesFile = json_decode(file_get_contents(
            __DIR__ . '/../../util/LanguageStyles.json'), true)[$language];

        $patterns = $rulesFile['method']['patterns'];
        array_push($patterns, $className);
        $avoid = $rulesFile['method']['avoid'];

        $functionList = array();
        $codeAsArray = removeComments($codeAsArray, $commentArray);

        for ($i = 0; $i<sizeof($codeAsArray); $i++) {
            $line = removeStringBetweenQuotes($codeAsArray[$i]);
            $foundK = returnFoundKeyword($line, $patterns);
            if ($foundK && !arr_contains($line, $avoid)) {
                if (self::checkOpenCurlyBracket($line, $codeAsArray[$i+1])) {
                    $functionContent = self::getFunctionContent($i, $codeAsArray, $foundK);
                    array_push($functionList, self::generateModel($line, $functionContent));
                }
            }
        }

        return $functionList;
    }

    /**
     * @param $line
     * @param $functionContent
     * @return FunctionModel
     */
    private function generateModel($line, $functionContent) {
        $cc = new CyclomaticComplexityController($this->language);

        $model = new FunctionModel();
        $model->setNParameters(self::getParameters($line));
        $model->setName(self::getFunctionName($line));
        $model->setNLoc(sizeof($functionContent));
        $model->setComplexity($cc->calculateCyclomaticComplexity($functionContent));
        $model->setFeedback(self::getFeedback($model->getComplexity()));

        return $model;
    }

    /**
     * @param $currentLine
     * @param $nextLine
     * @return bool
     */
    private function checkOpenCurlyBracket($currentLine, $nextLine) {
        return contains($currentLine, "{") || contains($nextLine, "{");
    }

    /**
     * @param $line
     * @return string
     */
    private function getFunctionName($line) {
        $string = strstr($line, "(", true);
        $arr = explode(" ", trim($string));
        return $arr[sizeof($arr) - 1]."()";
    }

    /**
     * @param string $line
     * @return int
     */
    private function getParameters($line) {
        preg_match('#\((.*?)\)#', $line, $string); //returns string inside the parenthesis
        $parameters = explode(",", $string[1]);

        return sizeof($parameters);
    }

    /**
     * @param $lineIndex
     * @param $codeAsArray
     * @param $k
     * @return array
     */
    public function getFunctionContent($lineIndex, $codeAsArray, $k) {
        $bracketCounter = 0;
        $loopIsOn = false;
        $functionAsArray = [];

        for ($i = $lineIndex; $i<sizeof($codeAsArray); $i++) {
            $line = $codeAsArray[$i];
            $avoid = trim(strstr($line, $k, true)) === '{'; //avoids open brackets of a class on the same line as function declaration

            if ($bracketCounter === 0 && $loopIsOn) break;//end of method

            if (contains($line, "{") && !$avoid) {
                $bracketCounter += substr_count($line, "{");
                $loopIsOn = true;
            };

            if (contains($line, "}") && !$avoid) {
                $bracketCounter -= substr_count($line, "}");
                $loopIsOn = true;
            };

           array_push($functionAsArray, $line);
        }

        return $functionAsArray;
    }

    /**
     * @param $cc
     * @param null $type
     * @return string
     */
    protected function getFeedback($cc, $type = null) {
        if ($cc > 50) return FUNCTION_FEEDBACK_ABOVE_50;
        if ($cc > 20 && $cc < 50) return FUNCTION_FEEDBACK_ABOVE_20;
        return "";
    }
}