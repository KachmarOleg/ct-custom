<?php
/*
Template Name: Home page
*/
get_header();
?>



<h1>Contact</h1>
<h2>Contact</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam posuere ipsum nec velit mattis elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas eu placerat metus, eget placerat libero. </p>

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