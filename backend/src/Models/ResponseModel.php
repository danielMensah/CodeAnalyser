<?php
/**
 * Created by PhpStorm.
 * User: MrDan
 * Date: 08/02/2018
 * Time: 11:37
 */

require_once __DIR__ . "/ClassModel.php";

class ResponseModel {

    /** @var string */
    private $response;
    /** @var int*/
    private $errorLine;
    /** @var bool */
    private $valid;
    /** @var ClassModel */
    private $class;

    /**
     * @return string
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse($response) {
        $this->response = $response;
    }

    /**
     * @return int
     */
    public function getErrorLine() {
        return $this->errorLine;
    }

    /**
     * @param int $errorLine
     */
    public function setErrorLine($errorLine) {
        $this->errorLine = $errorLine;
    }

    /**
     * @return bool
     */
    public function isValid() {
        return $this->valid;
    }

    /**
     * @param bool $valid
     */
    public function setValid($valid) {
        $this->valid = $valid;
    }

    /**
     * @return ClassModel
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * @param ClassModel $class
     */
    public function setClass($class) {
        $this->class = $class;
    }

}