<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 22/01/2018
 * Time: 19:18
 */

require_once __DIR__ . "/../Models/CommentModel.php";
require_once __DIR__ . "/../Models/ClassModel.php";
require_once __DIR__ . "/../Models/CommentBlock.php";
require_once __DIR__ . "/Abstracts/FeedbackAbstract.php";

class CommentController extends FeedbackAbstract {

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
        $commentModel = new CommentModel();

        foreach ($codeAsArray as $line) {
            if (contains($line, $this->commentStyles['single'])
                || (contains($line, $this->commentStyles['block']['start'])
                    && contains($line, $this->commentStyles['block']['end']))) { //Check inline comments
                $commentModel = new CommentModel();

                $commentModel->setType("inline");
                $commentModel->setLine($lineCounter);
                $commentModel->setFeedback($this->getReview(true, $previousIsInline, $previousIsInline));
                $previousIsInline = true;
                array_push($listOfComments, $commentModel);

            } else if (strpos(trim($line), $this->commentStyles['block']['start']) === 0) { //Check start block comments
                $previousIsInline = false;
                $commentModel = new CommentModel();

                $gluedBlock = $gluedBlock . $line . "\n";
                $commentBlock->setStart($lineCounter);
                $isBlock = true;

            } else if (contains($line, $this->commentStyles['block']['end'])) { //Check end block comments
//                $gluedBlock = $gluedBlock . $line;
                $commentBlock->setEnd($lineCounter);

                $lines = ($lineCounter - $commentBlock->getStart()) + 1;

                $commentModel->setType("block");
                $commentModel->setLine($commentBlock);
                $commentModel->setFeedback($this->getReview(false, false, $lines));
                array_push($listOfComments, $commentModel);

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

    /**
     * @param bool $isInline
     * @param bool $previousIsInline
     * @param int $blockLines
     * @return null|string
     */
    public function getReview($isInline = true, $previousIsInline = false, $blockLines = 0) {
        if ($isInline && $previousIsInline) return DOUBLE_INLINE_COMMENTS;
        if ($isInline) return null;

        return self::getFeedback($blockLines, 2);
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
     * @param $blockLines
     * @param null $type
     * @return null|string
     */
    protected function getFeedback($blockLines, $type = null) {
        if ($blockLines > $this->commentStyles['maxLength']) return LONG_BLOCK_COMMENT;
        return null;
    }
}