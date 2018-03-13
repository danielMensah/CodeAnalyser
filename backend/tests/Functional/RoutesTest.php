<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 11/01/2018
 * Time: 12:09
 */

namespace Tests\Functional;


class RoutesTest extends BaseTestCase {

    /**
     * The issue is that PHPUnit will print a header to the screen and at that point you can't add more headers.
     * That is why process isolation is needed. The isolation can be added to phpunit.xml as well but that will run
     * every single test in separate process and therefore, a slower test. The other tests do not need to run in
     * separate processes.
     */

    /**
     * @runInSeparateProcess
     */

    public function testThatThrowErrorIfCodeIsInvalid() {
        $needle = "\"valid\":false";

        //Empty code
        $response = $this->runApp('POST', '/api/submitCode', array("text" => ""));
        self::assertEquals(200, (int)$response->getStatusCode());
        self::assertContains($needle, (string)$response->getBody());
    }

    /**
     * @runInSeparateProcess
     */

    public function testThatValidCodeDoesntThrowError() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.java');
        $needle = "\"valid\":true";

        //Empty code
        $response = $this->runApp('POST', '/api/submitCode', array("text" => json_encode($sample)));
        self::assertEquals(200, (int)$response->getStatusCode());
        self::assertContains($needle, (string)$response->getBody());
    }

}