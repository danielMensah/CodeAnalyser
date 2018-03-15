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
require_once __DIR__ . "/ReadabilityController.php";
require_once __DIR__ . "/Abstracts/FeedbackAbstract.php";

class CommentController extends FeedbackAbstract {

    private $commentStyles;

    /**
     * CommentController constructor.
     * @param string $language
     * @internal param null $readabilityType
     */
    public function __construct(string $language) {
        $this->commentStyles = json_decode(file_get_contents(
            __DIR__ . '/../../util/LanguageStyles.json'), true)[$language]["comments"];
    }

    /**
     * @param array $codeAsArray
     * @param string $readabilityType
     * @return array
     * If block code content needs reviewing, glue code.
     */
    public function getAllComments($codeAsArray, $readabilityType) {
        $previousIsInline = false;
        $commentBlock = new CommentBlock();

        $listOfComments = array();
        $lineCounter = 1;
        $gluedComment = "";
        $isBlock = false;

        foreach ($codeAsArray as $line) {

            if (self::commentIsInline($line)) { //Check inline comments
                self::sanitizeLine($line, $sanitizedLine);

                array_push($listOfComments,
                    self::setModel($sanitizedLine,'inline', $lineCounter, $previousIsInline,0, $readabilityType));

                $previousIsInline = true;

            } else if (strpos(trim($line), $this->commentStyles['block']['start']) === 0) { //Check start block comments
                $isBlock = true;
                $previousIsInline = false;
                $commentBlock->setStart($lineCounter);
                $gluedComment = $gluedComment . $line . "\n";

            } else if (contains($line, $this->commentStyles['block']['end'])) { //Check end block comments
                $gluedComment = $gluedComment . $line . "\n";
                $commentBlock->setEnd($lineCounter);
                $commentLines = ($lineCounter - $commentBlock->getStart()) + 1;

                array_push($listOfComments,
                    self::setModel($gluedComment,'block', $commentBlock, false, $commentLines, $readabilityType));

                $commentBlock = new CommentBlock();
                $gluedComment = "";
                $isBlock = false;

            } else if ($isBlock) {
                $gluedComment = $gluedComment . $line . "\n";
            } else {
                $previousIsInline = false;
            }

            $lineCounter++;
        }

        return $listOfComments;
    }

    public function sanitizeLine($line, &$sanitizedLine) {
        $sanitizedLine = contains($line, "//") ? strstr($line, "//") : strstr($line, "/*");
        return $sanitizedLine;
    }

    /**
     * @param $comment
     * @param $type
     * @param $lineCounter
     * @param $previousIsInline
     * @param int $lines
     * @param null $readabilityType
     * @return CommentModel CommentModel
     */
    private function setModel($comment, $type, $lineCounter, $previousIsInline, $lines = 0, $readabilityType) {
        $commentModel = new CommentModel();

        $readabilityController = new ReadabilityController();

        $score = $readabilityController->$readabilityType($comment);
        $commentModel->setReadabilityScore($score);
        $scoreComment = $readabilityController->scoreComment($score, $readabilityType);

        $commentModel->setType($type);
        $commentModel->setLine($lineCounter);
        $commentModel->setFeedback($this->getReview($type === 'inline', $previousIsInline, $lines, $scoreComment));

        return $commentModel;
    }

    private function commentIsInline($line) {
        return contains($line, $this->commentStyles['single'])
            || (contains($line, $this->commentStyles['block']['start'])
                && contains($line, $this->commentStyles['block']['end']));
    }

    /**
     * @param bool $isInline
     * @param bool $previousIsInline
     * @param int $blockLines
     * @param $scoreComment
     * @return null|string
     */
    public function getReview($isInline = true, $previousIsInline = false, $blockLines = 0, $scoreComment) {
        if ($isInline && $previousIsInline) return DOUBLE_INLINE_COMMENTS . " " . $scoreComment;
        if ($isInline) return $scoreComment;

        return self::getBlockCommentFeedback($blockLines, 2) . " " . $scoreComment;
    }

    /**
     * @param $blockLines
     * @param null $type
     * @return null|string
     */
    protected function getBlockCommentFeedback($blockLines, $type = null) {
        if ($blockLines > $this->commentStyles['maxLength']) return LONG_BLOCK_COMMENT;
        return null;
    }

}