<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {
    /**
     * Create token for user
     *
     * @param $userEmail
     * @param $userID
     *
     * @return string
     */
    public static function CreateToken( $userEmail, $userID ): string {
        $key     = env( 'JWT_KEY' );
        $payload = [
            'iss'       => 'laravel-token',
            'iat'       => time(),
            'exp'       => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userID'    => $userID
        ];

        return JWT::encode( $payload, $key, 'HS256' );
    }
}
