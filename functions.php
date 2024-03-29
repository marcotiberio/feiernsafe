<?php
/**
 * Awareness Akademie functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Awareness_Akademie
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'awareness_akademie_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function awareness_akademie_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Awareness Akademie, use a find and replace
		 * to change 'awareness-akademie' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'awareness-akademie', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'awareness-akademie' ),
				'menu-2' => esc_html__( 'Footer', 'awareness-akademie' ),
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
				'awareness_akademie_custom_background_args',
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
add_action( 'after_setup_theme', 'awareness_akademie_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function awareness_akademie_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'awareness_akademie_content_width', 640 );
}
add_action( 'after_setup_theme', 'awareness_akademie_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function awareness_akademie_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'awareness-akademie' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'awareness-akademie' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'awareness_akademie_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function awareness_akademie_scripts() {
	wp_enqueue_style( 'awareness-akademie-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'hamburger-css', get_template_directory_uri() . '/assets/css/hamburger.css', 'all');
	wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper/swiper-bundle.css', 'all');
	wp_enqueue_style( 'swiper-min-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', 'all');
	wp_style_add_data( 'awareness-akademie-style', 'rtl', 'replace' );

	wp_deregister_script( 'jquery' );
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), null, true);
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-migrate-3.3.2.min.js', array(), null, true);

	wp_enqueue_script('swiper', 'https://unpkg.com/swiper/swiper-bundle.js', array(), null, true);
	wp_enqueue_script('swiper-min', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
	wp_enqueue_script('tweenmax', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js', array(), null, true);
	// wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCiPuWhk93qaBfNd28DpJY_ZyGNEgtoiYw', array(), null, true);

	wp_enqueue_script('js-google', '//maps.googleapis.com/maps/api/js?key=AIzaSyCiPuWhk93qaBfNd28DpJY_ZyGNEgtoiYw', null, null);
	wp_enqueue_script('js-maps', get_stylesheet_directory_uri() . '/js/map.js', array('jquery'), null, true); 

	wp_enqueue_script( 'awareness-akademie-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'awareness-akademie-blob', get_template_directory_uri() . '/js/blob.js', array(), _S_VERSION, true );
	// wp_enqueue_script( 'awareness-akademie-ressourcen-filters', get_template_directory_uri() . '/js/ressourcen-filters.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'awareness-akademie-script', get_template_directory_uri() . '/js/script.js', array(), _S_VERSION, true );
	// wp_enqueue_script( 'googlemaps-js', get_template_directory_uri() . '/js/googlemaps.js', array(), _S_VERSION, false );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'awareness_akademie_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// // Registering script
// add_action( 'wp_enqueue_scripts', 'digitalnoir_enqueue_scripts' ); 
// function digitalnoir_enqueue_scripts() {  
// 	wp_enqueue_script('js-google', '//maps.googleapis.com/maps/api/js?key=REPLACE_WITH_YOUR_KEY, null, null);
// 	wp_enqueue_script('js-maps', get_stylesheet_directory_uri() . '/js/map.js', array('jquery'), null, true);     
// }


// // Method 1: Filter.
function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyCiPuWhk93qaBfNd28DpJY_ZyGNEgtoiYw';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
