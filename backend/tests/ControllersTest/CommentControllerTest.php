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
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCode.txt');
        $this->class->setComments($this->controller->getAllComments($sample));

        $expectedResult = 10;
        $actualResult = sizeof($this->class->getComments());

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanReviewInlineComments() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCodeInlineComment.txt');
        $this->class->setComments($this->controller->getAllComments($sample));

        $jsonResponse = file_get_contents(__DIR__ . '/../Helpers/InlineCommentResponse.json');

        $expectedResult = trim(preg_replace('/\s\s+/', '', $jsonResponse));
        $actualResult = json_encode(dismount($this->class)['comments']);

        self::assertEquals($expectedResult, $actualResult);
    }

    public function testThatCanReviewBlockComments() {
        $sample = file(__DIR__ . '/../Helpers/ValidJavaCodeBlockComment.txt');
        $this->class->setComments($this->controller->getAllComments($sample));

        $jsonResponse = file_get_contents(__DIR__ . '/../Helpers/BlockCommentResponse.json');

        $expectedResult = trim(preg_replace('/\s\s+/', '', $jsonResponse));
        $actualResult = json_encode(dismount($this->class)['comments']);

        self::assertEquals($expectedResult, $actualResult);
    }

}