<?php

declare(strict_types=1);

namespace App\Encryption;

use Defuse\Crypto\Crypto as CryptoVendor;
use Defuse\Crypto\Key;
use RuntimeException;

class Crypto
{
    private static Key $key;

    public static function encrypt(string $data): string
    {
        return CryptoVendor::encrypt($data, self::getKey());
    }

    public static function decrypt(string $data): string
    {
        return CryptoVendor::decrypt($data, self::getKey());
    }

    /**
     * @param array<mixed> $data
     *
     * @return array<mixed>
     */
    public static function encryptArray(array $data): array
    {
        array_walk_recursive($data, function (&$value) {
            $value = self::encrypt($value);
        });

        return $data;
    }

    /**
     * @param array<mixed> $data
     *
     * @return array<mixed>
     */
    public static function decryptArray(array $data): array
    {
        array_walk_recursive($data, function (&$value) {
            $value = self::decrypt($value);
        });

        return $data;
    }

    private static function getKey(): Key
    {
        if (!isset(self::$key)) {
            $key = $_ENV['OPENSSL_KEY'];
            if (empty($key)) {
                throw new RuntimeException('OPENSSL_KEY is not set');
            }
            self::$key = Key::loadFromAsciiSafeString($key);
        }

        return self::$key;
    }
}
