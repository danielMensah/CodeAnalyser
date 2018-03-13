<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 25/01/2018
 * Time: 12:01
 */

class FunctionModel {

    /** @var string*/
    private $name;

    /** @var string[] */
    private $nParameters;

    /** @var int*/
    private $complexity;

    /** @var int*/
    private $nLoc;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getNParameters() {
        return $this->nParameters;
    }

    /**
     * @param array $nParameters
     */
    public function setNParameters($nParameters) {
        $this->nParameters = $nParameters;
    }

    /**
     * @return int
     */
    public function getComplexity() {
        return $this->complexity;
    }

    /**
     * @param int $complexity
     */
    public function setComplexity($complexity) {
        $this->complexity = $complexity;
    }

    /**
     * @return int
     */
    public function getNLoc() {
        return $this->nLoc;
    }

    /**
     * @param int $nLoc
     */
    public function setNLoc($nLoc) {
        $this->nLoc = $nLoc;
    }

}