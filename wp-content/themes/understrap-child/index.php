<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$page_for_posts = get_option( 'page_for_posts' );
?>
<main id="main" tabindex="-1">
	<div class="container">
        <ul class="row list-unstyled list-posts">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>

                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <li class="col-lg-4 col-md-6">
						<?php
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'loop-templates/content', get_post_format() );
                        ?>
                    </li>

                <?php endwhile; ?>
                    

		    <?php else : ?>

				<?php get_template_part( 'loop-templates/content', 'none' ); ?>

            <?php endif; ?>

        </ul>

		<!-- The pagination component -->
        <?php understrap_pagination(); ?>
    </div>
</main><!-- #main -->

<?php get_footer(); ?>