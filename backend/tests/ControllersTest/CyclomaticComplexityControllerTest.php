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
require_once __DIR__ . "/../../util/utils.php";

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
        $sample = file(__DIR__ . '/../Helpers/FunctionJavaCodeWithInlineComments.java', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $this->model->setComments($this->commentController->getAllComments($sample, 'gunningFogIndex'));
        $commentArray = dismount($this->model)['comments']; // needed to remove comments

        $expectedResult = 12;
        $actualResult = $this->controller->calculateCyclomaticComplexity($sample, $commentArray);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetCyclomaticComplexityEscapingBlockComments() {
        $sample = file(__DIR__ . '/../Helpers/FunctionJavaCodeWithBlockComments.java', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $this->model->setComments($this->commentController->getAllComments($sample, 'gunningFogIndex'));
        $commentArray = dismount($this->model)['comments']; // needed to remove comments

        $expectedResult = 8;
        $actualResult = $this->controller->calculateCyclomaticComplexity($sample, $commentArray);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetKeywordsCount() {
        $line = ': "Violation of precondition: smooth";';

        $expectedResult = 1;
        $actualResult = $this->controller->keywordsCount(removeStringBetweenQuotes($line));

        self::assertEquals($expectedResult, $actualResult);
    }

}