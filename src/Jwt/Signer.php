<?php

declare (strict_types = 1);

namespace Larke\Admin\Jwt;

use Larke\Admin\Jwt\Signer; 

/*
 * Signer
 *
 * @create 2023-2-4
 * @author deatil
 */
class Signer
{
    /**
     * 签名类型列表
     */
    protected static array $signers = [
        // 空加密
        'none' => Signer\None::class,
        
        // Hmac 加密
        'HS256' => Signer\Hmac\Sha256::class,
        'HS384' => Signer\Hmac\Sha384::class,
        'HS512' => Signer\Hmac\Sha512::class,
        
        // Rsa 加密
        'RS256' => Signer\Rsa\Sha256::class,
        'RS384' => Signer\Rsa\Sha384::class,
        'RS512' => Signer\Rsa\Sha512::class,
        
        // Ecdsa 加密
        'ES256' => Signer\Ecdsa\Sha256::class,
        'ES384' => Signer\Ecdsa\Sha384::class,
        'ES512' => Signer\Ecdsa\Sha512::class,
        
        // Secp256k1
        'ES256K' => Signer\Ecdsa\Sha256k::class,
        
        // Eddsa 加密
        'EdDSA' => Signer\Eddsa::class,
        
        // Blake2b 加密
        'Blake2b' => Signer\Blake2b::class,
    ];
    
    /**
     * 注册签名方法
     */
    public static function addSigningMethod(string $algorithm, string $signer): void
    {
        static::$signers[$algorithm] = $signer;
    }
    
    /**
     * 判断签名方法是否存在
     */
    public static function hasSigningMethod(string $algorithm): bool
    {
        return isset(static::$signers[$algorithm]);
    }
    
    /**
     * 获取签名方法
     */
    public static function getSigningMethod(string $algorithm): string
    {
        if (isset(static::$signers[$algorithm])) {
            return static::$signers[$algorithm];
        }
        
        return "";
    }
    
    /**
     * 获取全部签名方法
     */
    public static function getAllSigningMethod(): array
    {
        return static::$signers;
    }
}
