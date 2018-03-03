<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 25/01/2018
 * Time: 11:58
 */

require_once __DIR__ . "/../Models/CommentModel.php";
require_once __DIR__ . "/../Models/FunctionModel.php";

class ClassModel {

    /** @var string*/
    private $name;
    /** @var int*/
    private $NLoc;
    /** @var array*/
    private $variables;
    /** @var CommentModel[] */
    private $comments;
    /** @var  FunctionModel[] */
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
     * @return CommentModel[]
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * @param CommentModel[] $comments
     */
    public function setComments($comments) {
        $this->comments = $comments;
    }

    /**
     * @return FunctionModel[]
     */
    public function getFunctions(): array {
        return $this->functions;
    }

    /**
     * @param FunctionModel[] $functions
     */
    public function setFunctions(array $functions) {
        $this->functions = $functions;
    }

}