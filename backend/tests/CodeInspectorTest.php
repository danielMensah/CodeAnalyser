<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 16/01/2018
 * Time: 12:08
 */

require_once __DIR__ . "/../Controllers/CodeInspectorController.php";

class CodeInspectorTest extends PHPUnit_Framework_TestCase {

    /** @var CodeInspectorController */
    private $controller;

    protected function setUp() {
        $this->controller = new CodeInspectorController();
    }

    public function testThatEmptyCodeIsNotAccepted() {
        $codeAsArray = array();

        self::assertFalse($this->controller->codeIsNotEmpty($codeAsArray));
    }

    public function testThatCodeIsAccepted() {
        $codeAsArray = file(__DIR__ . '/Helpers/ValidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        self::assertTrue($this->controller->codeIsNotEmpty($codeAsArray));
    }

    public function testThatCodeIsValid() {
        $sample = file(__DIR__ . '/Helpers/ValidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        $response = $this->controller->isCodeValid($sample);

        self::assertTrue($response);
    }

    public function testThatCodeIsInvalid() {
        $sample = file(__DIR__ . '/Helpers/InvalidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        $response = $this->controller->isCodeValid($sample);

        self::assertFalse($response);
    }

    public function testThatCodeHasNoPHPSyntax() {
        $lineSample = file(__DIR__ . '/Helpers/ValidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $codeHasPHPSyntax = false;

        foreach ($lineSample as $line) {
            if (strpos($line, "$") !== false && !$codeHasPHPSyntax) {
                $codeHasPHPSyntax = $this->controller->lineHasPHPSyntax($line);
            }
        }

        self::assertFalse($codeHasPHPSyntax);
    }

    public function testThatCodeHasPHPSyntax() {
        $lineSample = file(__DIR__ . '/Helpers/InvalidJavaCode.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $codeHasPHPSyntax = false;

        foreach ($lineSample as $line) {
            if (strpos($line, "$") !== false && !$codeHasPHPSyntax) {
                $codeHasPHPSyntax = $this->controller->lineHasPHPSyntax($line);
            }
        }

        self::assertTrue($codeHasPHPSyntax);
    }

}