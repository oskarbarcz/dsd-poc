<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 24 August 2018
 * Time: 23:50
 */

namespace PasswordManager\Model;


class RandomStringGenerator
{
    const BASIC = 'basic';
    const ALPHA = 'alpha';
    const ALPHANUM = 'alphanum';
    const NUM = 'num';
    const NOZERO = 'nozero';
    const UNIQUE = 'unique';
    const MD5 = 'md5';

    /**
     * Generates random string by given parameters
     *
     * @param string $type
     * @param int $length
     * @return int|string
     */
    public static function generate(string $type = 'alphanum', int $length = 8)
    {
        switch ($type) {
            case self::BASIC:
                return mt_rand();
                break;
            case self::ALPHA:
            case self::ALPHANUM:
            case self::NUM:
            case self::NOZERO:
                $seedings = [];
                $seedings['alpha'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $seedings['alphanum'] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $seedings['num'] = '0123456789';
                $seedings['nozero'] = '123456789';

                $pool = $seedings[$type];

                $str = '';
                for ($i = 0; $i < $length; $i++) {
                    $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
                }
                return $str;
                break;
            case UNIQUE:
            case MD5:
                return md5(uniqid(mt_rand()));
                break;
        }
    }
}