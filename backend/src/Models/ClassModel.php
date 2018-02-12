<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 25/01/2018
 * Time: 11:58
 */

require_once __DIR__ . "/../Models/Comment.php";

class ClassModel {

    /** @var string*/
    private $name;
    /** @var int*/
    private $NLoc;
    /** @var array*/
    private $variables;
    /** @var Comment[] */
    private $comments;
    private $functions;

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
     * @return int
     */
    public function getNLoc() {
        return $this->NLoc;
    }

    /**
     * @param int $NLoc
     */
    public function setNLoc($NLoc) {
        $this->NLoc = $NLoc;
    }

    /**
     * @return array
     */
    public function getVariables() {
        return $this->variables;
    }

    /**
     * @param array $variables
     */
    public function setVariables($variables) {
        $this->variables = $variables;
    }

    /**
     * @return Comment[]
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments($comments) {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getFunctions() {
        return $this->functions;
    }

    /**
     * @param mixed $functions
     */
    public function setFunctions($functions) {
        $this->functions = $functions;
    }

}