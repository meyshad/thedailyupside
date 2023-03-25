<?php

function tdu_get_the_user_ip() {

	if (!empty( $_SERVER['HTTP_CLIENT_IP'])) {
		//check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty( $_SERVER['HTTP_X_FORWARDED_FOR'])) {
		//to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip;
	
}

function tdu_subscribe_form($args) {

	$args = shortcode_atts([
		'placeholder' => '',
		'button-text' => '',
		'classes' => '',
		'listid' => '',
		'source' => '',
		'medium' => '',
		'honeypot-treshold' => 5,
		'redirect-url' => ''
	], $args, 'subscribe-form');

	$placeholder 	= isset($args['placeholder']) && !empty($args['placeholder']) ? $args['placeholder'] : 'Enter your email';
	$button_text 	= isset($args['button-text']) && !empty($args['button-text']) ? $args['button-text'] : 'Subscribe';
	$redirect_url = isset($args['redirect-url']) ? $args['redirect-url'] : home_url('/thank-you');


	// Main form classes
	$classes = isset($args['classes']) ? ' '.$args['classes'] : '';
	$honeypot_treshold = isset($args['honeypot-treshold']) ? $args['honeypot-treshold'] : 5;

	// Check URL paramteres
	$listid = isset($_GET['listid']) ? $_GET['listid'] : '';
	$source = isset($_GET['utm_source']) ? $_GET['utm_source'] : '';
	$medium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : '';

	// Clean spaces and +
	$source = str_replace([" ", "+"], ["", ""], $source);
	$medium = str_replace([" ", "+"], ["", ""], $medium);

	// Override URL parameters over shortcode attributes
	$listid = empty($listid) ? $args['listid'] : $listid;
	$source = empty($source) ? $args['source'] : $source;
	$medium = empty($medium) ? $args['medium'] : $medium;

	// Sanitize
	$listid = sanitize_text_field($listid);
	$source = sanitize_text_field($source);
	$medium = sanitize_text_field($medium);

	// Escape HTML to prevent XSS attacks
	$listid = esc_html($listid);
	$source = esc_html($source);
	$medium = esc_html($medium);

	// escape attributes to prevent HTML, JS errors
	$listid = esc_attr($listid);
	$source = esc_attr($source);
	$medium = esc_attr($medium);

	if (!wp_script_is('subscribe_form_recaptcha', 'enqueued')) {
	  wp_enqueue_script('subscribe_form_recaptcha', 'https://www.google.com/recaptcha/api.js?render='.GOOGLE_RECAPTCHA_SITE_KEY, [],'1.0.0', true);
	}

	/**
	 * Enqueue script to handle AJAX
	 *
	 */
	if (!wp_script_is('subscribe_form_handler', 'enqueued')) {
      wp_enqueue_script('subscribe_form_handler', get_template_directory_uri().'/assets/scripts/subscribe-form-handler.js', [],'1.4.0', true );

	  $options = [
			'wpnonce' 	  => wp_create_nonce('wp_rest'),
			'ajax_url' 	  => home_url('/wp-json/ajax/v1/signup'),
			'recaptcha_site_key' => GOOGLE_RECAPTCHA_SITE_KEY,
			'hp_treshold' => $honeypot_treshold // honeypot treshold
	  ];

      wp_localize_script('subscribe_form_handler', 'subscribe_form_handler', $options);
    }

	$out = '';

	$out = '
	<form action="" class="subscribe-form'.$classes.'">
      <input type="text" name="subscribe_form_email" placeholder="'.$placeholder.'">
      <input type="text" name="subscribe_form_name" placeholder="Enter your name" value="" class="c-subscribe-from_field">
      <button class="c-btn" id="subscribe-form-submit" type="submit">'.$button_text.'</button>
      <div class="subscribe-form-message"></div>
        <div class="subscribe-form-vars">
					<input type="hidden" class="subscribe-form-param" name="params[listid]" value="'.$listid.'">
					<input type="hidden" class="subscribe-form-param" name="params[source]" value="'.$source.'">
					<input type="hidden" class="subscribe-form-param" name="params[medium]" value="'.$medium.'">
					<input type="hidden" class="subscribe-form-param" name="params[redirect_url]" value="'.$redirect_url.'">
        </div>
    </form>
	';

	return $out;
}

add_shortcode('subscribe-form', 'tdu_subscribe_form');

/**
  * Do the AJAX and send to the Campaign Monitor
  *
  * @param string POST['wpnonce'] 							WP request nonce
  * @param string POST['g_response'] 						Google recaptcha response token
  * @param string POST['subscribe_form_email'] 	User's sign up email
  * @param array POST['params'] 								CM listid, UTM source and UTM medium
  *
  * @return JSON response 											Echo JSON response
  */
function tdu_subscribe_form_submit($request) {

		/**
		 * Check Google Recaptcha first
		 */
		$g_response = sanitize_text_field($request->get_param('g_response'));

		do_action('tdu_shortcode_after_nonce_check', $g_response);

		// verify Google Recaptcha response
		$validation = google_recaptcha_verify($g_response);
		if (!$validation['verified']) {
			return new WP_Error(
				$validation['message'],
				'Invalid request',
				['status' => 406]
			);
		}
		/**
		 * Add honeypot trap with name
		 */
		$honeypot_name 				  = !empty($request->get_param('subscribe_form_name')) ? sanitize_text_field($request->get_param('subscribe_form_name')) : '';
		$honeypot_time 				  = !empty($request->get_param('hp_ts')) ? sanitize_text_field($request->get_param('hp_ts')) : 0;
		$honeypot_try 				  = !empty($request->get_param('hp_try')) ? sanitize_text_field($request->get_param('hp_try')) : 0;
		$honeypot_treshold 			= !empty($request->get_param('hp_treshold')) ? sanitize_text_field($request->get_param('hp_treshold')) : 5;

		if (!empty($honeypot_name) || ($honeypot_time < $honeypot_treshold && $honeypot_try < 1)) {
			return new WP_Error(
				"Invalid request",
				"Invalid request.",
				['status' => 425]
			);
		}

		$email  = sanitize_text_field($request->get_param('subscribe_form_email'));
		$params = $request->get_param('params');
		$listid = !empty($params['listid']) ? sanitize_text_field($params['listid']) : '';
		$source = !empty($params['source']) ? sanitize_text_field($params['source']) : '';
		$medium = !empty($params['medium']) ? sanitize_text_field($params['medium']) : '';

		$redirect_url = !empty($params['redirect_url']) ? sanitize_url($params['redirect_url']) : '';

		/**
		 * Apply block rules
		 */
		
		// block by UTM source
		if (strtolower($source) == 'wordseed') {
			return new WP_Error(
				"Request not allowed",
				"Request not allowed.",
				['status' => 403]
			);
		}

		$validation_result = apply_filters('tdu_shortcode_email_verification',true, $email);

		if(empty($email)) {

			return new WP_Error(
				"Required email",
				"You need to enter an email",
				['status' => 400]
			);

		} else if (!is_email($email) || !$validation_result['is_valid']) {

			return new WP_Error(
				"Invalid email",
				"Please enter a valid email",
				[
					'status' => 400,
					'suggestion' => isset($validation_result['suggestion']) ? $validation_result['suggestion'] : ''
				]
			);

		}

		$fingerprint_ip = tdu_get_the_user_ip();

		$data = [
			'EmailAddress'	=> $email,
			// 'Name'	=> '', // for the future
			'CustomFields'	=> [
				['Key' => 'source', 'Value' => $source],
				['Key' => 'medium', 'Value' => $medium]
				
			],
			// 'Resubscribe' => true,
			// 'RestartSubscriptionBasedAutoresponders' => true,
			'ConsentToTrack' => "Unchanged"
		];

		if ($fingerprint_ip) {
			$data['CustomFields'][] = ['Key' => 'fingerprint_ip', 'Value' => md5($fingerprint_ip)];
		}

		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;
		if ($user_agent) {
			$data['CustomFields'][] = ['Key' => 'fingerprint_user_agent', 'Value' => $user_agent];
		}
		
		$validation_score = isset($validation['score']) && !empty($validation['score']) ? $validation['score'] : -1;
		$data['CustomFields'][] = ['Key' => 'fingerprint_recaptcha_score', 'Value' => $validation_score];
		
		/**
		 * The CM Athentication type is basic
		 *
		 * @param username 		is the API key CAMPAIGN_MONITOR_API_KEY
		 * @param password		no needed and can be blank
		*/
		$args = [
			'headers'     => [
				'Content-Type'  => 'application/json; charset=utf-8',
			    'Authorization' => 'Basic ' . base64_encode(CAMPAIGN_MONITOR_API_KEY.':x')
			],
			'timeout' 	  => 60,
			'body'		  => json_encode($data),
			'method'      => 'POST',
			'data_format' => 'body'
		];

		// to check to see if the subscriber is already in the unsubscribed list
		$resubscribed = false;

		// Campaign Monitor Adding the Subscriber Endpoint
		$url = 'https://api.createsend.com/api/v3.3/subscribers/'.$listid.'.json';

		$response = wp_remote_post($url, $args);

		$response_code = wp_remote_retrieve_response_code($response);


		if (is_wp_error($response)) {

			return new WP_Error(
				"Invalid request",
				$response->get_error_message(),
				[
					'status' => $response_code,
					'suggestion' => isset($validation_result['suggestion']) ? $validation_result['suggestion'] : ''
				]
			);

		} else if ($response_code != 200 && $response_code != 201) { // 201 Created

			$response_body = json_decode(wp_remote_retrieve_body($response));

			// if the subscriber is already in the unsubscribed list
			if ($response_body->Code == 206) {

				// allow to resubscribe
				$data['Resubscribe'] = true;
				$args['body'] = json_encode($data);

				$resubscribe_response = wp_remote_post($url, $args);

				$response_code = wp_remote_retrieve_response_code($resubscribe_response);

				if (is_wp_error($resubscribe_response)) {

					return new WP_Error(
						"Invalid request",
						$resubscribe_response->get_error_message(),
						[
							'status' => $response_code,
							'suggestion' => isset($validation_result['suggestion']) ? $validation_result['suggestion'] : ''
						]
					);
		
				} else {
					$response_code = wp_remote_retrieve_response_code($resubscribe_response);
					// get the body and pass it along if there is an error
					$response_body = json_decode(wp_remote_retrieve_body($response));

					if ($response_code == 200 || $response_code == 201) {
						$resubscribed = true;
					}
				}
			}

			
			if (!$resubscribed) {
				
				$message = $response_body->Message;

				// If the user was in some lists and wasn't unsubscribed just show the default message
				if ( ($response_body->Code == 205  || // exists deleted list
					   $response_body->Code == 207 || // is bounced
					   $response_body->Code == 208    // is unconfirmed
					)) {
						$message = 'Error! Please try again or contact <a href="mailto:squad@thedailyupside.com">squad@thedailyupside.com</a>';
						$response_code = $response_body->Code;
				}

				return new WP_Error(
					"Invalid request",
					$message,
					[
						'status' => $response_code,
						'suggestion' => isset($validation_result['suggestion']) ? $validation_result['suggestion'] : ''
					]
				);
			}

		}

		do_action('tdu_signup_completed', $email);

		// If everything is successful
		$response = [
				'message' => '<span class="ga-thank-you">Thank you for subscribing.</span>',
				'suggestion' => isset($validation_result['suggestion']) ? $validation_result['suggestion'] : ''
		];

		if (!empty($redirect_url)) {
			$response['url'] = $redirect_url;
		}

		return $response;

}

function tdu_register_signup_endpoint()
{
	register_rest_route( 'ajax/v1', '/signup', [
    'methods' 						=> 'POST',
    'callback'						=> 'tdu_subscribe_form_submit'
  ]);
}

add_action( 'rest_api_init', 'tdu_register_signup_endpoint');
