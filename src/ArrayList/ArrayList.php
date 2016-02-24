<?php namespace BuildR\Collection\ArrayList;

use BuildR\Collection\Collection\AbstractTypedCollection;
use BuildR\Collection\Collection\FilterableCollectionTrait;
use BuildR\Collection\Exception\ListException;

/**
 * ArrayList implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage ArrayList
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ArrayList extends AbstractTypedCollection implements ListInterface {

    use FilterableCollectionTrait;

    /**
     * ArrayList constructor.
     *
     * @param array|NULL $elements
     */
    public function __construct($elements = NULL) {
        if(is_array($elements)) {
            $this->addAll($elements);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function add($element) {
        $this->data[] = $element;
    }

    /**
     * {@inheritDoc}
     */
    public function addAll($elements) {
        foreach($elements as $element) {
            $this->add($element);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addTo($index, $element) {
        $index = $this->checkIndex($index);

        array_splice($this->data, $index, 0, $element);
    }

    /**
     * {@inheritDoc}
     */
    public function get($index) {
        $index = $this->checkIndex($index);

        return (isset($this->data[$index])) ? $this->data[$index] : NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function set($index, $element) {
        $index = $this->checkIndex($index);
        $returns = NULL;

        if(isset($this->data[$index])) {
            $returns = $this->data[$index];
        }

        $this->data[$index] = $element;

        return $returns;
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element) {
        return (array_search($element, $this->data, TRUE) === FALSE) ? FALSE : TRUE;
    }

    /**
     * {@inheritDoc}
     */
    public function containsAt($index) {
        $index = $this->checkIndex($index);

        return isset($this->data[$index]);
    }

    /**
     * {@inheritDoc}
     */
    public function containsAll($elements) {
        $elements = $this->collectionToArray($elements);

        $result = TRUE;

        foreach($elements as $item) {
            if($this->contains($item) === FALSE) {
                $result = FALSE;

                break;
            }
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function containsAny($elements) {
        $elements = $this->collectionToArray($elements);

        foreach($elements as $item) {
            if($this->contains($item) === TRUE) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($element) {
        return array_search($element, $this->data, TRUE);
    }

    /**
     * {@inheritDoc}
     */
    public function equals(ListInterface $collection) {
        if($collection->size() !== $this->size()) {
            return FALSE;
        }

        $elements = $collection->toArray();

        foreach($elements as $key => $value) {
            if(isset($this->data[$key]) && $this->data[$key] === $value) {
                continue;
            }

            return FALSE;
        }

        return TRUE;
    }

    /**
     * {@inheritDoc}
     */
    public function removeAt($index) {
        $index = $this->checkIndex($index);

        if(isset($this->data[$index])) {
            unset($this->data[$index]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function removeAll($elements) {
        $elements = $this->collectionToArray($elements);

        foreach($elements as $item) {
            $index = $this->indexOf($item);
            $this->removeAt($index);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function subList($offset, $length) {
        $slice = array_slice($this->data, $offset, $length, FALSE);

        return new static($slice);
    }

    /**
     * {@inheritDoc}
     */
    public function retainAll($elements) {
        $elements = $this->collectionToArray($elements);

        foreach($this->data as $index => $item) {
            if(array_search($item, $elements, TRUE) !== FALSE) {
                continue;
            }

            unset($this->data[$index]);
        }
    }

    /**
     * Validates the given index. Check if this a numeric value
     * and throws an exception if not. If the index is numeric
     * the value is casted to array and returned.
     *
     * @param mixed $index
     *
     * @return int
     *
     * @throws \BuildR\Collection\Exception\ListException
     */
    protected function checkIndex($index) {
        if(!is_numeric($index)) {
            throw ListException::nonNumericIndex(gettype($index));
        }

        return (int) $index;
    }

}
