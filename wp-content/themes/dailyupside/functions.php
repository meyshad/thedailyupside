<?php
/**
 * Starter Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Daily_Upside
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'daily_upside_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function daily_upside_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Starter Theme, use a find and replace
		 * to change 'daily-upside' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'daily-upside', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'blog-post', 788, 526, true ); // Hard Crop Mode
		add_image_size( 'side-post', 300, 200, true ); // Hard Crop Mode

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-header' 		=> esc_html__( 'Menu Header', 'daily-upside' ),
				'menu-footer' 		=> esc_html__( 'Menu Footer', 'daily-upside' ),
				'menu-newsletters' 	=> esc_html__( 'Menu Newsletters', 'daily-upside' ),
				'menu-topics' 		=> esc_html__( 'Menu Topics', 'daily-upside' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'daily_upside_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'daily_upside_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function daily_upside_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'daily_upside_content_width', 640 );
}
add_action( 'after_setup_theme', 'daily_upside_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function daily_upside_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'daily-upside' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'daily-upside' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'daily_upside_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function daily_upside_scripts() {
		wp_enqueue_style('theme-vendor-style', get_template_directory_uri() . '/assets/styles/vendor.min.css', array(), rand(111, 9999), 'all');
		wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/styles/style.min.css', array(), rand(111, 9999), 'all');
		wp_enqueue_script('theme-vendor-js', get_template_directory_uri() . '/assets/scripts/vendor.min.js', array('jquery'), rand(111, 9999), true);
		wp_enqueue_script('theme-js', get_template_directory_uri() . '/assets/scripts/main.min.js', array('jquery'), rand(111, 9999), true);
}
add_action( 'wp_enqueue_scripts', 'daily_upside_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Global hooks
 */
require get_template_directory() . '/inc/hooks/hooks.php';

/**
 * Global shortcodes
 */
require get_template_directory() . '/inc/shortcodes/shortcodes.php';


/**
 * Pagination
 */
function custom_pagination($numpages = '', $pagerange = '', $paged='') {

	if (empty($pagerange)) {
	  $pagerange = 2;
	}

	/**
	 * This first part of our function is a fallback
	 * for custom pagination inside a regular loop that
	 * uses the global $paged and global $wp_query variables.
	 *
	 * It's good because we can now override default pagination
	 * in our theme, and use this function in default quries
	 * and custom queries.
	 */
	if(is_front_page()):
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	 else:
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	 endif;
	if (empty($paged)) {
	  $paged = 1;
	}
	if ($numpages == '') {
	  global $wp_query;
	  $numpages = $wp_query->max_num_pages;
	  if(!$numpages) {
		  $numpages = 1;
	  }
	}

	/**
	 * We construct the pagination arguments to enter into our paginate_links
	 * function.
	 */
	$pagination_args = array(
	  'base'            => get_pagenum_link(1) . '%_%',
	  'format'          => 'page/%#%',
	  'total'           => $numpages,
	  'current'         => $paged,
	  'show_all'        => False,
	  'end_size'        => 1,
	  'mid_size'        => $pagerange,
	  'prev_next'       => True,
	  'prev_text'       => __('<svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.22 6.80091C0.0793075 6.66039 0.000175052 6.46975 0 6.27091V5.89091C0.00230401 5.69249 0.081116 5.50263 0.22 5.36091L5.36 0.230907C5.45388 0.136251 5.58168 0.0830078 5.715 0.0830078C5.84832 0.0830078 5.97612 0.136251 6.07 0.230907L6.78 0.940907C6.87406 1.03307 6.92707 1.15922 6.92707 1.29091C6.92707 1.4226 6.87406 1.54874 6.78 1.64091L2.33 6.08091L6.78 10.5209C6.87466 10.6148 6.9279 10.7426 6.9279 10.8759C6.9279 11.0092 6.87466 11.137 6.78 11.2309L6.07 11.9309C5.97612 12.0256 5.84832 12.0788 5.715 12.0788C5.58168 12.0788 5.45388 12.0256 5.36 11.9309L0.22 6.80091Z" fill="#222222"/></svg> <span>Prev</span>'),
	  'next_text'       => __('<span>Next</span> <svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.78 6.80091C6.92069 6.66039 6.99982 6.46975 7 6.27091V5.89091C6.9977 5.69249 6.91888 5.50263 6.78 5.36091L1.64 0.230907C1.54612 0.136251 1.41832 0.0830078 1.285 0.0830078C1.15168 0.0830078 1.02388 0.136251 0.93 0.230907L0.22 0.940907C0.125936 1.03307 0.0729284 1.15922 0.0729284 1.29091C0.0729284 1.4226 0.125936 1.54874 0.22 1.64091L4.67 6.08091L0.22 10.5209C0.125343 10.6148 0.0721006 10.7426 0.0721006 10.8759C0.0721006 11.0092 0.125343 11.137 0.22 11.2309L0.93 11.9309C1.02388 12.0256 1.15168 12.0788 1.285 12.0788C1.41832 12.0788 1.54612 12.0256 1.64 11.9309L6.78 6.80091Z" fill="#222222"/></svg>'),
	  'type'            => 'array',
	  'add_args'        => 'false',
	  'add_fragment'    => ''
	);

	$paginate_links = paginate_links($pagination_args);

	$prev_link = '<span class="prev page-numbers disable"><svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.22 6.80091C0.0793075 6.66039 0.000175052 6.46975 0 6.27091V5.89091C0.00230401 5.69249 0.081116 5.50263 0.22 5.36091L5.36 0.230907C5.45388 0.136251 5.58168 0.0830078 5.715 0.0830078C5.84832 0.0830078 5.97612 0.136251 6.07 0.230907L6.78 0.940907C6.87406 1.03307 6.92707 1.15922 6.92707 1.29091C6.92707 1.4226 6.87406 1.54874 6.78 1.64091L2.33 6.08091L6.78 10.5209C6.87466 10.6148 6.9279 10.7426 6.9279 10.8759C6.9279 11.0092 6.87466 11.137 6.78 11.2309L6.07 11.9309C5.97612 12.0256 5.84832 12.0788 5.715 12.0788C5.58168 12.0788 5.45388 12.0256 5.36 11.9309L0.22 6.80091Z" fill="#666666"/></svg> <span>Prev</span></span>';
	$next_link = '<span class="next page-numbers disable"><span>Next</span> <svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.78 6.80091C6.92069 6.66039 6.99982 6.46975 7 6.27091V5.89091C6.9977 5.69249 6.91888 5.50263 6.78 5.36091L1.64 0.230907C1.54612 0.136251 1.41832 0.0830078 1.285 0.0830078C1.15168 0.0830078 1.02388 0.136251 0.93 0.230907L0.22 0.940907C0.125936 1.03307 0.0729284 1.15922 0.0729284 1.29091C0.0729284 1.4226 0.125936 1.54874 0.22 1.64091L4.67 6.08091L0.22 10.5209C0.125343 10.6148 0.0721006 10.7426 0.0721006 10.8759C0.0721006 11.0092 0.125343 11.137 0.22 11.2309L0.93 11.9309C1.02388 12.0256 1.15168 12.0788 1.285 12.0788C1.41832 12.0788 1.54612 12.0256 1.64 11.9309L6.78 6.80091Z" fill="#666666"/></svg></span>';

	if ($paginate_links) {
		array_unshift($paginate_links, $prev_link);
		$paginate_links[] = empty($paginate_links) ? false : $next_link;

		if ($paginate_links) {
			echo "<div class='c-pagination'>";
				echo "<div class='c-pagination__list'>";
					echo implode($paginate_links);
				echo "</div>";
			echo "</div>";
		}
	}	
}

/**
 * default featured image
 */
function default_post_thumbnail_html( $html ) {
    if ( $html == '' ) {
        return sprintf("<img src=\"%s\" alt=\"%s\" />",
            esc_url( get_template_directory_uri() . '/assets/images/default-image.jpg' ),
            esc_html( get_the_title() )
		);

    }
    return $html;
}
add_filter( 'post_thumbnail_html', 'default_post_thumbnail_html', 10, 1 );
add_filter( 'has_post_thumbnail', '__return_true' );


add_action('gform_register_init_scripts', 'register_custom_init_script', 10, 2);
function register_custom_init_script($form, $field_values){
    $script =  "NiceSelect.bind(document.querySelector('.gfield_select'), {searchable: false});";
    GFFormDisplay::add_init_script($form['id'], 'my_custom_script', GFFormDisplay::ON_PAGE_RENDER, $script);
}