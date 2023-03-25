<?php

// 1203153680630696 - Transition from Kickbox to BriteVerify

/**
 * Verify emails via Brite Verify alghorithm and API
 *
 * @param  string  $email 	  		The email to verify
 * @return array   $validation 		returns is_valid, suggestion, message and code
 */
function brite_verfiy_email($email){

	// check if api key is available
	if(!defined('BRITE_VERIFY_API_KEY')) return [
		'is_valid' => false,
		'message' => 'No API key is available',
		'code' 		=> 403
	];

	$args = [
		'headers' => [
			'X-API-KEY' => BRITE_VERIFY_API_KEY
		]
	];

	$url = "https://api.everest.validity.com/api/2.0/validation/addresses/{$email}";

	$wp_response 	 = wp_remote_get($url, $args);

	$response_code = wp_remote_retrieve_response_code($wp_response);

	if (is_wp_error($wp_response)) {

		return [
			'is_valid' => false,
			'message' => $wp_response->get_error_message(),
			'code' 		=> $response_code
		];

	} else {

		$typo_suggestion = '';

		$response_body = json_decode(wp_remote_retrieve_body($wp_response));

		/**
		 * Check if the response is set
		 */
		if (isset($response_body->results)) {
			/**
			 * Check the email status
			 */
			$status = $response_body->results->category;

			$diagnostics = $response_body->results->diagnostics;
			$typo_suggestion = isset($diagnostics->typo_suggestion) && !empty($diagnostics->typo_suggestion) ? $diagnostics->typo_suggestion : '';

			$accepted_statuses = [
				'valid',
				'accept_all',
				'unknown',
				'role_address',
				'mailbox_full_invalid'
			];

			if (in_array($status, $accepted_statuses)) {

				return [
					'is_valid' => true,
					'message' => 'The email is valid',
					'code' 		=> $response_code,
					'suggestion' => $typo_suggestion
				];
			} else {
				/**
				 * Invalid email
				 */
				return [
					'is_valid' 	 => false,
					'message' 	 => 'The email is not valid',
					'code' 		 => $response_code,
					'suggestion' => $typo_suggestion
				];
			}
		} else {
			/**
			 * Invalid response
			 */
			return [
				'is_valid' => false,
				'message' => 'Failed to retrieve the response.',
				'code' 		=> $response_code,
				'suggestion' => $typo_suggestion
			];
		}
	}

	/**
	 * Handle unknown error
	 */
	return [
		'is_valid' => false,
		'message' => 'Unknown error',
		'code' 		=> '0'
	];
}

add_filter('tdu_shortcode_email_verification','tdu_verfiy_shortcode_email_via_brite_verify', 10, 2);
function tdu_verfiy_shortcode_email_via_brite_verify($is_valid, $email){;
	$validation = brite_verfiy_email($email);

	return $validation;
}