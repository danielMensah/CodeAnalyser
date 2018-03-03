<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 20/02/2018
 * Time: 17:51
 */
require_once __DIR__ . "/../../src/Controllers/FunctionController.php";
require_once __DIR__ . "/../../src/Controllers/CommentController.php";

class FunctionControllerTest extends PHPUnit_Framework_TestCase {

    /** @var FunctionController */
    private $controller;
    /** @var ClassModel */
    private $model;
    /** @var CommentController */
    private $commentController;

    protected function setUp() {
        $this->controller = new FunctionController();
        $this->model = new ClassModel();
        $this->commentController = new CommentController('java');
    }

    public function testThatCanGetFunctions() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.txt');
        $this->model->setComments($this->commentController->getAllComments($sample));
        $commentArray = dismount($this->model)['comments'];
        $this->model->setFunctions($this->controller->getFunctions($sample, $commentArray, 'java'));

        $expectedResult = 4;
        $actualResult =sizeof($this->model->getFunctions());

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetNLocFunctionAndMethodContent() {
        $sample = file(__DIR__ . '/../Helpers/FunctionJavaCodeWithInlineComments.txt');

        $expectedResult = 16;
        $actualResult = sizeof($this->controller->getFunctionContent(0, $sample, 'public'));

        self::assertEquals($expectedResult, $actualResult);
    }

}