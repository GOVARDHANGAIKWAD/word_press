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

	<!-- Top Orange Notification / Call Bar -->
	<div class="ct-top-bar">
		<div class="ct-container ct-top-bar-inner">
			<div class="ct-top-bar-left">
				<span class="ct-top-call-label"><?php esc_html_e( 'CALL US NOW!', 'ct-custom' ); ?></span>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', ct_get_theme_option( 'top_phone', '385.154.11.28.35' ) ) ); ?>" class="ct-top-call-number">
					<?php echo esc_html( ct_get_theme_option( 'top_phone', '385.154.11.28.35' ) ); ?>
				</a>
			</div>
			<div class="ct-top-bar-right">
				<a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" class="ct-top-link ct-top-dashboard-pill" style="background:rgba(255,255,255,0.22); padding:3px 9px; border-radius:3px; font-weight:700; color:#fff;">
					<?php esc_html_e( 'FRONTEND DASHBOARD', 'ct-custom' ); ?>
				</a>
				<span class="ct-top-sep"></span>
				<a href="<?php echo esc_url( wp_login_url() ); ?>" class="ct-top-link"><?php esc_html_e( 'LOGIN', 'ct-custom' ); ?></a>
				<span class="ct-top-sep"></span>
				<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="ct-top-link"><?php esc_html_e( 'SIGNUP', 'ct-custom' ); ?></a>
			</div>
		</div>
	</div>

	<!-- Main Header Bar -->
	<header id="masthead" class="site-header">
		<div class="ct-container site-header-inner">
			<div class="site-branding">
				<?php
				$custom_logo_url = ct_get_theme_option( 'logo_url' );
				if ( ! empty( $custom_logo_url ) ) :
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
						<img src="<?php echo esc_url( $custom_logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo">
					</a>
					<?php
				elseif ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ct-text-logo" rel="home">
						<span class="ct-logo-your">YOUR</span><span class="ct-logo-orange">LOGO</span>
					</a>
					<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'ct-custom' ); ?>">
					<span class="hamburger-bar"></span>
					<span class="hamburger-bar"></span>
					<span class="hamburger-bar"></span>
				</button>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
					'container'      => 'div',
					'container_class'=> 'menu-primary-container',
					'fallback_cb'    => 'ct_custom_default_menu',
				) );
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .ct-container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
