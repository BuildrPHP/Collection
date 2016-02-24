<?php namespace BuildR\Collection\Collection;

use BuildR\Collection\Exception\CollectionException;

/**
 * Trait for collections that can be strictly typed
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 */
trait StrictlyTypedCollectionTrait {

    /**
     * @type NULL|callable
     */
    protected $typeChecker;

    /**
     * @type NULL|string
     */
    protected $typeCheckFailMessage;

    /**
     * {@inheritdoc}
     */
    public function setStrictType(callable $typeCheck, $message = NULL) {
        $this->typeChecker = $typeCheck;
        $this->typeCheckFailMessage = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function isStrict() {
        return is_callable($this->typeChecker);
    }

    /**
     * Executes the type check if the collection is strict. Always
     * returns true, when the collection is not strictly typed
     *
     * @param mixed $value
     *
     * @return bool
     *
     * @throws \BuildR\Collection\Exception\CollectionException
     */
    protected function doTypeCheck($value) {
        if($this->isStrict()) {
            $result = (bool) call_user_func_array($this->typeChecker, [$value]);

            if($result === FALSE) {
                $message = ($this->typeCheckFailMessage === NULL) ? gettype($value) : $this->typeCheckFailMessage;

                throw CollectionException::typeException($message);
            }

            return TRUE;
        }
    }

}
