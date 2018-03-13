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

    /**
     * @param array $codeAsArray
     * @param string $language
     * @return array
     * @internal param bool|null $previousLineIsComment
     */
    public function getAllComments($codeAsArray, $language) {
        $commentStyles = json_decode(file_get_contents(
            __DIR__ . '/../util/LanguageStyles.json'), true)[$language];

        $isBlock = false;
        $commentBlock = new CommentBlock();
        $gluedBlock = ""; //glue lines of block comment together as string

        $listOfComments = array();
        $lineCounter = 1;
        $comment = new Comment();

        foreach ($codeAsArray as $line) {
            if (contains($line, $commentStyles['single'])
                || (contains($line, $commentStyles['block']['start'])
                    && contains($line, $commentStyles['block']['end']))) { //Check inline comments
                $comment = new Comment();

                $comment->setType("inline");
                $comment->setLine($lineCounter);
                $comment->setFeedback($this->reviewComment($line));
                array_push($listOfComments, $comment);

            } else if (strpos(trim($line), $commentStyles['block']['start']) === 0) { //Check start block comments
                $comment = new Comment();

                $gluedBlock = $gluedBlock . $line . "\n";
                $commentBlock->setStart($lineCounter);
                $isBlock = true;

            } else if (contains($line, $commentStyles['block']['end'])) { //Check start|end block comments
                $gluedBlock = $gluedBlock . $line;
                $commentBlock->setEnd($lineCounter);

                $comment->setType("block");
                $comment->setLine($commentBlock);
                $comment->setFeedback($this->reviewComment($gluedBlock, false));
                array_push($listOfComments, $comment);

                $gluedBlock = "";
                $isBlock = false;
                $commentBlock = new CommentBlock();

            } else if ($isBlock) { //Check comments inside block
                $gluedBlock = $gluedBlock . $line . "\n";
            }

            $lineCounter++;
        }

        return $listOfComments;
    }

    public function reviewComment($comment, $isInline = true) {
        if ($isInline) {
            if (($pos = strpos($comment, "//")) !== FALSE) {
                return trim(substr($comment, $pos+2));
            } else {
                $comment = substr($comment, strrpos($comment, '/*') + 2);
                return trim(str_replace("*/", "", $comment));
            }
        } else {
            return $comment;
        }
    }
}