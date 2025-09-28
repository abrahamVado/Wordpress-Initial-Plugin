<?php
namespace DemoPlugin\Rest\OAuth;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

if (!defined('ABSPATH')) { exit; }

/**
 * Registers OAuth endpoints under the plugin namespace.
 *
 * # Super Comments
 * #1 ROUTES:
 *    - POST /oauth/token   : code -> token exchange (stub)
 *    - GET  /oauth/verify  : verify bearer token (stub)
 * #2 AUTH:
 *    - CSRF: For POST, verify nonce if using cookie auth in WP.
 *    - Capability checks where appropriate for privileged routes.
 */
final class OAuth_Routes
{
    private string $namespace;
    private OAuth_Functions $fn;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
        $this->fn = new OAuth_Functions();
    }

    /** #3 Register routes with WP REST API. */
    public function register(): void
    {
        register_rest_route($this->namespace, '/oauth/token', [
            'methods'  => 'POST',
            'callback' => [$this, 'postToken'],
            'permission_callback' => '__return_true', // Replace with stricter rules if needed.
        ]);

        register_rest_route($this->namespace, '/oauth/verify', [
            'methods'  => 'GET',
            'callback' => [$this, 'getVerify'],
            'permission_callback' => '__return_true',
        ]);
    }

    /** #4 POST /oauth/token : exchange code for token (stub). */
    public function postToken(WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        $code = (string) $request->get_param('code');
        if ($code === '') {
            return new WP_Error('bad_request', 'Missing code', ['status' => 400]);
        }
        $data = $this->fn->exchangeCodeForToken($code);
        return new WP_REST_Response($data, 200);
    }

    /** #5 GET /oauth/verify : simple bearer token verification (stub). */
    public function getVerify(WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        $auth = $request->get_header('authorization');
        if (!$auth || stripos($auth, 'Bearer ') !== 0) {
            return new WP_Error('unauthorized', 'Missing bearer token', ['status' => 401]);
        }
        $token = trim(substr($auth, 7));
        if (!$this->fn->validateBearer($token)) {
            return new WP_Error('forbidden', 'Invalid token', ['status' => 403]);
        }
        return new WP_REST_Response(['ok' => true], 200);
    }
}
