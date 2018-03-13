<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 13/03/2018
 * Time: 12:18
 */

use DaveChild\TextStatistics as TS;

class FogIndexController {

    /**
     * @param string $comment
     * @return int
     */
    public function calculateFogIndex(string $comment) {
        $textStatistics = new TS\TextStatistics;
        $comment = str_replace("*", "", $comment);

        return  round($textStatistics->gunning_fog_score($comment));
    }

}