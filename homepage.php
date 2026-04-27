<?php
/*
Template Name: Home page
*/
get_header(); ?>

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


<?php get_footer(); ?>