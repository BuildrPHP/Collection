<?php namespace BuildR\Collection\Collection;

/**
 * Common interface for all collection that able to set to take only
 * certain types of elements
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
 */
interface StrictlyTypedCollectionInterface {

    /**
     * Set the type of the current collection. The callable must be returns a boolean.
     * The callable take exactly one argument as the current value
     *
     * @param callable $typeCheck The type checker function that returns a boolean
     * @param string $message
     */
    public function setStrictType(callable $typeCheck, $message = NULL);

    /**
     * Determines that the current collection is strictly typed or not
     *
     * @return bool
     */
    public function isStrict();

}
