<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CT_Custom
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ct-custom' ); ?></a>

    <div class="top-bar">
        <div class="container flex-between">
            <div class="flex-start gap10">
                <div class="dark-orange-text">
                    <p>
                        <?php esc_html_e( 'CALL US NOW!', 'ct-custom' ); ?>
                    </p>
                </div>

                <?php
                $phone = ct_custom_get_option( 'phone' );
                if ( $phone ) : ?>
                    <p class="contact-phone">
                        <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="white-text">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <div class="flex-start gap10">
                <a href="#" class="dark-orange-text">
                    <?php esc_html_e( 'Login', 'ct-custom' ); ?>
                </a>
                <a href="#" class="white-text">
                    <?php esc_html_e( 'Sign up', 'ct-custom' ); ?>
                </a>
            </div>
        </div>
    </div>
	<header id="masthead" class="site-header">
        <div class="header-container container flex-between">
            <div class="site-branding">
                <?php if ( ct_custom_get_option( 'logo_id' ) ) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php ct_custom_the_logo( 'full', [ 'class' => 'site-logo' ] ); ?>
                    </a>
                <?php else : ?>
                    <p class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation flex-center">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ct-custom' ); ?></button>
                <?php
                wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'container'      => false,
                        'items_wrap'     => '<ul class="flex-start">%3$s</ul>',
                        'menu_id'        => 'primary-menu',
                ) );
                ?>
            </nav><!-- #site-navigation -->
        </div>
	</header><!-- #masthead -->

	<main id="content" class="site-content">
