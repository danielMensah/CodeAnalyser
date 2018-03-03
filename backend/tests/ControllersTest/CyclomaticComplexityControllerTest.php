<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 12/02/2018
 * Time: 18:45
 */

require_once __DIR__ . "/../../src/Controllers/CyclomaticComplexityController.php";
require_once __DIR__ . "/../../src/Controllers/CommentController.php";
require_once __DIR__ . "/../../src/Models/ClassModel.php";

class CyclomaticComplexityControllerTest extends PHPUnit_Framework_TestCase {

    /** @var CyclomaticComplexityController */
    private $controller;
    /** @var ClassModel */
    private $model;
    /** @var CommentController */
    private $commentController;

    protected function setUp() {
        $this->controller = new CyclomaticComplexityController('java');
        $this->commentController = new CommentController('java');
        $this->model = new ClassModel();
    }

    public function testThatCanGetNumberOfKeywordsEscapingInlineComments() {
        $sample = file(__DIR__ . '/../Helpers/FunctionJavaCodeWithInlineComments.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $this->model->setComments($this->commentController->getAllComments($sample));
        $commentArray = dismount($this->model)['comments']; // needed to remove comments

        $expectedResult = 8;
        $actualResult = $this->controller->calculateCyclomaticComplexity($sample, $commentArray);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetCyclomaticComplexityEscapingBlockComments() {
        $sample = file(__DIR__ . '/../Helpers/FunctionJavaCodeWithBlockComments.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $this->model->setComments($this->commentController->getAllComments($sample));
        $commentArray = dismount($this->model)['comments']; // needed to remove comments

        $expectedResult = 8;
        $actualResult = $this->controller->calculateCyclomaticComplexity($sample, $commentArray);

        self::assertEquals($expectedResult, $actualResult);
    }

}