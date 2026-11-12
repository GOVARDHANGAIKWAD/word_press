<?php
/**
 * Template part for displaying the Skills Test PSD design layout.
 *
 * @package CT_Custom
 */

$options = get_option( 'ct_theme_settings', array() );
$custom_logo_url = isset( $options['logo_url'] ) ? $options['logo_url'] : '';
$top_phone       = isset( $options['top_phone'] ) ? $options['top_phone'] : '385.154.11.28.35';
$phone           = isset( $options['phone_number'] ) ? $options['phone_number'] : '385.154.11.28.38';
$fax             = isset( $options['fax_number'] ) ? $options['fax_number'] : '385.154.35.66.78';
$address         = isset( $options['address_info'] ) ? $options['address_info'] : "Coalition Skills Test\n\n535 La Plata Street\n4200 Argentina";
$fb              = isset( $options['social_facebook'] ) ? $options['social_facebook'] : 'https://facebook.com';
$tw              = isset( $options['social_twitter'] ) ? $options['social_twitter'] : 'https://twitter.com';
$li              = isset( $options['social_linkedin'] ) ? $options['social_linkedin'] : 'https://linkedin.com';
$pin             = isset( $options['social_pinterest'] ) ? $options['social_pinterest'] : 'https://pinterest.com';
$ins             = isset( $options['social_instagram'] ) ? $options['social_instagram'] : 'https://instagram.com';

$front_id        = get_option( 'page_on_front' );
$homepage_post   = $front_id ? get_post( $front_id ) : null;
$intro_content   = $homepage_post && ! empty( $homepage_post->post_content ) ? $homepage_post->post_content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam posuere ipsum nec velit mattis elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas eu placerat metus, eget placerat libero.';
?>
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>">

<div class="psd-wrapper" style="font-family:'Ubuntu', sans-serif;">
	<!-- Top Orange Bar -->
	<div class="ct-top-bar">
		<div class="ct-container ct-top-bar-inner">
			<div class="ct-top-bar-left">
				<span class="ct-top-call-label"><?php esc_html_e( 'CALL US NOW!', 'ct-custom' ); ?></span>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $top_phone ) ); ?>" class="ct-top-call-number">
					<?php echo esc_html( $top_phone ); ?>
				</a>
			</div>
			<div class="ct-top-bar-right">
				<span class="ct-top-link"><?php esc_html_e( 'LOGIN', 'ct-custom' ); ?></span>
				<span class="ct-top-sep"></span>
				<span class="ct-top-link"><?php esc_html_e( 'SIGNUP', 'ct-custom' ); ?></span>
			</div>
		</div>
	</div>

	<!-- Main Header -->
	<header class="site-header">
		<div class="ct-container site-header-inner">
			<div class="site-branding">
				<?php if ( ! empty( $custom_logo_url ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
						<img src="<?php echo esc_url( $custom_logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo">
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ct-text-logo" rel="home">
						<span class="ct-logo-your">YOUR</span><span class="ct-logo-orange">LOGO</span>
					</a>
				<?php endif; ?>
			</div>

			<nav class="main-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'psd-primary-menu',
					'menu_class'     => 'nav-menu',
					'container'      => 'div',
					'container_class'=> 'menu-primary-container',
					'fallback_cb'    => 'ct_custom_default_menu',
				) );
				?>
			</nav>
		</div>
	</header>

	<!-- Content Section -->
	<main class="ct-homepage-main">
		<div class="ct-container">
			<section class="ct-intro-section">
				<nav class="ct-breadcrumbs">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ct-custom' ); ?></a>
					<span class="ct-bc-sep">/</span>
					<span><?php esc_html_e( 'Who we are', 'ct-custom' ); ?></span>
					<span class="ct-bc-sep">/</span>
					<span class="ct-bc-current"><?php esc_html_e( 'Contact', 'ct-custom' ); ?></span>
				</nav>

				<h1 class="ct-page-title"><?php esc_html_e( 'Contact', 'ct-custom' ); ?></h1>

				<div class="ct-page-description">
					<p><?php echo esc_html( $intro_content ); ?></p>
				</div>
			</section>

			<section class="ct-content-columns">
				<div class="ct-cols-wrap">
					<!-- Left: CONTACT US -->
					<div class="ct-col ct-col-contact">
						<div class="ct-section-header">
							<h2 class="ct-section-title"><?php esc_html_e( 'CONTACT US', 'ct-custom' ); ?></h2>
							<div class="ct-title-bar"></div>
						</div>

						<div class="ct-form-container">
							<?php
							$cf7_shortcode = isset( $options['cf7_shortcode'] ) ? $options['cf7_shortcode'] : '[contact-form-7 id="4" title="Contact form 1"]';
							$rendered = false;
							if ( ! empty( $cf7_shortcode ) && shortcode_exists( 'contact-form-7' ) ) {
								$out = do_shortcode( $cf7_shortcode );
								if ( ! empty( $out ) && strpos( $out, '[contact-form-7' ) === false ) {
									echo $out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									$rendered = true;
								}
							}
							if ( ! $rendered ) :
								?>
								<form action="#" method="post" class="ct-native-form">
									<div class="ct-form-row ct-form-full">
										<input type="text" class="ct-input" placeholder="Name *" required>
									</div>
									<div class="ct-form-row ct-form-cols">
										<div class="ct-form-col">
											<input type="tel" class="ct-input" placeholder="Phone *" required>
										</div>
										<div class="ct-form-col">
											<input type="email" class="ct-input" placeholder="Email *" required>
										</div>
									</div>
									<div class="ct-form-row ct-form-full">
										<textarea class="ct-textarea" rows="4" placeholder="Message *" required></textarea>
									</div>
									<div class="ct-form-row ct-form-submit-row">
										<button type="submit" class="ct-submit-btn"><?php esc_html_e( 'SUBMIT', 'ct-custom' ); ?></button>
									</div>
								</form>
							<?php endif; ?>
						</div>
					</div>

					<!-- Right: REACH US -->
					<div class="ct-col ct-col-reach">
						<div class="ct-section-header">
							<h2 class="ct-section-title"><?php esc_html_e( 'REACH US', 'ct-custom' ); ?></h2>
							<div class="ct-title-bar"></div>
						</div>

						<div class="ct-reach-content">
							<div class="ct-reach-address">
								<?php echo nl2br( esc_html( $address ) ); ?>
							</div>

							<div class="ct-reach-numbers">
								<p class="ct-reach-item">
									<strong><?php esc_html_e( 'Phone:', 'ct-custom' ); ?></strong>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</p>
								<p class="ct-reach-item">
									<strong><?php esc_html_e( 'Fax:', 'ct-custom' ); ?></strong>
									<span><?php echo esc_html( $fax ); ?></span>
								</p>
							</div>

							<div class="ct-reach-social">
								<ul class="ct-social-icons">
									<?php if ( ! empty( $fb ) ) : ?>
										<li><a href="<?php echo esc_url( $fb ); ?>" target="_blank" class="ct-social-link ct-fb"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a></li>
									<?php endif; ?>
									<?php if ( ! empty( $tw ) ) : ?>
										<li><a href="<?php echo esc_url( $tw ); ?>" target="_blank" class="ct-social-link ct-tw"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a></li>
									<?php endif; ?>
									<?php if ( ! empty( $li ) ) : ?>
										<li><a href="<?php echo esc_url( $li ); ?>" target="_blank" class="ct-social-link ct-li"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.53 1.53 0 1 0 0-3.06 1.53 1.53 0 0 0 0 3.06m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg></a></li>
									<?php endif; ?>
									<?php if ( ! empty( $ins ) ) : ?>
										<li><a href="<?php echo esc_url( $ins ); ?>" target="_blank" class="ct-social-link ct-ins"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</main>

	<!-- Footer -->
	<footer class="site-footer">
		<div class="ct-container site-footer-inner">
			<div class="site-info">
				<p class="ct-footer-copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'ct-custom' ); ?></p>
			</div>
		</div>
	</footer>
</div>

