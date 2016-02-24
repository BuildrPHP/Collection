<?php namespace BuildR\Collection\Collection;

use BuildR\Collection\Utils\ArrayFilter;

/**
 * Trait for filterable collections
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
 * @codeCoverageIgnore
 */
trait FilterableCollectionTrait {

    /**
     * Returns a new list that only contains the element which the filter is returned.
     * The filter is accept any callable type.
     *
     * The callable takes two argument, the first is the key and the second is the
     * value of the element.
     *
     * @param callable $filter
     *
     * @return \BuildR\Collection\ArrayList\ListInterface
     */
    public function filter(callable $filter) {
        $result = ArrayFilter::execute($this->data, $filter);

        return new self($result);
    }

}
