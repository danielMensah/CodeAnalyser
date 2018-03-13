<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 07/02/2018
 * Time: 11:22
 */

require_once __DIR__ . "/CommentBlock.php";

class CommentModel {

    /** @var string*/
    private $type;
    /** @var string|CommentBlock */
    private $line;
    /** @var float */
    private $fogIndex;
    /** @var string */
    private $feedback;

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return CommentBlock|string
     */
    public function getLine() {
        return $this->line;
    }

    /**
     * @param CommentBlock|string $line
     */
    public function setLine($line) {
        $this->line = $line;
    }

    /**
     * @return string
     */
    public function getFeedback() {
        return $this->feedback;
    }

    /**
     * @param string $feedback
     */
    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }

    /**
     * @return float
     */
    public function getFogIndex(): float {
        return $this->fogIndex;
    }

    /**
     * @param float $fogIndex
     */
    public function setFogIndex(float $fogIndex) {
        $this->fogIndex = $fogIndex;
    }

}