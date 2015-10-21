<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Pique
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pique' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php // Let's show a header image if we aren't on the front page and a header has been set
		if ( ! pique_is_frontpage() AND get_header_image() ) : ?>
			<a class="pique-header" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

			<?php // If the post uses a Featured Image, let's show that
			if ( is_singular() && has_post_thumbnail() ) :
				the_post_thumbnail( 'pique-header', array( 'id' => 'pique-header-image' ) );
			else : // Otherwise, let's just show the header image
			?>
				<img id="pique-header-image" src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php endif; // End featured image check. ?>
			</a>
		<?php endif; // End header image check. ?>

		<div class="site-branding">
			<?php pique_the_site_logo(); ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		</div><!-- .site-branding -->

		<?php if ( pique_is_frontpage() AND get_theme_mod( 'pique_menu' ) ) : ?>

			<?php
			// Get each of our panels and output a link to the section on the page
			foreach ( range(1, 8) as $panel ) :
				if ( get_theme_mod( 'pique_panel' . $panel ) ) :
					$post = get_post( get_theme_mod( 'pique_panel' . $panel ) );
					setup_postdata( $post );
					$panel_links[] = '<li><a href="#post-' . get_the_ID() . '">' . get_the_title() . '</a></li>';
					wp_reset_postdata();
				endif;
			endforeach;

			// Output our menu only if we actually have menu items
			if ( 0 !== count( $panel_links ) ) : ?>
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<span class="pique-split-nav">
						<?php
						// Split the menu in half at the half-way mark
						$halfies = intval( ceil( count( $panel_links ) / 2 ) );
						foreach ( $panel_links as $key => $link ) :
							if ( $halfies === $key ) :
								echo '</span><span class="pique-split-nav">';
							endif;
							// Output menu link
							echo $link;

							// If we only have one single panel, output an empty span so the styling is consistent
							// and the Customizer experience feels more natural when they add a second panel
							if ( 1 === count( $panel_links ) ) :
								echo '</span><span class="pique-split-nav">';
							endif;

						endforeach;
						?>
					</span>
				</nav><!-- #site-navigation -->
			<?php endif; ?>

		<?php elseif ( has_nav_menu( 'primary' ) ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'menu_id'         => 'primary-menu',
						'fallback_cb'     => 'wp_page_menu',
						'items_wrap'      => '<ul id="%1$s" class="%2$s"><span class="pique-split-nav">%3$s</span></ul>',
						'walker'          => new Pique_Menu(),
					) );
				?>
			</nav><!-- #site-navigation -->
		<?php endif; ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
