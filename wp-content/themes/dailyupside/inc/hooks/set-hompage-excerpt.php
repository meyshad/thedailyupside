<?php

/**
 * #1203051164587351 - Ability to add longer excerpt on the homepage
 */
function tdu_set_homepage_excerpt($default_excerpt) {
  $excerpt = $default_excerpt;
  if (is_front_page()) {
    $excerpt = get_field('home_excerpt');
    $excerpt = empty($excerpt) ? $default_excerpt : $excerpt;
  }

  return $excerpt;
}

add_filter('the_excerpt', 'tdu_set_homepage_excerpt');
