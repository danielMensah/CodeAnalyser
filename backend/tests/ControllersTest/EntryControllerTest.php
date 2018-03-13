<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 05/02/2018
 * Time: 11:35
 */

require_once __DIR__ . "/../../src/Controllers/EntryController.php";
require_once __DIR__ . "/../../util/utils.php";

class EntryControllerTest extends PHPUnit_Framework_TestCase {

    /** @var EntryController */
    private $controller;

    protected function setUp() {
        $this->controller = new EntryController('java');
    }

    public function testThatCodeCanBeReviewed() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.java');

        $needle = "\"valid\":true";
        $result = $this->controller->codeReview($sample);

        self::assertContains($needle, $result);
    }

    public function testThatCodeCannotBeReviewed() {
        $sample = file(__DIR__ . '/../Helpers/InvalidJavaCode.java');

        $needle = "\"valid\":false";
        $result = $this->controller->codeReview($sample);

        self::assertContains($needle, $result);
    }

    public function testThatCanGetClassName() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.java');

        $expectedResult = "FilterExample";
        $actualResult = $this->controller->getClassName($sample);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCannotGetClassName() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCodeWithoutClassName.java');

        $expectedResult = "";
        $actualResult = $this->controller->getClassName($sample);

        self::assertEquals($expectedResult, $actualResult);
    }

}