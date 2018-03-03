<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 05/02/2018
 * Time: 11:35
 */

require_once __DIR__ . "/../../src/Controllers/EntryController.php";
require_once __DIR__ . "/../../src/Controllers/CommentController.php";
require_once __DIR__ . "/../../src/Controllers/CodeValidatorController.php";
require_once __DIR__ . "/../../util/utils.php";

class EntryControllerTest extends PHPUnit_Framework_TestCase {

    /** @var EntryController */
    private $controller;
    /** @var CommentController */
    private $commentController;
    /** @var CodeValidatorController */
    private $validatorController;

    protected function setUp() {
        $this->controller = new EntryController('java');
        $this->commentController = new CommentController('java');
        $this->validatorController = new CodeValidatorController();
    }

    public function testThatCodeCanBeReviewed() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.txt');

        $needle = "\"valid\":true";

        $result = $this->controller->codeReview($sample);

        self::assertContains($needle, $result);
    }

    public function testThatCodeCannotBeReviewed() {
        $sample = file(__DIR__ . '/../Helpers/InvalidJavaCode.txt');

        $needle = "\"valid\":false";

        $result = $this->controller->codeReview($sample);

        self::assertContains($needle, $result);
    }

    public function testThatCanGetClassName() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.txt');

        $actualResult = "FilterExample";
        $expectedResult = $this->controller->getClassName($sample);

        self::assertEquals($expectedResult, $actualResult);
    }

}