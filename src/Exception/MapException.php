<?php namespace BuildR\Collection\Exception;

use BuildR\Foundation\Exception\Exception;

class MapException extends Exception {

    const MESSAGE_NON_VALID_KEY = "Only scalar keys allowed, %s given in!";

    /**
     * @param mixed $key
     *
     * @return self
     */
    public static function notValidKey($key) {
        $type = gettype($key);

        return self::createByFormat(self::MESSAGE_NON_VALID_KEY, [$type]);
    }

}
