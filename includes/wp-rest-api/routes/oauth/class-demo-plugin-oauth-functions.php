<?php
namespace DemoPlugin\Rest\OAuth;

if (!defined('ABSPATH')) { exit; }

/**
 * OAuth helper functions (stubs).
 *
 * # Super Comments
 * #1 PURPOSE: Encapsulate token validation/exchange helpers.
 * #2 SECURITY: Replace stubs with real logic (provider calls, nonce/capability checks).
 */
final class OAuth_Functions
{
    /** #3 Validate a bearer token (stub). */
    public function validateBearer(string $token): bool
    {
        // TODO: Replace with real validation against your provider.
        return $token === 'dev-token';
    }

    /** #4 Exchange code for token (stub). */
    public function exchangeCodeForToken(string $code): array
    {
        // TODO: Implement provider call. Return access_token, expires_in, refresh_token etc.
        return [
            'access_token' => 'dev-access',
            'token_type'   => 'Bearer',
            'expires_in'   => 3600,
        ];
    }
}
