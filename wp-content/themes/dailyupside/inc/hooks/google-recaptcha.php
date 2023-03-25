<?php
// #1202577986767434 - reCAPTCHA For new subscription form
/**
 * Verify emails via Kickbox alghorithm and API
 *
 * @param  string  $email       The email to verify
 * @return boolean $is_valid        True if the email is valid
 */
function google_recaptcha_verify($response, $ip = ''){
    if (!defined('GOOGLE_RECAPTCHA_SECRET_KEY') || empty(GOOGLE_RECAPTCHA_SECRET_KEY)) {
        return [
            'verified' => false,
            'message' => 'Google Recaptcha secret key is missing',
            'code'      => 401
        ];
    }
    if (!defined('GOOGLE_RECAPTCHA_SCORE') || empty(GOOGLE_RECAPTCHA_SCORE)) {
        return [
            'verified'  => false,
            'message'   => 'Google Recaptcha score is missing',
            'code'      => 401
        ];
    }
    /**
     * The response reference form Google verify endpiont
     * and their labels
     */
    $g_error_reference = [
        'missing-input-secret' => 'The secret parameter is missing.',
        'invalid-input-secret' => 'The secret parameter is invalid or malformed.',
        'missing-input-response' => 'The response parameter is missing.',
        'invalid-input-response' => 'The response parameter is invalid or malformed.',
        'bad-request' => 'The request is invalid or malformed.',
        'timeout-or-duplicate' => 'The response is no longer valid: either is too old or has been used previously.',
        'incorrect-captcha-sol' => "Incorrect Captcha Sol"
    ];

    $url = "https://www.google.com/recaptcha/api/siteverify";
    /**
     * Google recaptcha verify payload
     *
     * @param string $secret        the secret key Google Recaptcha V3
     * @param string $response      the response sent by the form
     * @param string $ip            the user's IP address (optional)
    */
    $data = [
        'secret' => GOOGLE_RECAPTCHA_SECRET_KEY,
        'response' => $response,
    ];

    if (!empty($ip)) $data['ip'] = $ip;

    $args = [
        'body'        => $data
    ];

    $wp_response     = wp_remote_post($url, $args);
    $response_code   = wp_remote_retrieve_response_code($wp_response);

    /**
     * If request fails generally
     */
    if (is_wp_error($wp_response)) {
        return [
            'verified' => false,
            'message'  => $wp_response->get_error_message(),
            'code'     => $response_code
        ];
    } else {
            $response_body = json_decode(wp_remote_retrieve_body($wp_response), true);
            /**
             * Check if the response is set
             */
            if ($response_body) {
                /**
                 * Check if is verified
                 */
                if ($response_body['success'] && $response_body['score'] >= GOOGLE_RECAPTCHA_SCORE ) {
                    return [
                        'verified' => true,
                        'message'  => 'Verified request',
                        'code'     => $response_code,
                        'score'    => $response_body['score']
                    ];
                } else {
                    return [
                        'verified' => false,
                        'message'  => isset($response_body['error-codes']) ? 
                                     (isset($g_error_reference[$response_body['error-codes'][0]]) ?
                                        $g_error_reference[$response_body['error-codes'][0]] :
                                        'Error!'   
                                    ) :
                                     'Error!',
                        'code'     => $response_code,
                        'score'    => isset($response_body['score']) ? $response_body['score'] : -2
                    ];
                }
            } else {
                /**
                 * Invalid response
                 */
                return [
                    'verified'  => false,
                    'message'   => 'Failed to retrieve the response.',
                    'code'      => $response_code
                ];
            }
    }
    /**
     * Handle unknown error
     */
    return [
        'is_valid'  => false,
        'message'   => 'Unknown error',
        'code'      => '0'
    ];
}
/**
 * Add Google Recaptcha v3 to [subscribe-form] shortcode 
 * 
 * @param string $response          Google recaptcha response token
 */

// Commented for #1203408238302129 implementation
// add_action('tdu_shortcode_after_nonce_check', 'tdu_add_google_recaptcha_to_shortcode', 10, 1);
function tdu_add_google_recaptcha_to_shortcode($response){
    $validation = google_recaptcha_verify($response);
    if (!$validation['verified']) {
        wp_send_json([
            'success' => false,
            'error'   => $validation['message'],
            'message' => 'Invalid request'
        ], 400);
    }
}