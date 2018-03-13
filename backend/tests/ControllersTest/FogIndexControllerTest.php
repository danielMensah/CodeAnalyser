<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 13/03/2018
 * Time: 12:20
 */
require_once __DIR__ . "/../../src/Controllers/FogIndexController.php";

class FogIndexControllerTest extends PHPUnit_Framework_TestCase {

    /** @var FogIndexController */
    private $controller;

    protected function setUp() {
        $this->controller = new FogIndexController();
    }

    public function testThatCanGetFogIndexOfBlockComment() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 9.0;
        $actualResult = $this->controller->calculateFogIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetFogIndexOfInlineComment() {
        $comment = '//The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.';

        $expectedResult = 8.0;
        $actualResult = $this->controller->calculateFogIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

}