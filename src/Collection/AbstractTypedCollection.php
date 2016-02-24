<?php namespace BuildR\Collection\Collection;

use BuildR\Collection\Collection\AbstractCollection;
use BuildR\Collection\Collection\StrictlyTypedCollectionInterface;

/**
 * Abstract collection implementation for collections that supports
 * strict typing functionality
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
class AbstractTypedCollection extends AbstractCollection implements StrictlyTypedCollectionInterface {

    use StrictlyTypedCollectionTrait;

}
