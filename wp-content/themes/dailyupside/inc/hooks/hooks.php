<?php

/**
 * #1202577986767434 - reCAPTCHA For new subscription form
 */
require get_template_directory() . '/inc/hooks/google-recaptcha.php';

// /**
//  * #1202395263674625 - Kickbox - Email verifier
//  */
// require get_template_directory() . '/inc/hooks/kickbox-verfiy-email.php';

/**
 * #1203153680630696 - Transition from Kickbox to BriteVerify
 */
require get_template_directory() . '/inc/hooks/brite-verify-email.php';

/**
 * #1202929444954564 - Impact Radius Pixel for the new website
 */
require get_template_directory() . '/inc/hooks/set-hashed-email-cookie.php';

/**
 * #1203051164587351 - Ability to add longer excerpt on the homepage
 */
require get_template_directory() . '/inc/hooks/set-hompage-excerpt.php';
