<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 05/02/2018
 * Time: 11:23
 */
require_once __DIR__ . '/CodeValidatorController.php';
require_once __DIR__ . '/CommentController.php';
require_once __DIR__ . '/../Models/ClassModel.php';
require_once __DIR__ . '/../util/utils.php';

class EntryController {

    /** @var CodeValidatorController */
    private $validator;
    /** @var CommentController */
    private $commentController;
    /** @var ClassModel*/
    private $classModel;

    /**
     * EntryController constructor.
     */
    public function __construct() {
        $this->validator = new CodeValidatorController();
        $this->commentController = new CommentController();
        $this->classModel = new ClassModel();
    }

    public function codeReview($codeAsArray, $language) {

        if ($this->validator->validateCode($codeAsArray, $language)) {

            $this->classModel->setName($this->getClassName($codeAsArray, $language));
            $this->classModel->setValid(true);
            $this->classModel->setComments($this->commentController->getAllComments($codeAsArray, $language));
            $this->classModel->setNLoc(sizeof($codeAsArray));

            $classObject = dismount($this->classModel);

            return json_encode($classObject);
        }

        return json_encode(array(
            "response" => "Invalid code! You may have submitted an empty field or an invalid " . $language . " code.",
            "line" => "",
            "valid" => false
        ));
    }

    public function getClassName($codeAsArray, $language) {
        $classType = json_decode(file_get_contents(
            __DIR__ . '/../util/LanguageStyles.json'), true)[$language]['class'];

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