<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 13/03/2018
 * Time: 12:18
 */

use DaveChild\TextStatistics as TS;

class ReadabilityController {

    /** @var TS\TextStatistics */
    private $textStatistics;

    /**
     * ReadabilityController constructor.
     */
    public function __construct() {
        $this->textStatistics = new TS\TextStatistics;
    }

    /**
     * @param string $comment
     * @return int
     */
    public function gunningFogIndex(string $comment) {
        $comment = self::sanitizer($comment);
        return round($this->textStatistics->gunning_fog_score($comment));
    }

    /**
     * @param string $comment
     * @return float|int
     */
    public function fleschKincaidReadingEase(string $comment) {
        $comment = self::sanitizer($comment);
        return $this->textStatistics->flesch_kincaid_reading_ease($comment);
    }

    /**
     * @param string $comment
     * @return float|int
     */
    public function fleschKincaidGradeLevel(string $comment) {
        $comment = self::sanitizer($comment);
        return $this->textStatistics->flesch_kincaid_grade_level($comment);
    }

    /**
     * @param string $comment
     * @return float|int
     */
    public function colemanLiauIndex(string $comment) {
        $comment = self::sanitizer($comment);
        return $this->textStatistics->coleman_liau_index($comment);
    }

    /**
     * @param string $comment
     * @return float|int
     */
    public function smogIndex(string $comment) {
        $comment = self::sanitizer($comment);
        return round($this->textStatistics->smog_index($comment));
    }

    /**
     * @param string $comment
     * @return float|int
     */
    public function automatedReadabilityIndex(string $comment) {
        $comment = self::sanitizer($comment);
        return $this->textStatistics->automated_readability_index($comment);
    }

    /**
     * @param string $comment
     * @return string
     */
    public function sanitizer(string $comment) {
        $sanitizedComment = str_replace("/", "", str_replace("*", "", $comment));
        return ltrim(rtrim($sanitizedComment)); //removing leading and trailing whitespaces
    }

    /**
     * @param $score
     * @param $readabilityType
     * @return string
     */
    public function scoreComment($score, $readabilityType) {
        if ($readabilityType === 'fleschKincaidReadingEase') return self::fleschKincaidReadingEaseScore($score);

        if ($score <= 5) return GRADE_1_5;
        if (between(6, 8, $score)) return GRADE_6_8;
        if (between(9, 12, $score)) return GRADE_9_12;

        return GRADE_OVER_12;
    }

    /**
     * @param $score
     * @return string
     */
    public function fleschKincaidReadingEaseScore($score) {
        if ($score <= 30) return FK_READING_EASE_LEVEL_GRADE_GRADUATE;
        if (between(30, 50, $score)) return FK_READING_EASE_LEVEL_GRADE_COLLEGE;
        if (between(50, 60, $score)) return FK_READING_EASE_LEVEL_GRADE_10_12;
        if (between(60, 70, $score)) return FK_READING_EASE_LEVEL_GRADE_8_9;
        if (between(70, 80, $score)) return FK_READING_EASE_LEVEL_GRADE_7;
        if (between(80, 90, $score)) return FK_READING_EASE_LEVEL_GRADE_6;

        return FK_READING_EASE_LEVEL_GRADE_5;
    }

}