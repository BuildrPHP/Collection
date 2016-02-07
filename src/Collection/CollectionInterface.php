<?php  namespace BuildR\Collection\Collection;

use BuildR\Foundation\Object\ArrayConvertibleInterface;
use \Iterator;
use \Countable;

/**
 * Common interface for all collection type
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
interface CollectionInterface extends Iterator, Countable, ArrayConvertibleInterface {

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

    /**
     * Reset the collection, remove all elements
     * and reset the collection index to 0. Returns itself.
     *
     * @return \Buildr\Collection\Collection\CollectionInterface
     */
    public function clear();

    /**
     * Determines that the current collection is empty or not
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Returns the size off the current collection.
     *
     * @return int
     */
    public function size();

}
