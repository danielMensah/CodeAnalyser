<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 05/02/2018
 * Time: 11:23
 */
require_once __DIR__ . '/CodeValidatorController.php';
require_once __DIR__ . '/CommentController.php';
require_once __DIR__ . '/FunctionController.php';
require_once __DIR__ . '/CyclomaticComplexityController.php';
require_once __DIR__ . '/../Models/ClassModel.php';
require_once __DIR__ . '/../Models/ResponseModel.php';
require_once __DIR__ . '/../../util/utils.php';
require_once __DIR__ . "/../constants.php";

class EntryController {

    /** @var string */
    private $language;

    /**
     * EntryController constructor.
     * @param string $language
     */
    public function __construct(string $language) {
        $this->language = $language;
    }

    public function codeReview($codeAsArray) {
        $validator = new CodeValidatorController();
        $response = new ResponseModel();

        if ($validator->validateCode($codeAsArray, $this->language)) {
            $classModel = new ClassModel();

            $classModel->setName($this->getClassName($codeAsArray));

            $commentController = new CommentController($this->language);
            $classModel->setComments($commentController->getAllComments($codeAsArray));
            $commentArray = dismount($classModel)['comments'];

            $functionController = new FunctionController();
            $classModel->setFunctions($functionController->getFunctions($codeAsArray, $commentArray, $this->language));
            $classModel->setNLoc(sizeof($codeAsArray));

            $response->setValid(true);
            $response->setClass($classModel);

            return json_encode(dismount($response));
        }

        $response->setResponse("Invalid code! You may have submitted an empty field or an invalid " . $this->language . " code.");
        $response->setErrorLine("");
        $response->setValid(false);

        return json_encode(dismount($response));
    }

    /**
     * @param $codeAsArray
     * @return string
     */
    public function getClassName($codeAsArray) {
        $classType = json_decode(file_get_contents(
            __DIR__ . '/../../util/LanguageStyles.json'), true)[$this->language]['class'];

        $name = "";

        foreach ($codeAsArray as $line) {
            if (arr_contains($line, $classType)) {
                foreach ($classType as $type) {
                    if (contains($line, $type)) {
                        $line2 = trim(substr($line, strrpos($line, $type) + strlen($type)));
                        $name = explode(" ", $line2)[0];
                        break;
                    }
                }
                break;
            }
        }

        return $name;
    }

}