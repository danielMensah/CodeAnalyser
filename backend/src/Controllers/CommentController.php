<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 22/01/2018
 * Time: 19:18
 */

require_once __DIR__ . "/../Models/Comment.php";
require_once __DIR__ . "/../Models/ClassModel.php";
require_once __DIR__ . "/../Models/CommentBlock.php";

class CommentController {

    private $commentStyles;

    /**
     * CommentController constructor.
     * @param string $language
     */
    public function __construct(string $language) {
        $this->commentStyles = json_decode(file_get_contents(
            __DIR__ . '/../../util/LanguageStyles.json'), true)[$language]["comments"];
    }


    /**
     * @param array $codeAsArray
     * @return array
     * @internal param string $language
     * @internal param bool|null $previousLineIsComment
     */
    public function getAllComments($codeAsArray) {

        $isBlock = false;
        $previousIsInline = false;
        $commentBlock = new CommentBlock();
        $gluedBlock = ""; //glued lines of block comment together as string

        $listOfComments = array();
        $lineCounter = 1;
        $comment = new Comment();

        foreach ($codeAsArray as $line) {
            if (contains($line, $this->commentStyles['single'])
                || (contains($line, $this->commentStyles['block']['start'])
                    && contains($line, $this->commentStyles['block']['end']))) { //Check inline comments
                $comment = new Comment();

                $comment->setType("inline");
                $comment->setLine($lineCounter);
                $comment->setFeedback($this->getReview($line, true, $previousIsInline));
                $previousIsInline = true;
                array_push($listOfComments, $comment);

            } else if (strpos(trim($line), $this->commentStyles['block']['start']) === 0) { //Check start block comments
                $previousIsInline = false;
                $comment = new Comment();

                $gluedBlock = $gluedBlock . $line . "\n";
                $commentBlock->setStart($lineCounter);
                $isBlock = true;

            } else if (contains($line, $this->commentStyles['block']['end'])) { //Check end block comments
                $gluedBlock = $gluedBlock . $line;
                $commentBlock->setEnd($lineCounter);

                $lines = ($lineCounter - $commentBlock->getStart()) + 1;

                $comment->setType("block");
                $comment->setLine($commentBlock);
                $comment->setFeedback($this->getReview($gluedBlock, false, false, $lines));
                array_push($listOfComments, $comment);

                $gluedBlock = "";
                $isBlock = false;
                $commentBlock = new CommentBlock();

            } else if ($isBlock) { //Check comments inside block
                $gluedBlock = $gluedBlock . $line . "\n";
            } else {
                $previousIsInline = false;
            }

            $lineCounter++;
        }

        return $listOfComments;
    }

    public function getReview($comment, $isInline = true, $previousIsInline = false, $blockLines = 0) {
        if ($isInline && $previousIsInline) {
            return "It seems that this comment could be merge with the previous. Try adding a block comment instead.";
        } else if ($isInline) {
            return "Hello world";
        } else {
            return self::reviewBlockComment($comment, $blockLines);
        }
    }

//    public function reviewInlineComment($comment, $previousIsInline) {
//        $commentWithoutTags = "";
//        if (($pos = strpos($comment, "//")) !== FALSE) {
//            $commentWithoutTags = trim(substr($comment, $pos+2));
//        } else {
//            $comment = substr($comment, strrpos($comment, '/*') + 2);
//            $commentWithoutTags = trim(str_replace("*/", "", $comment));
//        }
//    }

    /**
     * @param string $comment
     * @param $blockLines
     * @return string
     */
    public function reviewBlockComment($comment, $blockLines) {
        if ($blockLines > $this->commentStyles['maxLength']) {
            return "This line of comment is quite long. You may want to amend the comment or refactor the function. Remember code should speak for it self!";
        }

        return "Hello world";
    }
}