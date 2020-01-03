<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<footer class="site-footer" id="colophon">

    <div class="container">

        <?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

        <div class="site-info">

            <?php understrap_site_info(); ?>

        </div><!-- .site-info -->

    </div>

</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>

</html>