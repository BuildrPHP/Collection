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
