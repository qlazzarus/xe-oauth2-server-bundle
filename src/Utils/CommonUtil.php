<?php
/**
 * Created by PhpStorm.
 * User: ecst
 * Date: 2018-03-14
 * Time: 오후 1:52
 */

namespace Monoless\Xe\OAuth2\Server\Utils;


use Tuupola\Base62;

class CommonUtil
{
    const DELIMITER = '|*|';

    /**
     * @param string $email
     * @param string $mask
     * @return string
     */
    public static function obfuscateEmail($email, $mask = '*')
    {
        $em   = explode("@", $email);
        $name = implode(array_slice($em, 0, count($em) - 1), '@');
        $len  = floor(strlen($name) / 2);

        return implode([
            substr($name,0, $len),
            str_repeat($mask, $len),
            '@',
            end($em)
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public static function encodeId($id)
    {
        $base62 = new Base62();

        return $base62->encode(implode([
            $id,
            self::DELIMITER,
            Context::get('domain')
        ]));
    }

    /**
     * @param $encoded
     * @return string|null
     */
    public static function decodeId($encoded)
    {
        $base62 = new Base62();

        $decoded = explode(self::DELIMITER, $base62->decode($encoded));
        if (1 < count($decoded)) {
            return $decoded[0];
        } else {
            return null;
        }
    }
}