<?php
/**
 * CT Custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CT_Custom
 */

if ( ! function_exists( 'ct_custom_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ct_custom_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CT Custom, use a find and replace
		 * to change 'ct-custom' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ct-custom', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ct-custom' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ct_custom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ct_custom_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ct_custom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ct_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'ct_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ct_custom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ct-custom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ct-custom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ct_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ct_custom_scripts() {
	wp_enqueue_style( 'ct-custom-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ct-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ct-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_custom_scripts' );

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

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}





/**
 * Theme Settings Page
 */

// Register the admin menu page
function ct_custom_register_settings_page() {
    add_menu_page(
        __( 'Theme Settings', 'ct-custom' ),
        __( 'Theme Settings', 'ct-custom' ),
        'manage_options',
        'ct-custom-settings',
        'ct_custom_render_settings_page',
        'dashicons-admin-generic',
        61
    );
}
add_action( 'admin_menu', 'ct_custom_register_settings_page' );


// Register settings (Settings API)
function ct_custom_register_settings() {
    register_setting(
        'ct_custom_settings_group',
        'ct_custom_options',
        'ct_custom_sanitize_options'
    );
}
add_action( 'admin_init', 'ct_custom_register_settings' );


// Sanitize all input before saving
function ct_custom_sanitize_options( $input ) {
    $sanitized = [];

    $sanitized['logo_id'] = isset( $input['logo_id'] )
        ? absint( $input['logo_id'] )
        : 0;

    $sanitized['phone'] = isset( $input['phone'] )
        ? sanitize_text_field( $input['phone'] )
        : '';

    $sanitized['fax'] = isset( $input['fax'] )
        ? sanitize_text_field( $input['fax'] )
        : '';

    $sanitized['address'] = isset( $input['address'] )
        ? sanitize_textarea_field( $input['address'] )
        : '';

    $socials = [ 'facebook', 'instagram', 'twitter', 'linkedin', 'youtube' ];
    foreach ( $socials as $social ) {
        $sanitized[ $social ] = isset( $input[ $social ] )
            ? esc_url_raw( $input[ $social ] )
            : '';
    }

    return $sanitized;
}


// Enqueue WordPress media uploader on settings page only
function ct_custom_enqueue_admin_scripts( $hook ) {
    if ( $hook !== 'toplevel_page_ct-custom-settings' ) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script( 'jquery' );

    wp_register_script( 'ct-custom-admin', false, [ 'jquery', 'media-upload' ], null, true );
    wp_enqueue_script( 'ct-custom-admin' );

    wp_add_inline_script( 'ct-custom-admin', "
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('#ct-custom-upload-logo').on('click', function(e) {
                e.preventDefault();

                if ( mediaUploader ) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media({
                    title: 'Select Logo Image',
                    button: { text: 'Use This Image' },
                    multiple: false,
                    library: { type: 'image' }
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#ct_custom_logo_id').val(attachment.id);
                    $('#ct-custom-logo-preview').attr('src', attachment.url).show();
                    $('#ct-custom-remove-logo').show();
                });

                mediaUploader.open();
            });

            $('#ct-custom-remove-logo').on('click', function(e) {
                e.preventDefault();
                $('#ct_custom_logo_id').val('');
                $('#ct-custom-logo-preview').hide().attr('src', '');
                $(this).hide();
            });
        });
    " );
}
add_action( 'admin_enqueue_scripts', 'ct_custom_enqueue_admin_scripts' );


// Render the settings page HTML
function ct_custom_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $options  = get_option( 'ct_custom_options', [] );
    $logo_id  = ! empty( $options['logo_id'] ) ? $options['logo_id'] : 0;
    $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
    ?>

    <div class="wrap">
        <h1><?php esc_html_e( 'Theme Settings', 'ct-custom' ); ?></h1>

        <?php settings_errors( 'ct_custom_options' ); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields( 'ct_custom_settings_group' );
            ?>

            <h2><?php esc_html_e( 'Logo', 'ct-custom' ); ?></h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e( 'Site Logo', 'ct-custom' ); ?></label>
                    </th>
                    <td>
                        <input type="hidden"
                               id="ct_custom_logo_id"
                               name="ct_custom_options[logo_id]"
                               value="<?php echo esc_attr( $logo_id ); ?>">

                        <img id="ct-custom-logo-preview"
                             src="<?php echo esc_url( $logo_url ); ?>"
                             style="max-width:200px; display:<?php echo $logo_url ? 'block' : 'none'; ?>; margin-bottom:8px;">

                        <button type="button" id="ct-custom-upload-logo" class="button">
                            <?php esc_html_e( 'Upload / Change Logo', 'ct-custom' ); ?>
                        </button>

                        <button type="button"
                                id="ct-custom-remove-logo"
                                class="button"
                                style="display:<?php echo $logo_url ? 'inline-block' : 'none'; ?>; margin-left:8px; color:#b32d2e;">
                            <?php esc_html_e( 'Remove Logo', 'ct-custom' ); ?>
                        </button>
                    </td>
                </tr>
            </table>

            <h2><?php esc_html_e( 'Contact Information', 'ct-custom' ); ?></h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">
                        <label for="ct_custom_phone">
                            <?php esc_html_e( 'Phone Number', 'ct-custom' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="tel"
                               id="ct_custom_phone"
                               name="ct_custom_options[phone]"
                               value="<?php echo esc_attr( $options['phone'] ?? '' ); ?>"
                               class="regular-text"
                               placeholder="+48 123 456 789">
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="ct_custom_fax">
                            <?php esc_html_e( 'Fax Number', 'ct-custom' ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="tel"
                               id="ct_custom_fax"
                               name="ct_custom_options[fax]"
                               value="<?php echo esc_attr( $options['fax'] ?? '' ); ?>"
                               class="regular-text"
                               placeholder="+48 123 456 789">
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="ct_custom_address">
                            <?php esc_html_e( 'Address', 'ct-custom' ); ?>
                        </label>
                    </th>
                    <td>
                        <textarea id="ct_custom_address"
                                  name="ct_custom_options[address]"
                                  rows="4"
                                  class="large-text"
                                  placeholder="вул. Хрещатик 1&#10;Київ, 01001&#10;Україна"><?php echo esc_textarea( $options['address'] ?? '' ); ?></textarea>
                        <p class="description">
                            <?php esc_html_e( 'You can use line breaks for multi-line addresses.', 'ct-custom' ); ?>
                        </p>
                    </td>
                </tr>

            </table>

            <h2><?php esc_html_e( 'Social Media Links', 'ct-custom' ); ?></h2>
            <table class="form-table" role="presentation">

                <?php
                $social_fields = [
                    'facebook'  => [ 'label' => 'Facebook',  'placeholder' => 'https://facebook.com/yourpage' ],
                    'instagram' => [ 'label' => 'Instagram',  'placeholder' => 'https://instagram.com/yourhandle' ],
                    'twitter'   => [ 'label' => 'X (Twitter)', 'placeholder' => 'https://x.com/yourhandle' ],
                    'linkedin'  => [ 'label' => 'LinkedIn',   'placeholder' => 'https://linkedin.com/company/yourcompany' ],
                    'youtube'   => [ 'label' => 'YouTube',    'placeholder' => 'https://youtube.com/@yourchannel' ],
                ];

                foreach ( $social_fields as $key => $field ) : ?>
                    <tr>
                        <th scope="row">
                            <label for="ct_custom_<?php echo esc_attr( $key ); ?>">
                                <?php echo esc_html( $field['label'] ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="url"
                                   id="ct_custom_<?php echo esc_attr( $key ); ?>"
                                   name="ct_custom_options[<?php echo esc_attr( $key ); ?>]"
                                   value="<?php echo esc_url( $options[ $key ] ?? '' ); ?>"
                                   class="regular-text"
                                   placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <?php submit_button( __( 'Save Settings', 'ct-custom' ) ); ?>
        </form>
    </div>
    <?php
}


// Get option value by key
function ct_custom_get_option( $key, $default = '' ) {
    $options = get_option( 'ct_custom_options', [] );
    return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

// Get company logo
function ct_custom_the_logo( $size = 'full', $attrs = [] ) {
    $logo_id = ct_custom_get_option( 'logo_id' );
    if ( ! $logo_id ) {
        return;
    }
    $default_attrs = [ 'class' => 'site-logo', 'alt' => get_bloginfo( 'name' ) ];
    echo wp_get_attachment_image( $logo_id, $size, false, array_merge( $default_attrs, $attrs ) );
}