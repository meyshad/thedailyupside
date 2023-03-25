<?php

function tdu_set_hashed_email_cookie($email) {

    if (isset($email)) {
         setcookie("hashed_email", sha1($email), 0, "/");
    }

}

add_action('tdu_signup_completed', 'tdu_set_hashed_email_cookie' , 10 , 1);
