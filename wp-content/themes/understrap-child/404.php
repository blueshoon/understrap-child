<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<main id="main" tabindex="-1">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-6 mx-md-auto text-center">
				<h1 class="h2 text-uppercase text-sans-serif text-danger">
                    <?php esc_html_e( 'Sorry, page not found.', 'understrap' ); ?>
				</h1>
				<p>
                    Please check your link, or return to our <a href="<?php echo get_option('siteurl'); ?>" class="text-underline">homepage</a>.
                </p>
			</div>
		</div>
	</div>
</main><!-- #main -->

<?php get_footer(); ?>