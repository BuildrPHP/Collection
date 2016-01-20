<?php namespace BuildR\Collection\ArrayList;

use BuildR\Collection\Collection\AbstractCollection;

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
class ArrayList extends AbstractCollection implements ArrayListInterface {

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
        array_splice($this->data, $index, 0, $element);
    }

    /**
     * {@inheritDoc}
     */
    public function get($index) {
        return (isset($this->data[$index])) ? $this->data[$index] : NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(callable $filter) {
        $result = array_filter($this->data, $filter, ARRAY_FILTER_USE_BOTH);

        return new static($result);
    }

    /**
     * {@inheritDoc}
     */
    public function set($index, $element) {
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
    public function equals(ArrayListInterface $collection) {
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

}
