<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 07/02/2018
 * Time: 12:01
 */

class CommentBlock {

    /** @var int */
    private $start;
    /** @var int */
    private $end;

    /**
     * @return int
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @param int $start
     */
    public function setStart($start) {
        $this->start = $start;
    }

    /**
     * @return int
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * @param int $end
     */
    public function setEnd($end) {
        $this->end = $end;
    }

}