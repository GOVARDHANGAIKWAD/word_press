<?php
/**
 * Theme Settings Page (No plugin required)
 * Coalition Technologies Skills Test
 *
 * @package CT_Custom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Theme Settings menu in WP Admin.
 */
function ct_custom_add_theme_settings_menu() {
	add_menu_page(
		__( 'Theme Settings', 'ct-custom' ),
		__( 'Theme Settings', 'ct-custom' ),
		'manage_options',
		'ct-theme-settings',
		'ct_custom_theme_settings_render_page',
		'dashicons-admin-generic',
		59
	);
}
add_action( 'admin_menu', 'ct_custom_add_theme_settings_menu' );

/**
 * Enqueue WordPress Media Uploader scripts for Theme Settings.
 */
function ct_custom_theme_settings_admin_scripts( $hook ) {
	if ( 'toplevel_page_ct-theme-settings' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'ct_custom_theme_settings_admin_scripts' );

/**
 * Register settings, sections, and fields.
 */
function ct_custom_register_theme_settings() {
	register_setting(
		'ct_theme_settings_group',
		'ct_theme_settings',
		'ct_custom_sanitize_theme_settings'
	);

	// Section 1: Header & Logo
	add_settings_section(
		'ct_section_general',
		__( 'Header & Logo Settings', 'ct-custom' ),
		'ct_section_general_cb',
		'ct-theme-settings'
	);

	add_settings_field(
		'logo_url',
		__( 'Logo Image', 'ct-custom' ),
		'ct_field_logo_url_cb',
		'ct-theme-settings',
		'ct_section_general'
	);

	add_settings_field(
		'top_phone',
		__( 'Top Bar Phone Number (Call Us Now)', 'ct-custom' ),
		'ct_field_top_phone_cb',
		'ct-theme-settings',
		'ct_section_general'
	);

	// Section 2: Contact & Address Information
	add_settings_section(
		'ct_section_contact',
		__( 'Contact & Address Information', 'ct-custom' ),
		'ct_section_contact_cb',
		'ct-theme-settings'
	);

	add_settings_field(
		'phone_number',
		__( 'Phone Number', 'ct-custom' ),
		'ct_field_phone_number_cb',
		'ct-theme-settings',
		'ct_section_contact'
	);

	add_settings_field(
		'fax_number',
		__( 'Fax Number', 'ct-custom' ),
		'ct_field_fax_number_cb',
		'ct-theme-settings',
		'ct_section_contact'
	);

	add_settings_field(
		'address_info',
		__( 'Address Information', 'ct-custom' ),
		'ct_field_address_info_cb',
		'ct-theme-settings',
		'ct_section_contact'
	);

	// Section 3: Social Media Links
	add_settings_section(
		'ct_section_social',
		__( 'Social Media Links', 'ct-custom' ),
		'ct_section_social_cb',
		'ct-theme-settings'
	);

	add_settings_field(
		'social_facebook',
		__( 'Facebook URL', 'ct-custom' ),
		'ct_field_social_facebook_cb',
		'ct-theme-settings',
		'ct_section_social'
	);

	add_settings_field(
		'social_twitter',
		__( 'Twitter / X URL', 'ct-custom' ),
		'ct_field_social_twitter_cb',
		'ct-theme-settings',
		'ct_section_social'
	);

	add_settings_field(
		'social_linkedin',
		__( 'LinkedIn URL', 'ct-custom' ),
		'ct_field_social_linkedin_cb',
		'ct-theme-settings',
		'ct_section_social'
	);

	add_settings_field(
		'social_pinterest',
		__( 'Pinterest URL', 'ct-custom' ),
		'ct_field_social_pinterest_cb',
		'ct-theme-settings',
		'ct_section_social'
	);

	add_settings_field(
		'social_instagram',
		__( 'Instagram URL', 'ct-custom' ),
		'ct_field_social_instagram_cb',
		'ct-theme-settings',
		'ct_section_social'
	);

	// Section 4: Form Integration
	add_settings_section(
		'ct_section_form',
		__( 'Contact Form Settings', 'ct-custom' ),
		'ct_section_form_cb',
		'ct-theme-settings'
	);

	add_settings_field(
		'cf7_shortcode',
		__( 'Contact Form 7 Shortcode', 'ct-custom' ),
		'ct_field_cf7_shortcode_cb',
		'ct-theme-settings',
		'ct_section_form'
	);
}
add_action( 'admin_init', 'ct_custom_register_theme_settings' );

/**
 * Sanitize all fields before saving.
 */
function ct_custom_sanitize_theme_settings( $input ) {
	$output = array();

	$output['logo_url']         = isset( $input['logo_url'] ) ? esc_url_raw( trim( $input['logo_url'] ) ) : '';
	$output['top_phone']        = isset( $input['top_phone'] ) ? sanitize_text_field( $input['top_phone'] ) : '';
	$output['phone_number']     = isset( $input['phone_number'] ) ? sanitize_text_field( $input['phone_number'] ) : '';
	$output['fax_number']       = isset( $input['fax_number'] ) ? sanitize_text_field( $input['fax_number'] ) : '';
	$output['address_info']     = isset( $input['address_info'] ) ? sanitize_textarea_field( $input['address_info'] ) : '';
	$output['social_facebook']  = isset( $input['social_facebook'] ) ? esc_url_raw( trim( $input['social_facebook'] ) ) : '';
	$output['social_twitter']   = isset( $input['social_twitter'] ) ? esc_url_raw( trim( $input['social_twitter'] ) ) : '';
	$output['social_linkedin']  = isset( $input['social_linkedin'] ) ? esc_url_raw( trim( $input['social_linkedin'] ) ) : '';
	$output['social_pinterest'] = isset( $input['social_pinterest'] ) ? esc_url_raw( trim( $input['social_pinterest'] ) ) : '';
	$output['social_instagram'] = isset( $input['social_instagram'] ) ? esc_url_raw( trim( $input['social_instagram'] ) ) : '';
	$output['cf7_shortcode']    = isset( $input['cf7_shortcode'] ) ? sanitize_text_field( $input['cf7_shortcode'] ) : '';

	return $output;
}

/**
 * Section callbacks
 */
function ct_section_general_cb() {
	echo '<p>' . esc_html__( 'Upload custom logo and configure top bar call details.', 'ct-custom' ) . '</p>';
}
function ct_section_contact_cb() {
	echo '<p>' . esc_html__( 'Manage contact information displayed in the Reach Us box.', 'ct-custom' ) . '</p>';
}
function ct_section_social_cb() {
	echo '<p>' . esc_html__( 'Manage social media profile links.', 'ct-custom' ) . '</p>';
}
function ct_section_form_cb() {
	echo '<p>' . esc_html__( 'Configure the Contact Form 7 integration for the homepage contact form.', 'ct-custom' ) . '</p>';
}

/**
 * Field callbacks
 */
function ct_field_logo_url_cb() {
	$options  = get_option( 'ct_theme_settings', array() );
	$logo_url = isset( $options['logo_url'] ) ? $options['logo_url'] : '';
	?>
	<div class="ct-logo-uploader-wrap">
		<input type="text" name="ct_theme_settings[logo_url]" id="ct_logo_url" value="<?php echo esc_attr( $logo_url ); ?>" class="regular-text" style="margin-bottom:10px;">
		<input type="button" class="button button-secondary" value="<?php esc_attr_e( 'Upload Logo Image', 'ct-custom' ); ?>" id="ct_upload_logo_btn">
		<input type="button" class="button button-link-delete" value="<?php esc_attr_e( 'Remove Logo', 'ct-custom' ); ?>" id="ct_remove_logo_btn" style="<?php echo empty( $logo_url ) ? 'display:none;' : ''; ?>">
		<p class="description"><?php esc_html_e( 'Choose an image from the Media Library or upload a new one. Leave blank to display the default "YOURLOGO" branding.', 'ct-custom' ); ?></p>
		<div id="ct_logo_preview" style="margin-top:10px; max-width:250px; background:#f9f9f9; padding:8px; border:1px solid #ddd; <?php echo empty( $logo_url ) ? 'display:none;' : ''; ?>">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'Logo Preview', 'ct-custom' ); ?>" style="max-width:100%; height:auto; display:block;">
		</div>
	</div>
	<?php
}

function ct_field_top_phone_cb() {
	$options   = get_option( 'ct_theme_settings', array() );
	$top_phone = isset( $options['top_phone'] ) ? $options['top_phone'] : '385.154.11.28.35';
	?>
	<input type="text" name="ct_theme_settings[top_phone]" value="<?php echo esc_attr( $top_phone ); ?>" class="regular-text">
	<p class="description"><?php esc_html_e( 'Displayed next to CALL US NOW! in the top orange bar.', 'ct-custom' ); ?></p>
	<?php
}

function ct_field_phone_number_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$phone   = isset( $options['phone_number'] ) ? $options['phone_number'] : '385.154.11.28.38';
	?>
	<input type="text" name="ct_theme_settings[phone_number]" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
	<p class="description"><?php esc_html_e( 'Displayed in the REACH US box.', 'ct-custom' ); ?></p>
	<?php
}

function ct_field_fax_number_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$fax     = isset( $options['fax_number'] ) ? $options['fax_number'] : '385.154.35.66.78';
	?>
	<input type="text" name="ct_theme_settings[fax_number]" value="<?php echo esc_attr( $fax ); ?>" class="regular-text">
	<p class="description"><?php esc_html_e( 'Displayed in the REACH US box.', 'ct-custom' ); ?></p>
	<?php
}

function ct_field_address_info_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$default_address = "Coalition Skills Test\n535 La Plata Street\n4200 Argentina";
	$address = isset( $options['address_info'] ) ? $options['address_info'] : $default_address;
	?>
	<textarea name="ct_theme_settings[address_info]" rows="4" cols="50" class="large-text"><?php echo esc_textarea( $address ); ?></textarea>
	<p class="description"><?php esc_html_e( 'Enter address details line by line.', 'ct-custom' ); ?></p>
	<?php
}

function ct_field_social_facebook_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$val     = isset( $options['social_facebook'] ) ? $options['social_facebook'] : 'https://facebook.com';
	?>
	<input type="url" name="ct_theme_settings[social_facebook]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="https://facebook.com/yourpage">
	<?php
}

function ct_field_social_twitter_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$val     = isset( $options['social_twitter'] ) ? $options['social_twitter'] : 'https://twitter.com';
	?>
	<input type="url" name="ct_theme_settings[social_twitter]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="https://twitter.com/yourprofile">
	<?php
}

function ct_field_social_linkedin_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$val     = isset( $options['social_linkedin'] ) ? $options['social_linkedin'] : 'https://linkedin.com';
	?>
	<input type="url" name="ct_theme_settings[social_linkedin]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="https://linkedin.com/company/yourcompany">
	<?php
}

function ct_field_social_pinterest_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$val     = isset( $options['social_pinterest'] ) ? $options['social_pinterest'] : 'https://pinterest.com';
	?>
	<input type="url" name="ct_theme_settings[social_pinterest]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="https://pinterest.com/yourprofile">
	<?php
}

function ct_field_social_instagram_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$val     = isset( $options['social_instagram'] ) ? $options['social_instagram'] : 'https://instagram.com';
	?>
	<input type="url" name="ct_theme_settings[social_instagram]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="https://instagram.com/yourprofile">
	<?php
}

function ct_field_cf7_shortcode_cb() {
	$options = get_option( 'ct_theme_settings', array() );
	$val     = isset( $options['cf7_shortcode'] ) ? $options['cf7_shortcode'] : '[contact-form-7 id="4" title="Contact form 1"]';
	?>
	<input type="text" name="ct_theme_settings[cf7_shortcode]" value="<?php echo esc_attr( $val ); ?>" class="large-text">
	<p class="description"><?php esc_html_e( 'Contact Form 7 shortcode to display on the Homepage.', 'ct-custom' ); ?></p>
	<?php
}

/**
 * Render the Theme Settings page.
 */
function ct_custom_theme_settings_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><span class="dashicons dashicons-admin-generic" style="font-size:32px; width:32px; height:32px; vertical-align:middle; margin-right:8px;"></span><?php esc_html_e( 'Theme Settings', 'ct-custom' ); ?></h1>
		<p><?php esc_html_e( 'Manage your header logo, contact information, social links, and form options below without any extra plugin.', 'ct-custom' ); ?></p>
		
		<?php settings_errors(); ?>

		<form method="post" action="options.php" style="background:#fff; padding:20px 30px; border:1px solid #ccd0d4; box-shadow:0 1px 1px rgba(0,0,0,.04); border-radius:4px; max-width:850px;">
			<?php
			settings_fields( 'ct_theme_settings_group' );
			do_settings_sections( 'ct-theme-settings' );
			submit_button( __( 'Save Theme Settings', 'ct-custom' ), 'primary' );
			?>
		</form>
	</div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var mediaUploader;
		$('#ct_upload_logo_btn').on('click', function(e) {
			e.preventDefault();
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}
			mediaUploader = wp.media({
				title: '<?php echo esc_js( __( 'Select or Upload Logo Image', 'ct-custom' ) ); ?>',
				button: {
					text: '<?php echo esc_js( __( 'Use this Logo', 'ct-custom' ) ); ?>'
				},
				multiple: false
			});
			mediaUploader.on('select', function() {
				var attachment = mediaUploader.state().get('selection').first().toJSON();
				$('#ct_logo_url').val(attachment.url);
				$('#ct_logo_preview img').attr('src', attachment.url);
				$('#ct_logo_preview').show();
				$('#ct_remove_logo_btn').show();
			});
			mediaUploader.open();
		});

		$('#ct_remove_logo_btn').on('click', function(e) {
			e.preventDefault();
			$('#ct_logo_url').val('');
			$('#ct_logo_preview').hide();
			$(this).hide();
		});
	});
	</script>
	<?php
}

/**
 * Helper function to retrieve a setting value.
 */
function ct_get_theme_option( $key, $default = '' ) {
	$options = get_option( 'ct_theme_settings', array() );
	if ( isset( $options[ $key ] ) && '' !== $options[ $key ] ) {
		return $options[ $key ];
	}
	return $default;
}

