<?php
/*
Plugin Name: 	B3M Website Profile
Plugin URI: 	http://rickrduncan.com/free-plugins/b3m-website-profile-999
Description: 	This plugin creates a simple admin menu and options panel to host website profile settings such as phone number and social media URLs.
Author: 		Rick R. Duncan
Author URI: 	http://rickrduncan.com
Source: 		http://www.wpexplorer.com/wordpress-theme-options/
*/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'B3M_Website_Profile' ) ) {

	class B3M_Website_Profile {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'B3M_Website_Profile', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'B3M_Website_Profile', 'register_settings' ) );
			}

		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_options() {
			return get_option( 'theme_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_option( $id ) {
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'Website Profile', 'text-domain' ),
				esc_html__( 'Website Profile', 'text-domain' ),
				'manage_options',
				'theme-settings',
				array( 'B3M_Website_Profile', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'theme_options', 'theme_options', array( 'B3M_Website_Profile', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				if ( ! empty( $options['phone'] ) ) {
					$options['phone'] = sanitize_text_field( $options['phone'] );
				} else {
					unset( $options['phone'] ); // Remove from options if empty
				}

				if ( ! empty( $options['email'] ) ) {
					$options['email'] = sanitize_text_field( $options['email'] );
				} else {
					unset( $options['phone'] ); // Remove from options if empty
				}

				if ( ! empty( $options['facebook'] ) ) {
					$options['facebook'] = sanitize_text_field( $options['facebook'] );
				} else {
					unset( $options['facebook'] ); // Remove from options if empty
				}

				if ( ! empty( $options['linkedin'] ) ) {
					$options['linkedin'] = sanitize_text_field( $options['linkedin'] );
				} else {
					unset( $options['linkedin'] ); // Remove from options if empty
				}
				
				if ( ! empty( $options['twitter'] ) ) {
					$options['twitter'] = sanitize_text_field( $options['twitter'] );
				} else {
					unset( $options['twitter'] ); // Remove from options if empty
				}
			}

			// Return sanitized options
			return $options;
		}	


		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">

				<h1><?php esc_html_e( 'Website Profile for '.get_option( 'blogname' ).'', 'text-domain' ); ?></h1>

				<form method="post" action="options.php">

					<?php settings_fields( 'theme_options' ); ?>

					<table class="form-table">

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Phone Number', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'phone' ); ?>
								<input class="regular-text" type="text" name="theme_options[phone]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">Shortcode useage: [site-setting item="phone"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Email Address', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'email' ); ?>
								<input class="regular-text" type="email" name="theme_options[email]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">Shortcode useage: [site-setting item="email"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Facebook URL', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'facebook' ); ?>
								<input class="regular-text" type="url" name="theme_options[facebook]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">Shortcode useage: [site-setting item="facebook"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'LinkedIn URL', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'linkedin' ); ?>
								<input class="regular-text" type="url" name="theme_options[linkedin]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">Shortcode useage: [site-setting item="linkedin"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Twitter URL', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'twitter' ); ?>
								<input class="regular-text" type="url" name="theme_options[twitter]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">Shortcode useage: [site-setting item="twitter"]</p>
							</td>
						</tr>
					</table>

					<?php submit_button(); ?>

				</form>

			</div><!-- .wrap -->
		<?php }

	}
}
new B3M_Website_Profile();


/**
 *
 * Helper function to return a theme option value
 *
 * @since 1.0.0
 *
 */
function b3m_get_theme_option( $id = '' ) {
	return B3M_Website_Profile::get_theme_option( $id );
}


/**
 *
 * Retrieve a setting using shortcode
 * To return the phone number: [site-setting item="phone"]
 * 
 *
 * @since 1.0.0
 *
 */
function b3m_get_site_settings( $atts ) {
    
    return b3m_get_theme_option( $atts['item'] );
}
add_shortcode( 'site-setting', 'b3m_get_site_settings' );
















