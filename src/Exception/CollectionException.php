<?php namespace BuildR\Collection\Exception;

use BuildR\Foundation\Exception\Exception;

/**
 * This exception is thrown by any CollectionInterface implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Exception
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class CollectionException extends Exception {

    const MESSAGE_NON_SCALAR_TYPE = "This collection only store scalar types! %s given!";

    const MESSAGE_INVALID_TYPE = "This element is not has valid type for this collection! (%s)";

    public static function nonScalarTypeGiven($typeGiven) {
        return self::createByFormat(self::MESSAGE_NON_SCALAR_TYPE, [$typeGiven]);
    }

    public static function typeException($message) {
        return self::createByFormat(self::MESSAGE_INVALID_TYPE, [$message]);
    }

}
