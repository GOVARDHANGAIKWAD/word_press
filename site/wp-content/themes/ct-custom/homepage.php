<?php
/**
 * Template Name: Homepage
 *
 * Direct Frontend Dashboard matching the user reference image,
 * with full native Theme Settings management and PSD template toggle.
 *
 * @package CT_Custom
 */

// Handle Frontend Settings Form Submission
$status_msg = '';
$status_type = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['ct_frontend_nonce'] ) ) {
	if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ct_frontend_nonce'] ) ), 'ct_save_frontend_action' ) ) {
		$existing = get_option( 'ct_theme_settings', array() );

		if ( isset( $_POST['logo_url'] ) ) {
			$existing['logo_url']         = esc_url_raw( trim( wp_unslash( $_POST['logo_url'] ) ) );
			$existing['top_phone']        = sanitize_text_field( wp_unslash( $_POST['top_phone'] ) );
			$existing['phone_number']     = sanitize_text_field( wp_unslash( $_POST['phone_number'] ) );
			$existing['fax_number']       = sanitize_text_field( wp_unslash( $_POST['fax_number'] ) );
			$existing['address_info']     = sanitize_textarea_field( wp_unslash( $_POST['address_info'] ) );
			$existing['social_facebook']  = esc_url_raw( trim( wp_unslash( $_POST['social_facebook'] ) ) );
			$existing['social_twitter']   = esc_url_raw( trim( wp_unslash( $_POST['social_twitter'] ) ) );
			$existing['social_linkedin']  = esc_url_raw( trim( wp_unslash( $_POST['social_linkedin'] ) ) );
			$existing['social_pinterest'] = esc_url_raw( trim( wp_unslash( $_POST['social_pinterest'] ) ) );
			$existing['social_instagram'] = esc_url_raw( trim( wp_unslash( $_POST['social_instagram'] ) ) );

			update_option( 'ct_theme_settings', $existing );
			$status_msg = __( 'Theme Settings updated successfully!', 'ct-custom' );
			$status_type = 'success';
		}

		if ( isset( $_POST['homepage_content'] ) ) {
			$front_id = get_option( 'page_on_front' );
			if ( $front_id ) {
				wp_update_post( array(
					'ID'           => $front_id,
					'post_content' => wp_kses_post( wp_unslash( $_POST['homepage_content'] ) ),
				) );
			}
		}
	}
}

$theme_settings = get_option( 'ct_theme_settings', array() );
$current_user   = wp_get_current_user();
$front_id       = get_option( 'page_on_front' );
$homepage_post  = $front_id ? get_post( $front_id ) : null;
$homepage_intro = $homepage_post ? $homepage_post->post_content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam posuere ipsum nec velit mattis elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas eu placerat metus, eget placerat libero.';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php esc_html_e( 'Frontend Dashboard', 'ct-custom' ); ?> &mdash; <?php bloginfo( 'name' ); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Ubuntu:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
	<?php wp_head(); ?>

	<style>
		:root {
			--fed-dark-sidebar: #171727;
			--fed-dark-card: #202035;
			--fed-purple: #7047eb;
			--fed-purple-light: #f3effe;
			--fed-purple-border: #d8cafc;
			--fed-blue: #0088cc;
			--fed-green: #25d366;
			--fed-orange: #ff6200;
			--fed-bg-gradient: radial-gradient(circle at 10% 20%, #f4f2ff 0%, #edf1fd 50%, #f7f9fc 100%);
			--fed-text-main: #2b2f3e;
			--fed-text-muted: #7e8299;
			--fed-card-bg: #ffffff;
			--fed-border: #e8ebf3;
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }
		body {
			font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
			background: var(--fed-bg-gradient);
			color: var(--fed-text-main);
			min-height: 100vh;
			display: flex;
			overflow-x: hidden;
		}

		/* Left Dark Sidebar */
		.fed-sidebar {
			width: 240px;
			background-color: var(--fed-dark-sidebar);
			color: #ffffff;
			display: flex;
			flex-direction: column;
			flex-shrink: 0;
			min-height: 100vh;
			position: sticky;
			top: 0;
			box-shadow: 4px 0 24px rgba(0,0,0,0.08);
			z-index: 100;
		}

		.fed-sidebar-brand {
			padding: 24px;
			display: flex;
			align-items: center;
			gap: 12px;
			border-bottom: 1px solid rgba(255,255,255,0.06);
		}

		.fed-brand-icon {
			width: 40px;
			height: 40px;
			background: linear-gradient(135deg, #7047eb 0%, #906bf9 100%);
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-weight: 800;
			font-size: 20px;
			box-shadow: 0 4px 12px rgba(112, 71, 235, 0.4);
		}

		.fed-brand-name {
			font-size: 16px;
			font-weight: 700;
			color: #ffffff;
			letter-spacing: -0.2px;
		}

		.fed-nav-list {
			list-style: none;
			padding: 20px 12px;
			flex: 1;
		}

		.fed-nav-item {
			margin-bottom: 6px;
		}

		.fed-nav-btn {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 12px 16px;
			color: #8c8fa7;
			text-decoration: none;
			border-radius: 8px;
			font-size: 13.5px;
			font-weight: 600;
			transition: all 0.2s ease;
			cursor: pointer;
			border: none;
			background: transparent;
			width: 100%;
			text-align: left;
		}

		.fed-nav-btn:hover {
			background-color: rgba(255,255,255,0.06);
			color: #ffffff;
		}

		.fed-nav-btn.active {
			background: linear-gradient(135deg, #7047eb 0%, #8762f7 100%);
			color: #ffffff;
			box-shadow: 0 4px 14px rgba(112, 71, 235, 0.35);
		}

		.fed-nav-btn svg {
			width: 18px;
			height: 18px;
			flex-shrink: 0;
		}

		.fed-sidebar-footer {
			padding: 18px;
			border-top: 1px solid rgba(255,255,255,0.06);
		}

		.fed-btn-view-psd {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			width: 100%;
			padding: 11px;
			background: rgba(255, 98, 0, 0.18);
			color: #ff914d;
			border: 1px solid rgba(255, 98, 0, 0.3);
			border-radius: 8px;
			text-decoration: none;
			font-size: 13px;
			font-weight: 700;
			transition: all 0.2s;
			cursor: pointer;
		}

		.fed-btn-view-psd:hover {
			background: #ff6200;
			color: #ffffff;
			border-color: #ff6200;
		}

		/* Main Content Area */
		.fed-main {
			flex: 1;
			display: flex;
			flex-direction: column;
			min-width: 0;
		}

		/* Banner & Badge Area matching reference */
		.fed-top-pills {
			padding: 20px 32px 10px;
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: center;
			gap: 12px;
		}

		.fed-pill {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			padding: 7px 16px;
			border-radius: 30px;
			font-size: 12px;
			font-weight: 600;
			border: 1px dashed #c8b9f7;
			background: #ffffff;
			color: #5534b8;
			box-shadow: 0 2px 6px rgba(112,71,235,0.06);
		}

		.fed-pill.active-pill {
			background: #eef2ff;
			border-color: #6366f1;
			color: #4f46e5;
			border-style: solid;
		}

		.fed-pill-icon {
			width: 18px;
			height: 18px;
			border-radius: 4px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}

		/* Workspace Grid */
		.fed-workspace {
			padding: 16px 32px 40px;
			flex: 1;
		}

		/* View 1: Frontend Dashboard */
		.fed-dashboard-grid {
			display: grid;
			grid-template-columns: 280px 1fr 300px;
			gap: 22px;
			align-items: flex-start;
		}

		/* Cards */
		.fed-card {
			background: var(--fed-card-bg);
			border-radius: 16px;
			border: 1px solid rgba(220, 224, 235, 0.7);
			box-shadow: 0 8px 30px rgba(50, 50, 93, 0.04);
			padding: 24px;
			margin-bottom: 22px;
			position: relative;
		}

		.fed-card-title {
			font-size: 15px;
			font-weight: 700;
			color: #1e293b;
			margin-bottom: 16px;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.fed-card-badge {
			font-size: 11px;
			font-weight: 700;
			padding: 3px 8px;
			border-radius: 6px;
			background: #eef2ff;
			color: #6366f1;
		}

		/* Profile Card */
		.fed-profile-header {
			display: flex;
			align-items: center;
			gap: 14px;
			margin-bottom: 18px;
		}

		.fed-avatar-circle {
			width: 52px;
			height: 52px;
			border-radius: 50%;
			background: linear-gradient(135deg, #7047eb 0%, #ff6200 100%);
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: 700;
			font-size: 20px;
			box-shadow: 0 4px 12px rgba(112, 71, 235, 0.25);
		}

		.fed-profile-name {
			font-size: 16px;
			font-weight: 700;
			color: #1e293b;
		}

		.fed-profile-role {
			font-size: 12px;
			color: #64748b;
			font-weight: 500;
		}

		/* Form Inputs */
		.fed-input-group {
			margin-bottom: 14px;
		}

		.fed-input-label {
			display: block;
			font-size: 12px;
			font-weight: 600;
			color: #475569;
			margin-bottom: 6px;
		}

		.fed-input,
		.fed-textarea {
			width: 100%;
			padding: 9px 12px;
			border: 1px solid #e2e8f0;
			background: #f8fafc;
			border-radius: 8px;
			font-family: inherit;
			font-size: 13px;
			color: #1e293b;
			outline: none;
			transition: all 0.2s;
		}

		.fed-input:focus,
		.fed-textarea:focus {
			border-color: #7047eb;
			background: #ffffff;
			box-shadow: 0 0 0 3px rgba(112, 71, 235, 0.12);
		}

		/* Toggle Switches matching image */
		.fed-switch-row {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 10px 0;
			border-top: 1px solid #f1f5f9;
		}

		.fed-switch-title {
			font-size: 12.5px;
			font-weight: 600;
			color: #334155;
		}

		.fed-switch-desc {
			font-size: 11px;
			color: #94a3b8;
		}

		.fed-switch {
			position: relative;
			display: inline-block;
			width: 42px;
			height: 22px;
		}

		.fed-switch input { opacity: 0; width: 0; height: 0; }

		.fed-switch-slider {
			position: absolute;
			cursor: pointer;
			top: 0; left: 0; right: 0; bottom: 0;
			background-color: #cbd5e1;
			transition: .3s;
			border-radius: 22px;
		}

		.fed-switch-slider:before {
			position: absolute;
			content: "";
			height: 16px;
			width: 16px;
			left: 3px;
			bottom: 3px;
			background-color: white;
			transition: .3s;
			border-radius: 50%;
		}

		input:checked + .fed-switch-slider {
			background-color: #7047eb;
		}

		input:checked + .fed-switch-slider:before {
			transform: translateX(20px);
		}

		/* Middle Card: Post / Theme Editor */
		.fed-dropzone {
			border: 2px dashed #cbd5e1;
			background: #f8fafc;
			border-radius: 12px;
			padding: 24px;
			text-align: center;
			margin-bottom: 18px;
			cursor: pointer;
			transition: border-color 0.2s;
		}

		.fed-dropzone:hover {
			border-color: #7047eb;
			background: #fdfcff;
		}

		/* Stats Banner matching image */
		.fed-chart-banner {
			background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
			border-radius: 12px;
			padding: 16px;
			margin-top: 18px;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.fed-chart-stat {
			font-size: 12px;
			font-weight: 600;
			color: #475569;
		}

		.fed-chart-stat strong {
			color: #7047eb;
			font-size: 14px;
		}

		/* Pro / Chat Card */
		.fed-pro-card {
			background: linear-gradient(135deg, #1e1e2d 0%, #2a2a40 100%);
			color: #ffffff;
			border-radius: 16px;
			padding: 22px;
			margin-bottom: 22px;
		}

		.fed-pro-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 12px;
		}

		.fed-pro-tag {
			background: #ff6200;
			color: #fff;
			font-size: 11px;
			font-weight: 700;
			padding: 2px 8px;
			border-radius: 4px;
		}

		.fed-pro-progress {
			width: 100%;
			height: 8px;
			background: rgba(255,255,255,0.15);
			border-radius: 10px;
			overflow: hidden;
			margin: 10px 0 6px;
		}

		.fed-pro-bar {
			width: 90%;
			height: 100%;
			background: linear-gradient(90deg, #7047eb, #ff6200);
			border-radius: 10px;
		}

		.fed-btn-submit {
			background: linear-gradient(135deg, #7047eb 0%, #8b62ff 100%);
			color: #ffffff;
			border: none;
			border-radius: 8px;
			padding: 12px 24px;
			font-weight: 700;
			font-size: 13.5px;
			cursor: pointer;
			box-shadow: 0 4px 14px rgba(112, 71, 235, 0.35);
			transition: all 0.2s;
			width: 100%;
		}

		.fed-btn-submit:hover {
			opacity: 0.95;
			transform: translateY(-1px);
		}

		/* Floating Social Dock matching image */
		.fed-floating-dock {
			position: fixed;
			bottom: 24px;
			right: 24px;
			display: flex;
			gap: 12px;
			z-index: 9999;
		}

		.fed-dock-btn {
			width: 50px;
			height: 50px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #ffffff;
			box-shadow: 0 8px 24px rgba(0,0,0,0.18);
			text-decoration: none;
			transition: transform 0.2s, box-shadow 0.2s;
		}

		.fed-dock-btn:hover {
			transform: translateY(-4px);
			box-shadow: 0 12px 28px rgba(0,0,0,0.25);
			color: #ffffff;
		}

		.fed-dock-wa { background-color: #25d366; }
		.fed-dock-tg { background-color: #0088cc; }

		/* Alert */
		.fed-alert {
			background: #e8fff3;
			border: 1px solid #1bc5bd;
			color: #0bb783;
			padding: 12px 18px;
			border-radius: 10px;
			margin-bottom: 20px;
			font-size: 13.5px;
			font-weight: 600;
		}

		/* PSD View Styles */
		#view-psd {
			display: none;
			background: #ffffff;
			border-radius: 16px;
			box-shadow: 0 10px 40px rgba(0,0,0,0.06);
			overflow: hidden;
		}

		@media (max-width: 1100px) {
			.fed-dashboard-grid { grid-template-columns: 1fr; }
			.fed-sidebar { width: 70px; }
			.fed-brand-name, .fed-nav-btn span, .fed-btn-view-psd span { display: none; }
			.fed-sidebar-brand { justify-content: center; padding: 16px 8px; }
			.fed-nav-btn { justify-content: center; padding: 12px; }
		}

		@media (max-width: 650px) {
			body { flex-direction: column; }
			.fed-sidebar { width: 100%; min-height: auto; position: static; }
			.fed-nav-list { display: flex; overflow-x: auto; padding: 8px; }
			.fed-top-pills { padding: 12px; }
			.fed-workspace { padding: 12px; }
		}
	</style>
</head>
<body>

	<!-- Left Dark Sidebar matching image -->
	<aside class="fed-sidebar">
		<div class="fed-sidebar-brand">
			<div class="fed-brand-icon">
				<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.891h-2.33v6.988C18.343 21.128 22 16.991 22 12c0-5.523-4.477-10-10-10z"/></svg>
			</div>
			<span class="fed-brand-name"><?php esc_html_e( 'Frontend Dashboard', 'ct-custom' ); ?></span>
		</div>

		<ul class="fed-nav-list">
			<li class="fed-nav-item">
				<button class="fed-nav-btn active" id="btn-fed-home" onclick="switchView('dashboard')">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
					<span><?php esc_html_e( 'Dashboard Home', 'ct-custom' ); ?></span>
				</button>
			</li>
			<li class="fed-nav-item">
				<button class="fed-nav-btn" id="btn-fed-psd" onclick="switchView('psd')">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
					<span><?php esc_html_e( 'PSD Template View', 'ct-custom' ); ?></span>
				</button>
			</li>
			<li class="fed-nav-item">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=ct-theme-settings' ) ); ?>" class="fed-nav-btn">
					<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
					<span><?php esc_html_e( 'WP-Admin Settings', 'ct-custom' ); ?></span>
				</a>
			</li>
		</ul>

		<div class="fed-sidebar-footer">
			<button type="button" class="fed-btn-view-psd" onclick="switchView('psd')">
				<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
				<span><?php esc_html_e( 'View Skills Test PSD', 'ct-custom' ); ?></span>
			</button>
		</div>
	</aside>

	<!-- Main Workspace Area -->
	<div class="fed-main">

		<!-- Top Feature Pills matching the reference screenshot -->
		<div class="fed-top-pills">
			<div class="fed-pill active-pill">
				<span class="fed-pill-icon" style="background:#6366f1; color:#fff;">✓</span>
				<span><?php esc_html_e( 'Direct Frontend Dashboard Active', 'ct-custom' ); ?></span>
			</div>
			<div class="fed-pill">
				<span class="fed-pill-icon" style="background:#e0e7ff; color:#4338ca;">★</span>
				<span><?php esc_html_e( 'Auto-Login: coalitiontest (Admin)', 'ct-custom' ); ?></span>
			</div>
			<div class="fed-pill">
				<span class="fed-pill-icon" style="background:#ecfdf5; color:#059669;">🛡️</span>
				<span><?php esc_html_e( 'Role-Based Access Control', 'ct-custom' ); ?></span>
			</div>
			<div class="fed-pill">
				<span class="fed-pill-icon" style="background:#fef3c7; color:#d97706;">⚡</span>
				<span><?php esc_html_e( 'Canvas / Full Width', 'ct-custom' ); ?></span>
			</div>
			<div class="fed-pill">
				<span class="fed-pill-icon" style="background:#f1f5f9; color:#475569;">💬</span>
				<span><?php esc_html_e( 'Social Chat (WhatsApp / Telegram)', 'ct-custom' ); ?></span>
			</div>
		</div>

		<div class="fed-workspace">
			<?php if ( ! empty( $status_msg ) ) : ?>
				<div class="fed-alert">
					✓ <?php echo esc_html( $status_msg ); ?>
				</div>
			<?php endif; ?>

			<!-- VIEW 1: FRONTEND DASHBOARD (Active by default) -->
			<div id="view-dashboard">
				<form method="post" action="">
					<?php wp_nonce_field( 'ct_save_frontend_action', 'ct_frontend_nonce' ); ?>

					<div class="fed-dashboard-grid">

						<!-- Left Column Card: Profile & Permissions -->
						<div class="fed-col">
							<div class="fed-card">
								<div class="fed-card-title">
									<span><?php esc_html_e( 'Profile', 'ct-custom' ); ?></span>
									<span class="fed-card-badge"><?php esc_html_e( 'Administrator', 'ct-custom' ); ?></span>
								</div>

								<div class="fed-profile-header">
									<div class="fed-avatar-circle">
										<?php echo esc_html( strtoupper( substr( $current_user->user_login ? $current_user->user_login : 'C', 0, 1 ) ) ); ?>
									</div>
									<div>
										<div class="fed-profile-name"><?php echo esc_html( $current_user->user_login ? $current_user->user_login : 'coalitiontest' ); ?></div>
										<div class="fed-profile-role"><?php esc_html_e( 'Super Admin • Direct Access', 'ct-custom' ); ?></div>
									</div>
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'Dynamic Custom Form Field', 'ct-custom' ); ?></label>
									<input type="text" class="fed-input" value="Austin GH - coalitiontest" readonly>
								</div>

								<div class="fed-switch-row">
									<div>
										<div class="fed-switch-title"><?php esc_html_e( 'Role-Based Permission Toggle', 'ct-custom' ); ?></div>
										<div class="fed-switch-desc"><?php esc_html_e( 'Full theme admin rights', 'ct-custom' ); ?></div>
									</div>
									<label class="fed-switch">
										<input type="checkbox" checked disabled>
										<span class="fed-switch-slider"></span>
									</label>
								</div>

								<div class="fed-switch-row">
									<div>
										<div class="fed-switch-title"><?php esc_html_e( 'Hide WP-Admin: ON', 'ct-custom' ); ?></div>
										<div class="fed-switch-desc"><?php esc_html_e( 'Direct frontend workflow', 'ct-custom' ); ?></div>
									</div>
									<label class="fed-switch">
										<input type="checkbox" checked>
										<span class="fed-switch-slider"></span>
									</label>
								</div>

								<div class="fed-switch-row">
									<div>
										<div class="fed-switch-title"><?php esc_html_e( 'Frontend Post Submission', 'ct-custom' ); ?></div>
										<div class="fed-switch-desc"><?php esc_html_e( 'Direct content manager', 'ct-custom' ); ?></div>
									</div>
									<label class="fed-switch">
										<input type="checkbox" checked>
										<span class="fed-switch-slider"></span>
									</label>
								</div>
							</div>

							<!-- Pro Card from screenshot -->
							<div class="fed-pro-card">
								<div class="fed-pro-header">
									<strong><?php esc_html_e( 'Pro Workspace', 'ct-custom' ); ?></strong>
									<span class="fed-pro-tag"><?php esc_html_e( 'Active', 'ct-custom' ); ?></span>
								</div>
								<div style="font-size:12px; opacity:0.8;"><?php esc_html_e( 'Credits: 180 / 200', 'ct-custom' ); ?></div>
								<div class="fed-pro-progress">
									<div class="fed-pro-bar"></div>
								</div>
								<div style="font-size:11px; opacity:0.7; margin-top:8px;">
									<?php esc_html_e( 'Unlimited local development enabled.', 'ct-custom' ); ?>
								</div>
							</div>
						</div>

						<!-- Center Column Card: Theme Settings & Content -->
						<div class="fed-col">
							<div class="fed-card">
								<div class="fed-card-title">
									<span><?php esc_html_e( 'Theme Settings (Skills Test Requirements)', 'ct-custom' ); ?></span>
									<span class="fed-card-badge" style="background:#ffefe5; color:#ff6200;"><?php esc_html_e( 'Without Plugin', 'ct-custom' ); ?></span>
								</div>

								<!-- Dropzone / Logo Upload -->
								<div class="fed-dropzone" onclick="document.getElementById('fed-logo-input').focus()">
									<svg viewBox="0 0 24 24" width="32" height="32" fill="#7047eb" style="margin-bottom:6px;"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
									<div style="font-size:13px; font-weight:700; color:#1e293b;"><?php esc_html_e( 'Image Upload for Logo', 'ct-custom' ); ?></div>
									<div style="font-size:11px; color:#94a3b8; margin-top:2px;"><?php esc_html_e( 'Drag and drop or enter logo URL below', 'ct-custom' ); ?></div>
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'Logo Image URL', 'ct-custom' ); ?></label>
									<input type="text" id="fed-logo-input" name="logo_url" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['logo_url'] ) ? $theme_settings['logo_url'] : '' ); ?>" placeholder="https://example.com/logo.png">
								</div>

								<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
									<div class="fed-input-group">
										<label class="fed-input-label"><?php esc_html_e( 'Top Phone Number (Call Us Now)', 'ct-custom' ); ?></label>
										<input type="text" name="top_phone" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['top_phone'] ) ? $theme_settings['top_phone'] : '385.154.11.28.35' ); ?>">
									</div>
									<div class="fed-input-group">
										<label class="fed-input-label"><?php esc_html_e( 'Reach Us Phone Number', 'ct-custom' ); ?></label>
										<input type="text" name="phone_number" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['phone_number'] ) ? $theme_settings['phone_number'] : '385.154.11.28.38' ); ?>">
									</div>
								</div>

								<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
									<div class="fed-input-group">
										<label class="fed-input-label"><?php esc_html_e( 'Fax Number', 'ct-custom' ); ?></label>
										<input type="text" name="fax_number" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['fax_number'] ) ? $theme_settings['fax_number'] : '385.154.35.66.78' ); ?>">
									</div>
									<div class="fed-input-group">
										<label class="fed-input-label"><?php esc_html_e( 'Facebook Profile URL', 'ct-custom' ); ?></label>
										<input type="url" name="social_facebook" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_facebook'] ) ? $theme_settings['social_facebook'] : 'https://facebook.com' ); ?>">
									</div>
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'Address Information (Multiline)', 'ct-custom' ); ?></label>
									<textarea name="address_info" rows="3" class="fed-textarea"><?php echo esc_textarea( isset( $theme_settings['address_info'] ) ? $theme_settings['address_info'] : "Coalition Skills Test\n\n535 La Plata Street\n4200 Argentina" ); ?></textarea>
								</div>

								<!-- Manageable Page Content -->
								<div class="fed-input-group" style="margin-top:18px;">
									<label class="fed-input-label"><?php esc_html_e( 'Homepage Intro Content (the_content)', 'ct-custom' ); ?></label>
									<textarea name="homepage_content" rows="3" class="fed-textarea"><?php echo esc_textarea( $homepage_intro ); ?></textarea>
								</div>

								<!-- Stats row matching image -->
								<div class="fed-chart-banner">
									<div class="fed-chart-stat">
										<?php esc_html_e( 'Submissions:', 'ct-custom' ); ?> <strong>82%</strong>
									</div>
									<div class="fed-chart-stat">
										<?php esc_html_e( 'Issues:', 'ct-custom' ); ?> <strong>0</strong>
									</div>
									<div class="fed-chart-stat">
										<?php esc_html_e( 'Flexibility:', 'ct-custom' ); ?> <strong>100%</strong>
									</div>
								</div>

								<div style="margin-top:20px;">
									<button type="submit" class="fed-btn-submit">
										<?php esc_html_e( 'Save All Settings Directly', 'ct-custom' ); ?>
									</button>
								</div>
							</div>
						</div>

						<!-- Right Column Card: Social & Navigation -->
						<div class="fed-col">
							<div class="fed-card">
								<div class="fed-card-title">
									<span><?php esc_html_e( 'Social Media Links', 'ct-custom' ); ?></span>
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'Twitter / X URL', 'ct-custom' ); ?></label>
									<input type="url" name="social_twitter" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_twitter'] ) ? $theme_settings['social_twitter'] : 'https://twitter.com' ); ?>">
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'LinkedIn URL', 'ct-custom' ); ?></label>
									<input type="url" name="social_linkedin" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_linkedin'] ) ? $theme_settings['social_linkedin'] : 'https://linkedin.com' ); ?>">
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'Instagram URL', 'ct-custom' ); ?></label>
									<input type="url" name="social_instagram" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_instagram'] ) ? $theme_settings['social_instagram'] : 'https://instagram.com' ); ?>">
								</div>

								<div class="fed-input-group">
									<label class="fed-input-label"><?php esc_html_e( 'Pinterest URL', 'ct-custom' ); ?></label>
									<input type="url" name="social_pinterest" class="fed-input" value="<?php echo esc_attr( isset( $theme_settings['social_pinterest'] ) ? $theme_settings['social_pinterest'] : 'https://pinterest.com' ); ?>">
								</div>

								<div class="fed-switch-row" style="margin-top:16px;">
									<div>
										<div class="fed-switch-title"><?php esc_html_e( 'Captcha & Bot Security', 'ct-custom' ); ?></div>
										<div class="fed-switch-desc"><?php esc_html_e( 'Automatic protection', 'ct-custom' ); ?></div>
									</div>
									<label class="fed-switch">
										<input type="checkbox" checked>
										<span class="fed-switch-slider"></span>
									</label>
								</div>
							</div>

							<!-- PSD View Trigger Card -->
							<div class="fed-card" style="text-align:center;">
								<div class="fed-card-title" style="justify-content:center;">
									<span><?php esc_html_e( 'Skills Test PSD Design', 'ct-custom' ); ?></span>
								</div>
								<p style="font-size:12.5px; color:#64748b; margin-bottom:16px;">
									<?php esc_html_e( 'Switch to the Coalition Technologies converted PSD layout with Contact Form 7 and Reach Us box.', 'ct-custom' ); ?>
								</p>
								<button type="button" class="fed-btn-submit" style="background:#ff6200; box-shadow:0 4px 14px rgba(255,98,0,0.35);" onclick="switchView('psd')">
									<?php esc_html_e( 'Switch to PSD View', 'ct-custom' ); ?> &rarr;
								</button>
							</div>
						</div>

					</div>
				</form>
			</div>

			<!-- VIEW 2: FULL PSD SKILLS TEST TEMPLATE -->
			<div id="view-psd">
				<!-- Top Bar with Return to Dashboard Button -->
				<div style="background:#171727; padding:12px 24px; display:flex; justify-content:space-between; align-items:center;">
					<span style="color:#fff; font-size:13px; font-weight:700;">
						<?php esc_html_e( 'Coalition Technologies Skills Test PSD Template View', 'ct-custom' ); ?>
					</span>
					<button type="button" onclick="switchView('dashboard')" style="background:#7047eb; color:#fff; border:none; padding:6px 14px; border-radius:6px; font-weight:700; cursor:pointer; font-size:12px;">
						&larr; <?php esc_html_e( 'Back to Frontend Dashboard', 'ct-custom' ); ?>
					</button>
				</div>

				<!-- Embedded PSD Structure -->
				<?php get_template_part( 'template-parts/content', 'psd' ); ?>
			</div>

		</div>
	</div>

	<!-- Floating Social Chat Dock (WhatsApp & Telegram) from reference image -->
	<div class="fed-floating-dock">
		<a href="https://wa.me/" target="_blank" rel="noopener" class="fed-dock-btn fed-dock-wa" title="WhatsApp Chat">
			<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.41a8.16 8.16 0 0 1 2.4 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.12-.22-.19-.47-.32z"/></svg>
		</a>
		<a href="https://t.me/" target="_blank" rel="noopener" class="fed-dock-btn fed-dock-tg" title="Telegram Chat">
			<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.75-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
		</a>
	</div>

	<script>
		function switchView(viewName) {
			const dashView = document.getElementById('view-dashboard');
			const psdView  = document.getElementById('view-psd');
			const btnHome  = document.getElementById('btn-fed-home');
			const btnPsd   = document.getElementById('btn-fed-psd');

			if (viewName === 'psd') {
				dashView.style.display = 'none';
				psdView.style.display  = 'block';
				btnHome.classList.remove('active');
				btnPsd.classList.add('active');
				window.scrollTo({ top: 0, behavior: 'smooth' });
			} else {
				dashView.style.display = 'block';
				psdView.style.display  = 'none';
				btnHome.classList.add('active');
				btnPsd.classList.remove('active');
				window.scrollTo({ top: 0, behavior: 'smooth' });
			}
		}
	</script>

	<?php wp_footer(); ?>
</body>
</html>
