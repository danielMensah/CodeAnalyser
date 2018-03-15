<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 13/03/2018
 * Time: 12:20
 */
require_once __DIR__ . "/../../src/Controllers/ReadabilityController.php";

class ReadabilityControllerTest extends PHPUnit_Framework_TestCase {

    /** @var ReadabilityController */
    private $controller;

    protected function setUp() {
        $this->controller = new ReadabilityController();
    }

    public function testThatCanGetGunningFogIndexOfBlockComment() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 9.0;
        $actualResult = $this->controller->gunningFogIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetFogIndexOfInlineComment() {
        $comment = '//The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.';

        $expectedResult = 8.0;
        $actualResult = $this->controller->gunningFogIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetFleschKincaidGradeLevel() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 6.2;
        $actualResult = $this->controller->fleschKincaidGradeLevel($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetFleschKincaidReadingEase() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 73.6;
        $actualResult = $this->controller->fleschKincaidReadingEase($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetSMOGIndex() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 7;
        $actualResult = $this->controller->smogIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetColemanLiauIndex() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 9.1;
        $actualResult = $this->controller->colemanLiauIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanGetAutomatedReadabilityIndex() {
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 4.9;
        $actualResult = $this->controller->automatedReadabilityIndex($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanSanitizeComment() {
        // Block comment
        $comment = '/**
             * The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
             * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
             * every single test in separate process and therefore, a slower test. The other tests do not need to run in
             * separate processes.
             */';

        $expectedResult = 'The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.
              That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
              every single test in separate process and therefore, a slower test. The other tests do not need to run in
              separate processes.';
        $actualResult = $this->controller->sanitizer($comment);

        self::assertEquals($expectedResult, $actualResult);

        // Inline comment
        $comment = '//The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.';

        $expectedResult = 'The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.';
        $actualResult = $this->controller->sanitizer($comment);

        self::assertEquals($expectedResult, $actualResult);

        /* Inline comment */
        $comment = '/*The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.*/';

        $expectedResult = 'The issue is that PHPUnit will print a header to the screen and at that point you can\'t add more headers.';
        $actualResult = $this->controller->sanitizer($comment);

        self::assertEquals($expectedResult, $actualResult);
    }

}