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
require_once __DIR__ . '/../Models/ResponseModel.php';
require_once __DIR__ . '/../../util/utils.php';

class EntryController {

    /** @var CodeValidatorController */
    private $validator;
    /** @var CommentController */
    private $commentController;
    /** @var ResponseModel */
    private $response;
    /** @var string */
    private $language;

    /**
     * EntryController constructor.
     * @param string $language
     */
    public function __construct(string $language) {
        $this->validator = new CodeValidatorController();
        $this->commentController = new CommentController($language);
        $this->response = new ResponseModel();
        $this->language = $language;
    }

    public function codeReview($codeAsArray) {

        if ($this->validator->validateCode($codeAsArray, $this->language)) {
            /** @var ClassModel*/
            $classModel = new ClassModel();

            $classModel->setName($this->getClassName($codeAsArray, $this->language));
            $classModel->setComments($this->commentController->getAllComments($codeAsArray));
            $classModel->setNLoc(sizeof($codeAsArray));

            $this->response->setValid(true);
            $this->response->setClass($classModel);

            return json_encode(dismount($this->response));
        }

        $this->response->setResponse("Invalid code! You may have submitted an empty field or an invalid " . $this->language . " code.");
        $this->response->setErrorLine("");
        $this->response->setValid(false);

        return json_encode(dismount($this->response));
    }

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