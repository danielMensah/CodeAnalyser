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
     *
     * If block code content needs reviewing, glue code.
     */
    public function getAllComments($codeAsArray) {
        $previousIsInline = false;
        $commentBlock = new CommentBlock();

        $listOfComments = array();
        $lineCounter = 1;

        foreach ($codeAsArray as $line) {
            if (self::commentIsInline($line)) { //Check inline comments
                array_push($listOfComments,
                    self::setModel('inline', $lineCounter, $previousIsInline));

                $previousIsInline = true;

            } else if (strpos(trim($line), $this->commentStyles['block']['start']) === 0) { //Check start block comments
                $previousIsInline = false;
                $commentBlock->setStart($lineCounter);

            } else if (contains($line, $this->commentStyles['block']['end'])) { //Check end block comments
                $commentBlock->setEnd($lineCounter);
                $commentLines = ($lineCounter - $commentBlock->getStart()) + 1;

                array_push($listOfComments,
                    self::setModel('block', $commentBlock, false, $commentLines));

                $commentBlock = new CommentBlock();

            } else {
                $previousIsInline = false;
            }

            $lineCounter++;
        }

        return $listOfComments;
    }

    /**
     * @param $type
     * @param $lineCounter
     * @param $previousIsInline
     * @param int $lines
     * @return CommentModel CommentModel
     */
    private function setModel($type, $lineCounter, $previousIsInline, $lines = 0) {
        $commentModel = new CommentModel();

        $commentModel->setType($type);
        $commentModel->setLine($lineCounter);
        $commentModel->setFeedback($this->getReview($type === 'inline', $previousIsInline, $lines));

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
     * @return null|string
     */
    public function getReview($isInline = true, $previousIsInline = false, $blockLines = 0) {
        if ($isInline && $previousIsInline) return DOUBLE_INLINE_COMMENTS;
        if ($isInline) return null;

        return self::getFeedback($blockLines, 2);
    }

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