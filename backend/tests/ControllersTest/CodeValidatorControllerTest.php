<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 16/01/2018
 * Time: 12:08
 */

require_once __DIR__ . "/../../src/Controllers/CodeValidatorController.php";

class CodeValidatorControllerTest extends PHPUnit_Framework_TestCase {

    /** @var CodeValidatorController */
    private $controller;

    protected function setUp() {
        $this->controller = new CodeValidatorController();
    }

    /**
     * @covers CodeValidatorController::validateCode
    */
    public function testThatCodeIsValid() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        $response = $this->controller->validateCode($sample, 'java');

        self::assertTrue($response);
    }

    public function testThatCodeIsInvalid() {
        $sample = file(__DIR__ . '/../Helpers/InvalidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        $response = $this->controller->validateCode($sample, 'java');

        self::assertFalse($response);
    }

    public function testThatCodeIsEmpty() {

        $response = $this->controller->validateCode(" ", 'java');

        self::assertFalse($response);
    }

}