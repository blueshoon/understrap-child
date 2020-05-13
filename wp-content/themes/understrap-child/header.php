<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- ******************* The Navbar Area ******************* -->
    <header role="banner" id="banner" class="fixed-top">

		<a class="skip-link sr-only sr-only-focusable btn btn-sm btn-primary" href="#main"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav class="navbar navbar-expand-md navbar-dark bg-primary" aria-label="Primary Site">
			<!-- Your site title as branding in the menu -->
			<?php if ( ! has_custom_logo() ) { ?>

				<?php if ( is_front_page() && is_home() ) : ?>

					<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

				<?php else : ?>

					<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

				<?php endif; ?>

			<?php } else {
				the_custom_logo();
			} ?><!-- end custom logo -->

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- The WordPress Menu goes here -->
            <div class="collapse navbar-collapse" id="primaryNav">
                <?php wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'menu_class'      => 'navbar-nav ml-auto',
                        'fallback_cb'     => '',
                        'menu_id'         => '',
                        'depth'           => 2,
                        'walker'          => new Understrap_WP_Bootstrap_Navwalker()
                    )
                ); ?>
            </div>
		</nav>

    </header><!-- #banner -->