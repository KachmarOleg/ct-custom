<?php
/*
Template Name: Home page
*/
get_header();
?>

<div class="the-content">
    <div class="container">
        <!-- Usually, for breadcrumbs I use the yoast_breadcrumb() function from the Yoast SEO plugin. However, in this case the page logic is a bit unusual. I’m designing a homepage that looks like a “Contact Us” page, while still having “Home” as the root in the breadcrumbs. So I decided just to create styles for it. -->
        <nav class="breadcrumbs" aria-label="Breadcrumbs">
            <a href="http://localhost:10064/home/">Home</a>
            <span>/</span>
            <a href="http://localhost:10064/?page_id=31">Who we are</a>
            <span>/</span>
            <strong>Contact us</strong>
        </nav>

        <?php the_content(); ?>
    </div>
</div>




<?php
$phone   = ct_custom_get_option( 'phone' );
$fax     = ct_custom_get_option( 'fax' );
$address = ct_custom_get_option( 'address' );
?>

<div class="site-contact-info">
    <?php if ( $phone ) : ?>
        <p class="contact-phone">
            <strong><?php esc_html_e( 'Phone:', 'ct-custom' ); ?></strong>
            <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">
                <?php echo esc_html( $phone ); ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if ( $fax ) : ?>
        <p class="contact-fax">
            <strong><?php esc_html_e( 'Fax:', 'ct-custom' ); ?></strong>
            <?php echo esc_html( $fax ); ?>
        </p>
    <?php endif; ?>

    <?php if ( $address ) : ?>
        <address class="contact-address">
            <?php
            echo nl2br( esc_html( $address ) );
            ?>
        </address>
    <?php endif; ?>
</div>

<?php
$socials = [
    'facebook'  => [ 'label' => 'Facebook', 'icon' => 'dashicons-facebook' ],
    'twitter'   => [ 'label' => 'X (Twitter)', 'icon' => 'dashicons-twitter' ],
    'linkedin'  => [ 'label' => 'LinkedIn', 'icon' => 'dashicons-linkedin' ],
    'pinterest' => [ 'label' => 'Pinterest', 'icon' => 'dashicons-pinterest' ],
];
?>

<nav class="social-links" aria-label="<?php esc_attr_e( 'Social Media', 'ct-custom' ); ?>">
    <?php foreach ( $socials as $key => $social ) :
        $url = ct_custom_get_option( $key );
        if ( ! $url ) continue;
    ?>
        <a href="<?php echo esc_url( $url ); ?>"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="<?php echo esc_attr( $social['label'] ); ?>">
            <span class="dashicons <?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></span>
            <span class="screen-reader-text"><?php echo esc_html( $social['label'] ); ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<?php


get_footer(); ?>