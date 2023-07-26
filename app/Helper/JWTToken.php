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


    /**
     * Create token for set password
     *
     * @param $userEmail
     *
     * @return string
     */
    public static function CreateTokenForSetPassword( $userEmail ): string {
        $key     = env( 'JWT_KEY' );
        $payload = [
            'iss'       => 'laravel-token',
            'iat'       => time(),
            'exp'       => time() + 60 * 20,
            'userEmail' => $userEmail,
            'userID'    => '0'
        ];

        return JWT::encode( $payload, $key, 'HS256' );
    }


    /**
     * Create token for verify email
     *
     * @param $token
     *
     * @return object|string
     */
    public static function VerifyToken( $token ): object|string {
        try {
            if ( $token == null ) {
                return 'unauthorized';
            } else {
                $key = env( 'JWT_KEY' );

                return JWT::decode( $token, new Key( $key, 'HS256' ) );
            }
        } catch ( Exception $e ) {
            return 'unauthorized';
        }
    }
}
