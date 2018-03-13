<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 22/01/2018
 * Time: 19:20
 */

require_once __DIR__ . "/../../src/Controllers/CommentController.php";
require_once __DIR__ . "/../../util/utils.php";

class CommentControllerTest extends PHPUnit_Framework_TestCase {

    /** @var CommentController */
    private $controller;
    /** @var ClassModel*/
    private $class;

    protected function setUp() {
        $this->controller = new CommentController('java');
        $this->class = new ClassModel();
    }

    public function testThatCanGetComments() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.java');
        $this->class->setComments($this->controller->getAllComments($sample));

        $expectedResult = 9;
        $actualResult = sizeof($this->class->getComments());

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanReviewComments() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCodeBlockComment.java');
        $this->class->setComments($this->controller->getAllComments($sample));

        $jsonResponse = file_get_contents(__DIR__ . '/../Helpers/CommentResponse.json');

        $expectedResult = trim(preg_replace('/\s\s+/', '', $jsonResponse));
        $actualResult = json_encode(dismount($this->class)['comments']);

        self::assertEquals($expectedResult, $actualResult);
    }

}