<?php

// 1202395263674625 - Kickbox - Email verifier

/**
 * Verify emails via Kickbox alghorithm and API
 *
 * @param  string  $email 	  	The email to verify
 * @return boolean $is_valid 		True if the email is valid
 */
function kickbox_verfiy_email($email){

	// check if api key is available
	if(!defined('KICKBOX_API_KEY')) return [
		'is_valid' => false,
		'message' => 'No API key is available',
		'code' 		=> 403
	];

	$apikey = KICKBOX_API_KEY;
	$url = "https://api.kickbox.com/v2/verify?email={$email}&apikey={$apikey}";

	$wp_response 	 = wp_remote_get($url);

	$response_code = wp_remote_retrieve_response_code($wp_response);

	if (is_wp_error($wp_response)) {
		return [
			'is_valid' => false,
			'message' => $wp_response->get_error_message(),
			'code' 		=> $response_code
		];
	} else {
			$response_body = json_decode(wp_remote_retrieve_body($wp_response));
			/**
			 * Check if the response is set
			 */
			if ($response_body) {
				/**
				 * Check the email status
				 */
				if ($response_body->result == 'deliverable' ||
					($response_body->result == 'risky' && $response_body->accept_all == true) ||
					$response_body->result == 'unknown'
				) {

					return [
						'is_valid' => true,
						'message' => 'The email is valid',
						'code' 		=> $response_code
					];
				} else {
					/**
					 * Invalid email
					 */
					return [
						'is_valid' => false,
						'message' => 'The email is not valid',
						'code' 		=> $response_code
					];
				}
			} else {
				/**
				 * Invalid response
				 */
				return [
					'is_valid' => false,
					'message' => 'Failed to retrieve the response.',
					'code' 		=> $response_code
				];
			}
	}

	/**
	 * Handle unknow error
	 */
	return [
		'is_valid' => false,
		'message' => 'Unknown error',
		'code' 		=> '0'
	];
}

add_filter('tdu_shortcode_email_verification','tdu_verfiy_shortcode_email_via_kickbox', 10, 2);
function tdu_verfiy_shortcode_email_via_kickbox($is_valid, $email){
	if (function_exists('kickbox_verfiy_email')) {
		$validation = kickbox_verfiy_email($email);
		$is_valid = $validation['is_valid'];
	}

	return $is_valid;
}