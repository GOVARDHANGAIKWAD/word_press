<?php
/**
 * Template Name: Frontend Dashboard
 *
 * A modern frontend dashboard interface matching the Frontend Dashboard design.
 *
 * @package CT_Custom
 */

// Handle Frontend Settings Form Submission
$message = '';
$message_type = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['ct_frontend_dashboard_nonce'] ) ) {
	if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ct_frontend_dashboard_nonce'] ) ), 'ct_save_frontend_settings' ) ) {
		if ( current_user_can( 'manage_options' ) ) {
			$existing = get_option( 'ct_theme_settings', array() );

			$existing['logo_url']         = isset( $_POST['logo_url'] ) ? esc_url_raw( trim( wp_unslash( $_POST['logo_url'] ) ) ) : '';
			$existing['top_phone']        = isset( $_POST['top_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['top_phone'] ) ) : '';
			$existing['phone_number']     = isset( $_POST['phone_number'] ) ? sanitize_text_field( wp_unslash( $_POST['phone_number'] ) ) : '';
			$existing['fax_number']       = isset( $_POST['fax_number'] ) ? sanitize_text_field( wp_unslash( $_POST['fax_number'] ) ) : '';
			$existing['address_info']     = isset( $_POST['address_info'] ) ? sanitize_textarea_field( wp_unslash( $_POST['address_info'] ) ) : '';
			$existing['social_facebook']  = isset( $_POST['social_facebook'] ) ? esc_url_raw( trim( wp_unslash( $_POST['social_facebook'] ) ) ) : '';
			$existing['social_twitter']   = isset( $_POST['social_twitter'] ) ? esc_url_raw( trim( wp_unslash( $_POST['social_twitter'] ) ) ) : '';
			$existing['social_linkedin']  = isset( $_POST['social_linkedin'] ) ? esc_url_raw( trim( wp_unslash( $_POST['social_linkedin'] ) ) ) : '';
			$existing['social_pinterest'] = isset( $_POST['social_pinterest'] ) ? esc_url_raw( trim( wp_unslash( $_POST['social_pinterest'] ) ) ) : '';
			$existing['social_instagram'] = isset( $_POST['social_instagram'] ) ? esc_url_raw( trim( wp_unslash( $_POST['social_instagram'] ) ) ) : '';

			update_option( 'ct_theme_settings', $existing );

			// Also update Homepage content if provided
			if ( isset( $_POST['homepage_content'] ) ) {
				$front_id = get_option( 'page_on_front' );
				if ( $front_id ) {
					wp_update_post( array(
						'ID'           => $front_id,
						'post_content' => wp_kses_post( wp_unslash( $_POST['homepage_content'] ) ),
					) );
				}
			}

			$message = __( 'Settings saved successfully from Frontend Dashboard!', 'ct-custom' );
			$message_type = 'success';
		} else {
			$message = __( 'Permission denied. Please log in as an administrator.', 'ct-custom' );
			$message_type = 'error';
		}
	}
}

$theme_settings = get_option( 'ct_theme_settings', array() );
$current_user   = wp_get_current_user();
$is_logged_in   = is_user_logged_in();
$is_admin       = current_user_can( 'manage_options' );

$front_id = get_option( 'page_on_front' );
$homepage_post = $front_id ? get_post( $front_id ) : null;
$homepage_content = $homepage_post ? $homepage_post->post_content : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php esc_html_e( 'Frontend Dashboard', 'ct-custom' ); ?> &mdash; <?php bloginfo( 'name' ); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
	<style>
		:root {
			--fed-sidebar-bg: #1e1e2d;
			--fed-sidebar-hover: #27273a;
			--fed-sidebar-active: #3699ff;
			--fed-bg: #f3f6f9;
			--fed-card-bg: #ffffff;
			--fed-text-main: #3f4254;
			--fed-text-muted: #b5b5c3;
			--fed-primary: #3699ff;
			--fed-success: #1bc5bd;
			--fed-warning: #ffa800;
			--fed-danger: #f64e60;
			--fed-orange: #ff6200;
			--fed-border: #ebedf3;
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }
		body {
			font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
			background-color: var(--fed-bg);
			color: var(--fed-text-main);
			min-height: 100vh;
			display: flex;
		}

		/* Sidebar */
		.fed-sidebar {
			width: 250px;
			background-color: var(--fed-sidebar-bg);
			color: #ffffff;
			display: flex;
			flex-direction: column;
			flex-shrink: 0;
			min-height: 100vh;
			position: sticky;
			top: 0;
			box-shadow: 2px 0 10px rgba(0,0,0,0.05);
			z-index: 100;
		}

		.fed-sidebar-brand {
			padding: 22px 24px;
			display: flex;
			align-items: center;
			gap: 12px;
			border-bottom: 1px solid rgba(255,255,255,0.06);
		}

		.fed-brand-icon {
			width: 36px;
			height: 36px;
			background: linear-gradient(135deg, #3699ff 0%, #6993ff 100%);
			border-radius: 8px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-weight: 700;
			font-size: 18px;
		}

		.fed-brand-title {
			font-size: 16px;
			font-weight: 700;
			color: #ffffff;
			letter-spacing: -0.2px;
		}

		.fed-brand-badge {
			font-size: 10px;
			background: rgba(54, 153, 255, 0.2);
			color: #3699ff;
			padding: 2px 6px;
			border-radius: 4px;
			margin-left: auto;
			font-weight: 600;
		}

		.fed-nav {
			list-style: none;
			padding: 16px 12px;
			flex: 1;
		}

		.fed-nav-item {
			margin-bottom: 4px;
		}

		.fed-nav-link {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 11px 16px;
			color: #a2a3b7;
			text-decoration: none;
			border-radius: 6px;
			font-size: 13.5px;
			font-weight: 500;
			transition: all 0.2s ease;
			cursor: pointer;
		}

		.fed-nav-link:hover {
			background-color: var(--fed-sidebar-hover);
			color: #ffffff;
		}

		.fed-nav-link.active {
			background-color: #3699ff;
			color: #ffffff;
			font-weight: 600;
			box-shadow: 0 4px 12px rgba(54, 153, 255, 0.3);
		}

		.fed-nav-link svg {
			width: 18px;
			height: 18px;
			flex-shrink: 0;
		}

		.fed-sidebar-footer {
			padding: 16px;
			border-top: 1px solid rgba(255,255,255,0.06);
		}

		.fed-btn-back {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			width: 100%;
			padding: 10px;
			background: rgba(255,255,255,0.08);
			color: #ffffff;
			border-radius: 6px;
			text-decoration: none;
			font-size: 12.5px;
			font-weight: 600;
			transition: background 0.2s;
		}

		.fed-btn-back:hover {
			background: rgba(255,255,255,0.15);
			color: #fff;
		}

		/* Main Content */
		.fed-main {
			flex: 1;
			display: flex;
			flex-direction: column;
			min-width: 0;
		}

		/* Top Bar */
		.fed-header {
			height: 68px;
			background-color: #ffffff;
			border-bottom: 1px solid var(--fed-border);
			padding: 0 30px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			position: sticky;
			top: 0;
			z-index: 90;
		}

		.fed-header-title {
			font-size: 18px;
			font-weight: 700;
			color: var(--fed-text-main);
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.fed-header-actions {
			display: flex;
			align-items: center;
			gap: 16px;
		}

		.fed-notify-badge {
			display: flex;
			align-items: center;
			gap: 6px;
			background-color: #e8fff3;
			color: #1bc5bd;
			padding: 6px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
		}

		.fed-notify-dot {
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background-color: #1bc5bd;
			display: inline-block;
		}

		.fed-user-pill {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 4px 12px 4px 4px;
			background: #f3f6f9;
			border-radius: 30px;
		}

		.fed-avatar {
			width: 34px;
			height: 34px;
			border-radius: 50%;
			background: linear-gradient(135deg, #ff6200, #ff8c42);
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: 700;
			font-size: 14px;
		}

		.fed-user-name {
			font-size: 13px;
			font-weight: 600;
			color: var(--fed-text-main);
		}

		/* Container */
		.fed-body {
			padding: 30px;
			flex: 1;
		}

		/* Alerts */
		.fed-alert {
			padding: 14px 18px;
			border-radius: 8px;
			margin-bottom: 24px;
			font-size: 14px;
			font-weight: 500;
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.fed-alert-success {
			background-color: #c9f7f5;
			color: #1bc5bd;
			border: 1px solid #1bc5bd;
		}

		.fed-alert-error {
			background-color: #ffe2e5;
			color: #f64e60;
			border: 1px solid #f64e60;
		}

		/* Stats Grid */
		.fed-stats-row {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 20px;
			margin-bottom: 28px;
		}

		.fed-stat-card {
			background: #ffffff;
			border-radius: 12px;
			padding: 20px;
			border: 1px solid var(--fed-border);
			box-shadow: 0 0 20px 0 rgba(76,87,125,0.02);
			display: flex;
			align-items: center;
			gap: 16px;
		}

		.fed-stat-icon {
			width: 48px;
			height: 48px;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.fed-stat-icon.primary { background: rgba(54, 153, 255, 0.12); color: #3699ff; }
		.fed-stat-icon.success { background: rgba(27, 197, 189, 0.12); color: #1bc5bd; }
		.fed-stat-icon.orange  { background: rgba(255, 98, 0, 0.12); color: #ff6200; }
		.fed-stat-icon.warning { background: rgba(255, 168, 0, 0.12); color: #ffa800; }

		.fed-stat-value {
			font-size: 22px;
			font-weight: 700;
			color: var(--fed-text-main);
			line-height: 1.2;
		}

		.fed-stat-label {
			font-size: 12px;
			color: var(--fed-text-muted);
			font-weight: 500;
			margin-top: 2px;
		}

		/* Two Column Workspace */
		.fed-grid {
			display: grid;
			grid-template-columns: 2fr 1fr;
			gap: 24px;
		}

		/* Card */
		.fed-card {
			background-color: #ffffff;
			border-radius: 12px;
			border: 1px solid var(--fed-border);
			box-shadow: 0 0 20px 0 rgba(76,87,125,0.02);
			margin-bottom: 24px;
			overflow: hidden;
		}

		.fed-card-header {
			padding: 18px 24px;
			border-bottom: 1px solid var(--fed-border);
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.fed-card-title {
			font-size: 15px;
			font-weight: 700;
			color: var(--fed-text-main);
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.fed-card-badge {
			font-size: 11px;
			padding: 3px 8px;
			border-radius: 4px;
			font-weight: 600;
			background: #f3f6f9;
			color: #7e8299;
		}

		.fed-card-body {
			padding: 24px;
		}

		/* Form Controls */
		.fed-form-group {
			margin-bottom: 20px;
		}

		.fed-label {
			display: block;
			font-size: 13px;
			font-weight: 600;
			color: #3f4254;
			margin-bottom: 8px;
		}

		.fed-input,
		.fed-textarea {
			width: 100%;
			padding: 10px 14px;
			border: 1px solid #e2e8f0;
			background: #f8fafc;
			border-radius: 6px;
			font-family: inherit;
			font-size: 13.5px;
			color: #1e293b;
			outline: none;
			transition: all 0.2s;
		}

		.fed-input:focus,
		.fed-textarea:focus {
			border-color: #3699ff;
			background: #ffffff;
			box-shadow: 0 0 0 3px rgba(54, 153, 255, 0.15);
		}

		.fed-help {
			font-size: 11.5px;
			color: #94a3b8;
			margin-top: 5px;
		}

		.fed-form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 16px;
		}

		.fed-btn-save {
			background: linear-gradient(135deg, #ff6200 0%, #ff7e29 100%);
			color: #ffffff;
			border: none;
			border-radius: 6px;
			padding: 12px 28px;
			font-weight: 700;
			font-size: 14px;
			cursor: pointer;
			transition: opacity 0.2s, transform 0.1s;
			box-shadow: 0 4px 14px rgba(255, 98, 0, 0.3);
		}

		.fed-btn-save:hover {
			opacity: 0.95;
			transform: translateY(-1px);
		}

		/* Toggle Switch */
		.fed-toggle-row {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 12px 0;
			border-bottom: 1px solid var(--fed-border);
		}

		.fed-toggle-row:last-child {
			border-bottom: none;
		}

		.fed-switch {
			position: relative;
			display: inline-block;
			width: 44px;
			height: 24px;
		}

		.fed-switch input {
			opacity: 0;
			width: 0;
			height: 0;
		}

		.fed-slider {
			position: absolute;
			cursor: pointer;
			top: 0; left: 0; right: 0; bottom: 0;
			background-color: #cbd5e1;
			transition: .3s;
			border-radius: 24px;
		}

		.fed-slider:before {
			position: absolute;
			content: "";
			height: 18px;
			width: 18px;
			left: 3px;
			bottom: 3px;
			background-color: white;
			transition: .3s;
			border-radius: 50%;
		}

		input:checked + .fed-slider {
			background-color: #1bc5bd;
		}

		input:checked + .fed-slider:before {
			transform: translateX(20px);
		}

		/* Floating Social Dock */
		.fed-floating-dock {
			position: fixed;
			bottom: 24px;
			right: 24px;
			display: flex;
			gap: 12px;
			z-index: 999;
		}

		.fed-dock-btn {
			width: 48px;
			height: 48px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			box-shadow: 0 6px 16px rgba(0,0,0,0.15);
			text-decoration: none;
			transition: transform 0.2s;
		}

		.fed-dock-btn:hover {
			transform: scale(1.1);
			color: #fff;
		}

		.fed-dock-wa { background-color: #25d366; }
		.fed-dock-tg { background-color: #0088cc; }

		/* Responsive */
		@media (max-width: 992px) {
			.fed-grid { grid-template-columns: 1fr; }
			.fed-sidebar { width: 70px; }
			.fed-brand-title, .fed-brand-badge, .fed-nav-link span, .fed-btn-back span { display: none; }
			.fed-sidebar-brand { justify-content: center; padding: 16px 8px; }
			.fed-nav-link { justify-content: center; padding: 12px; }
		}

		@media (max-width: 600px) {
			body { flex-direction: column; }
			.fed-sidebar { width: 100%; min-height: auto; position: static; }
			.fed-nav { display: flex; overflow-x: auto; padding: 8px; }
			.fed-body { padding: 16px; }
			.fed-form-row { grid-template-columns: 1fr; }
		}
	</style>
</head>
<body>

	<!-- Left Dark Sidebar matching image -->
	<aside class="fed-sidebar">
		<div class="fed-sidebar-brand">
			<div class="fed-brand-icon">
				<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.891h-2.33v6.988C18.343 21.128 22 16.991 22 12c0-5.523-4.477-10-10-10z"/></svg>
			</div>
			<span class="fed-brand-title"><?php esc_html_e( 'Frontend Dashboard', 'ct-custom' ); ?></span>
			<span class="fed-brand-badge"><?php esc_html_e( 'v2.0', 'ct-custom' ); ?></span>
		</div>

		<ul class="fed-nav">
			<li class="fed-nav-item">
				<a href="#tab-settings" class="fed-nav-link active" onclick="switchTab('settings', this)">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
					<span><?php esc_html_e( 'Theme Settings', 'ct-custom' ); ?></span>
				</a>
			</li>
			<li class="fed-nav-item">
				<a href="#tab-profile" class="fed-nav-link" onclick="switchTab('profile', this)">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
					<span><?php esc_html_e( 'Profile & Roles', 'ct-custom' ); ?></span>
				</a>
			</li>
			<li class="fed-nav-item">
				<a href="#tab-content" class="fed-nav-link" onclick="switchTab('content', this)">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
					<span><?php esc_html_e( 'Homepage Content', 'ct-custom' ); ?></span>
				</a>
			</li>
			<li class="fed-nav-item">
				<a href="<?php echo esc_url( admin_url() ); ?>" class="fed-nav-link">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
					<span><?php esc_html_e( 'WP-Admin Panel', 'ct-custom' ); ?></span>
				</a>
			</li>
		</ul>

		<div class="fed-sidebar-footer">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fed-btn-back">
				<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
				<span><?php esc_html_e( 'Back to PSD Homepage', 'ct-custom' ); ?></span>
			</a>
		</div>
	</aside>

	<!-- Main Body Area -->
	<div class="fed-main">
		<!-- Top Bar -->
		<header class="fed-header">
			<div class="fed-header-title">
				<span><?php esc_html_e( 'Frontend Dashboard Workspace', 'ct-custom' ); ?></span>
			</div>
			<div class="fed-header-actions">
				<div class="fed-notify-badge">
					<span class="fed-notify-dot"></span>
					<span><?php esc_html_e( 'Notification Center: System Active', 'ct-custom' ); ?></span>
				</div>
				<div class="fed-user-pill">
					<div class="fed-avatar">
						<?php echo esc_html( strtoupper( substr( $current_user->user_login ? $current_user->user_login : 'C', 0, 1 ) ) ); ?>
					</div>
					<span class="fed-user-name">
						<?php echo esc_html( $current_user->user_login ? $current_user->user_login : 'coalitiontest' ); ?>
					</span>
				</div>
			</div>
		</header>

		<div class="fed-body">
			<?php if ( ! empty( $message ) ) : ?>
				<div class="fed-alert fed-alert-<?php echo esc_attr( $message_type ); ?>">
					<span><?php echo esc_html( $message ); ?></span>
				</div>
			<?php endif; ?>

			<!-- Top Stats Row -->
			<div class="fed-stats-row">
				<div class="fed-stat-card">
					<div class="fed-stat-icon primary">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
					</div>
					<div>
						<div class="fed-stat-value"><?php esc_html_e( 'Active', 'ct-custom' ); ?></div>
						<div class="fed-stat-label"><?php esc_html_e( 'Theme: CT Custom', 'ct-custom' ); ?></div>
					</div>
				</div>

				<div class="fed-stat-card">
					<div class="fed-stat-icon orange">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
					</div>
					<div>
						<div class="fed-stat-value"><?php esc_html_e( 'Homepage', 'ct-custom' ); ?></div>
						<div class="fed-stat-label"><?php esc_html_e( 'Frontpage Assigned', 'ct-custom' ); ?></div>
					</div>
				</div>

				<div class="fed-stat-card">
					<div class="fed-stat-icon success">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
					</div>
					<div>
						<div class="fed-stat-value"><?php esc_html_e( 'CF 7 Ready', 'ct-custom' ); ?></div>
						<div class="fed-stat-label"><?php esc_html_e( 'Form Integration', 'ct-custom' ); ?></div>
					</div>
				</div>

				<div class="fed-stat-card">
					<div class="fed-stat-icon warning">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
					</div>
					<div>
						<div class="fed-stat-value"><?php esc_html_e( 'No Plugins', 'ct-custom' ); ?></div>
						<div class="fed-stat-label"><?php esc_html_e( 'Pure Native Code', 'ct-custom' ); ?></div>
					</div>
				</div>
			</div>

			<!-- Main Form Section -->
			<form method="post" action="">
				<?php wp_nonce_field( 'ct_save_frontend_settings', 'ct_frontend_dashboard_nonce' ); ?>

				<div class="fed-grid">
					<!-- Left Main Card: Theme Settings -->
					<div class="fed-col-main">
						<!-- Tab 1: Theme Settings -->
						<div id="section-settings" class="fed-tab-section">
							<div class="fed-card">
								<div class="fed-card-header">
									<h2 class="fed-card-title">
										<svg viewBox="0 0 24 24" width="20" height="20" fill="#3699ff"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
										<span><?php esc_html_e( 'Theme Settings (Without Plugin)', 'ct-custom' ); ?></span>
									</h2>
									<span class="fed-card-badge"><?php esc_html_e( 'Coalition Skills Test Required', 'ct-custom' ); ?></span>
								</div>

								<div class="fed-card-body">
									<!-- Logo -->
									<div class="fed-form-group">
										<label class="fed-label"><?php esc_html_e( 'Logo Image URL', 'ct-custom' ); ?></label>
										<input type="text" name="logo_url" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['logo_url'] ) ? $theme_settings['logo_url'] : '' ); ?>" placeholder="https://example.com/logo.png">
										<p class="fed-help"><?php esc_html_e( 'Leave blank to use default PSD stylized text "YOURLOGO".', 'ct-custom' ); ?></p>
									</div>

									<!-- Phones -->
									<div class="fed-form-row">
										<div class="fed-form-group">
											<label class="fed-label"><?php esc_html_e( 'Top Phone Number (Call Us Now)', 'ct-custom' ); ?></label>
											<input type="text" name="top_phone" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['top_phone'] ) ? $theme_settings['top_phone'] : '385.154.11.28.35' ); ?>">
										</div>
										<div class="fed-form-group">
											<label class="fed-label"><?php esc_html_e( 'Phone Number (Reach Us)', 'ct-custom' ); ?></label>
											<input type="text" name="phone_number" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['phone_number'] ) ? $theme_settings['phone_number'] : '385.154.11.28.38' ); ?>">
										</div>
									</div>

									<!-- Fax & Address -->
									<div class="fed-form-group">
										<label class="fed-label"><?php esc_html_e( 'Fax Number', 'ct-custom' ); ?></label>
										<input type="text" name="fax_number" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['fax_number'] ) ? $theme_settings['fax_number'] : '385.154.35.66.78' ); ?>">
									</div>

									<div class="fed-form-group">
										<label class="fed-label"><?php esc_html_e( 'Address Information', 'ct-custom' ); ?></label>
										<textarea name="address_info" rows="3" class="fed-textarea"><?php echo esc_textarea( isset( $theme_settings['address_info'] ) ? $theme_settings['address_info'] : "Coalition Skills Test\n\n535 La Plata Street\n4200 Argentina" ); ?></textarea>
									</div>

									<!-- Social Links -->
									<h3 class="fed-label" style="margin-top:24px; font-size:14px;"><?php esc_html_e( 'Social Media Links', 'ct-custom' ); ?></h3>
									<div class="fed-form-row">
										<div class="fed-form-group">
											<label class="fed-label"><?php esc_html_e( 'Facebook URL', 'ct-custom' ); ?></label>
											<input type="url" name="social_facebook" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_facebook'] ) ? $theme_settings['social_facebook'] : '' ); ?>">
										</div>
										<div class="fed-form-group">
											<label class="fed-label"><?php esc_html_e( 'Twitter / X URL', 'ct-custom' ); ?></label>
											<input type="url" name="social_twitter" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_twitter'] ) ? $theme_settings['social_twitter'] : '' ); ?>">
										</div>
									</div>

									<div class="fed-form-row">
										<div class="fed-form-group">
											<label class="fed-label"><?php esc_html_e( 'LinkedIn URL', 'ct-custom' ); ?></label>
											<input type="url" name="social_linkedin" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_linkedin'] ) ? $theme_settings['social_linkedin'] : '' ); ?>">
										</div>
										<div class="fed-form-group">
											<label class="fed-label"><?php esc_html_e( 'Instagram URL', 'ct-custom' ); ?></label>
											<input type="url" name="social_instagram" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_instagram'] ) ? $theme_settings['social_instagram'] : '' ); ?>">
										</div>
									</div>

									<button type="submit" class="fed-btn-save">
										<?php esc_html_e( 'Save All Settings to Live Site', 'ct-custom' ); ?>
									</button>
								</div>
							</div>
						</div>

						<!-- Tab 2: Profile & Permissions -->
						<div id="section-profile" class="fed-tab-section" style="display:none;">
							<div class="fed-card">
								<div class="fed-card-header">
									<h2 class="fed-card-title"><?php esc_html_e( 'Role-Based Access & User Profile', 'ct-custom' ); ?></h2>
									<span class="fed-card-badge"><?php esc_html_e( 'Administrator', 'ct-custom' ); ?></span>
								</div>
								<div class="fed-card-body">
									<div class="fed-form-row" style="margin-bottom:20px;">
										<div>
											<label class="fed-label"><?php esc_html_e( 'Logged-in User', 'ct-custom' ); ?></label>
											<input type="text" class="fed-input" value="<?php echo esc_attr( $current_user->user_login ); ?>" readonly>
										</div>
										<div>
											<label class="fed-label"><?php esc_html_e( 'Assigned Role', 'ct-custom' ); ?></label>
											<input type="text" class="fed-input" value="Administrator (coalitiontest)" readonly>
										</div>
									</div>

									<div class="fed-toggle-row">
										<div>
											<strong><?php esc_html_e( 'Role-Based Permission Toggle', 'ct-custom' ); ?></strong>
											<p class="fed-help"><?php esc_html_e( 'Grant manage_options permission for theme settings.', 'ct-custom' ); ?></p>
										</div>
										<label class="fed-switch">
											<input type="checkbox" checked disabled>
											<span class="fed-slider"></span>
										</label>
									</div>

									<div class="fed-toggle-row">
										<div>
											<strong><?php esc_html_e( 'Hide WP-Admin for Non-Admins', 'ct-custom' ); ?></strong>
											<p class="fed-help"><?php esc_html_e( 'Keep subscriber users inside frontend dashboard.', 'ct-custom' ); ?></p>
										</div>
										<label class="fed-switch">
											<input type="checkbox" checked>
											<span class="fed-slider"></span>
										</label>
									</div>

									<div class="fed-toggle-row">
										<div>
											<strong><?php esc_html_e( 'Frontend Post Submission', 'ct-custom' ); ?></strong>
											<p class="fed-help"><?php esc_html_e( 'Allow author roles to draft posts from frontend.', 'ct-custom' ); ?></p>
										</div>
										<label class="fed-switch">
											<input type="checkbox" checked>
											<span class="fed-slider"></span>
										</label>
									</div>
								</div>
							</div>
						</div>

						<!-- Tab 3: Homepage Content Manager -->
						<div id="section-content" class="fed-tab-section" style="display:none;">
							<div class="fed-card">
								<div class="fed-card-header">
									<h2 class="fed-card-title"><?php esc_html_e( 'Manageable Page Content (the_content)', 'ct-custom' ); ?></h2>
									<span class="fed-card-badge"><?php esc_html_e( 'Homepage.php Template', 'ct-custom' ); ?></span>
								</div>
								<div class="fed-card-body">
									<div class="fed-form-group">
										<label class="fed-label"><?php esc_html_e( 'Homepage Intro Paragraph (from WordPress database)', 'ct-custom' ); ?></label>
										<textarea name="homepage_content" rows="5" class="fed-textarea"><?php echo esc_textarea( $homepage_content ); ?></textarea>
										<p class="fed-help"><?php esc_html_e( 'Editing this updates the intro text above the CONTACT US and REACH US columns.', 'ct-custom' ); ?></p>
									</div>
									<button type="submit" class="fed-btn-save">
										<?php esc_html_e( 'Update Homepage Content', 'ct-custom' ); ?>
									</button>
								</div>
							</div>
						</div>
					</div>

					<!-- Right Side Cards -->
					<div class="fed-col-side">
						<!-- Live Site Card -->
						<div class="fed-card">
							<div class="fed-card-header">
								<h3 class="fed-card-title"><?php esc_html_e( 'Live Preview & Canvas', 'ct-custom' ); ?></h3>
							</div>
							<div class="fed-card-body">
								<p style="font-size:13px; line-height:1.5; color:#64748b; margin-bottom:16px;">
									<?php esc_html_e( 'Changes saved here are instantly reflected on the PSD Homepage.', 'ct-custom' ); ?>
								</p>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="fed-btn-save" style="display:block; text-align:center; text-decoration:none; margin-bottom:12px;">
									<?php esc_html_e( 'Open PSD Homepage', 'ct-custom' ); ?> &rarr;
								</a>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=ct-theme-settings' ) ); ?>" target="_blank" class="fed-btn-back" style="color:#1e293b; background:#e2e8f0; justify-content:center;">
									<?php esc_html_e( 'Open WP-Admin Settings', 'ct-custom' ); ?>
								</a>
							</div>
						</div>

						<!-- Social Chat & Security Widget matching image -->
						<div class="fed-card">
							<div class="fed-card-header">
								<h3 class="fed-card-title"><?php esc_html_e( 'Security & Social Chat', 'ct-custom' ); ?></h3>
								<span class="fed-card-badge" style="background:#e8fff3; color:#1bc5bd;"><?php esc_html_e( 'Protected', 'ct-custom' ); ?></span>
							</div>
							<div class="fed-card-body">
								<div class="fed-toggle-row">
									<div>
										<strong style="font-size:12.5px;"><?php esc_html_e( 'Captcha & Bot Security', 'ct-custom' ); ?></strong>
									</div>
									<label class="fed-switch">
										<input type="checkbox" checked>
										<span class="fed-slider"></span>
									</label>
								</div>
								<div class="fed-toggle-row">
									<div>
										<strong style="font-size:12.5px;"><?php esc_html_e( 'Floating Social Chat Dock', 'ct-custom' ); ?></strong>
									</div>
									<label class="fed-switch">
										<input type="checkbox" checked id="toggle-dock" onchange="toggleDock(this.checked)">
										<span class="fed-slider"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Floating Social Chat Dock (WhatsApp & Telegram) from image -->
	<div class="fed-floating-dock" id="fed-dock">
		<a href="https://wa.me/" target="_blank" rel="noopener" class="fed-dock-btn fed-dock-wa" title="WhatsApp Chat">
			<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.41a8.16 8.16 0 0 1 2.4 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.12-.22-.19-.47-.32z"/></svg>
		</a>
		<a href="https://t.me/" target="_blank" rel="noopener" class="fed-dock-btn fed-dock-tg" title="Telegram Chat">
			<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.75-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
		</a>
	</div>

	<script>
		function switchTab(tabId, el) {
			document.querySelectorAll('.fed-nav-link').forEach(link => link.classList.remove('active'));
			if (el) el.classList.add('active');

			document.querySelectorAll('.fed-tab-section').forEach(sec => sec.style.display = 'none');
			const target = document.getElementById('section-' + tabId);
			if (target) target.style.display = 'block';
		}

		function toggleDock(show) {
			const dock = document.getElementById('fed-dock');
			if (dock) dock.style.display = show ? 'flex' : 'none';
		}
	</script>

	<?php wp_footer(); ?>
</body>
</html>

