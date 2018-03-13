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
require_once __DIR__ . "/FogIndexController.php";
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
     *
     * If block code content needs reviewing, glue code.
     */
    public function getAllComments($codeAsArray) {
        $previousIsInline = false;
        $commentBlock = new CommentBlock();

        $listOfComments = array();
        $lineCounter = 1;
        $gluedComment = "";

        foreach ($codeAsArray as $line) {
            if (self::commentIsInline($line)) { //Check inline comments
                array_push($listOfComments,
                    self::setModel($line,'inline', $lineCounter, $previousIsInline));

                $previousIsInline = true;

            } else if (strpos(trim($line), $this->commentStyles['block']['start']) === 0) { //Check start block comments
                $previousIsInline = false;
                $commentBlock->setStart($lineCounter);
                $gluedComment = $gluedComment . $line . "\n";

            } else if (contains($line, $this->commentStyles['block']['end'])) { //Check end block comments
                $gluedComment = $gluedComment . $line;
                $commentBlock->setEnd($lineCounter);
                $commentLines = ($lineCounter - $commentBlock->getStart()) + 1;

                array_push($listOfComments,
                    self::setModel($gluedComment,'block', $commentBlock, false, $commentLines));

                $commentBlock = new CommentBlock();
                $gluedComment = "";

            } else {
                $previousIsInline = false;
            }

            $lineCounter++;
        }

        return $listOfComments;
    }

    /**
     * @param $comment
     * @param $type
     * @param $lineCounter
     * @param $previousIsInline
     * @param int $lines
     * @return CommentModel CommentModel
     */
    private function setModel($comment, $type, $lineCounter, $previousIsInline, $lines = 0) {
        $commentModel = new CommentModel();
        $fogIndex = new FogIndexController();

        $score = $fogIndex->calculateFogIndex($comment);

        $commentModel->setType($type);
        $commentModel->setLine($lineCounter);
        $commentModel->setFogIndex($score);
        $commentModel->setFeedback($this->getReview($type === 'inline', $previousIsInline, $lines, $score));

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
     * @param $score
     * @return null|string
     */
    public function getReview($isInline = true, $previousIsInline = false, $blockLines = 0, $score) {
        if ($isInline && $previousIsInline) return DOUBLE_INLINE_COMMENTS . " " . self::fogComment($score);
        if ($isInline) return self::fogComment($score);

        return self::getBlockCommentFeedback($blockLines, 2) . " " . self::fogComment($score);
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

    public function fogComment($score) {
        if ($score < 9) return FOG_INDEX_LEVEL_GRADE;
        if ($score > 8 && $score < 13) return FOG_INDEX_LEVEL_HIGH_SCHOOL;
        if ($score > 12 && $score < 15) return FOG_INDEX_LEVEL_COLLEGE_JUNIOR;

        return FOG_INDEX_LEVEL_COLLEGE_GRADUATE;
    }
}