<?php namespace BuildR\Collection\Set;

use BuildR\Collection\Collection\AbstractCollection;
use BuildR\Collection\Exception\CollectionException;

/**
 * Set type (Collection implementation)
 * Sets only store scalar types
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Set
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Set extends AbstractCollection implements SetInterface {

    /**
     * Set constructor.
     *
     * @param null|array $values
     */
    public function __construct($values = NULL) {
        if(is_array($values)) {
            $this->addAll($values);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function equals(SetInterface $collection) {
        //First check the size, if this not equals the tow collection
        //not be identical
        if($collection->size() !== $this->size()) {
            return FALSE;
        }

        //Use strict comparison to check arrays are equals
        //(Values and orders)
        return $collection->toArray() === $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function add($element) {
        if(!is_scalar($element)) {
            throw CollectionException::nonScalarTypeGiven(gettype($element));
        }

        if(!$this->contains($element)) {
            $this->data[] = $element;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addAll($elements) {
        $elements = $this->collectionToArray($elements);

        foreach($elements as $item) {
            $this->add($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($element) {
        if(($index = array_search($element, $this->data)) !== FALSE) {
            unset($this->data[$index]);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll($elements) {
        $elements = $this->collectionToArray($elements);

        $result = FALSE;

        foreach($elements as $item) {
            if($this->remove($item) === TRUE) {
                $result = TRUE;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function retainAll($elements) {
        $elements = $this->collectionToArray($elements);

        $result = FALSE;

        foreach($this->data as $index => $data) {
            if(array_search($data, $elements) === FALSE) {
                unset($this->data[$index]);

                $result = TRUE;
            }
        }

        return $result;
    }

}
