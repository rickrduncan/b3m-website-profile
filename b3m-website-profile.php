<?php
/**
* Plugin Name:		B3M Website Profile
* Description:		This plugin creates a simple admin menu and options panel to host website profile settings such as company name, phone number and social media URLs.
* Author:			Rick R. Duncan - B3Marketing, LLC
* Author URI:		http://rickrduncan.com
*
* License:			GPLv3
* License URI:		https://www.gnu.org/licenses/gpl-3.0.html
*
* Version:			2.0.0
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
			return get_option( 'b3m_website_options' );
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
				__( 'Website Profile' ),
				__( 'Website Profile' ),
				'manage_options',
				'website-profile',
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
			register_setting( 'b3m_website_options', 'b3m_website_options', array( 'B3M_Website_Profile', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				if ( ! empty( $options['company-name'] ) ) {
					$options['company-name'] = sanitize_text_field( $options['company-name'] );
				} else {
					unset( $options['company-name'] ); // Remove from options if empty
				}

				if ( ! empty( $options['company-address'] ) ) {
					$options['company-address'] = esc_textarea( $options['company-address'] );
				} else {
					unset( $options['company-address'] ); // Remove from options if empty
				}

				if ( ! empty( $options['phone'] ) ) {
					$options['phone'] = sanitize_text_field( $options['phone'] );
				} else {
					unset( $options['phone'] ); // Remove from options if empty
				}

				if ( ! empty( $options['email'] ) ) {
					$options['email'] = sanitize_text_field( $options['email'] );
				} else {
					unset( $options['email'] ); // Remove from options if empty
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

				<h1><?php echo ( 'Website Profile for '.get_option( 'blogname' ) ); ?></h1>

				<form method="post" action="options.php">

					<?php settings_fields( 'b3m_website_options' ); ?>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php echo( 'Company Name' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'company-name' ); ?>
								<input class="regular-text" type="text" name="b3m_website_options[company-name]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">[website-profile item="company-name"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo( 'Company Address' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'company-address' ); ?>
								<textarea class="regular-text" rows="3" name="b3m_website_options[company-address]"><?php echo esc_html( $value ); ?></textarea>
								<p id="tagline-description" class="description">[website-profile item="company-address"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo( 'Phone Number' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'phone' ); ?>
								<input class="regular-text" type="text" name="b3m_website_options[phone]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">[website-profile item="phone"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo( 'Email Address' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'email' ); ?>
								<input class="regular-text" type="email" name="b3m_website_options[email]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">[website-profile item="email"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo( 'Facebook URL' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'facebook' ); ?>
								<input class="regular-text" type="url" name="b3m_website_options[facebook]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">[website-profile item="facebook"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo ( 'LinkedIn URL' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'linkedin' ); ?>
								<input class="regular-text" type="url" name="b3m_website_options[linkedin]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">[website-profile item="linkedin"]</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo ( 'Twitter URL' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'twitter' ); ?>
								<input class="regular-text" type="url" name="b3m_website_options[twitter]" value="<?php echo esc_attr( $value ); ?>">
								<p id="tagline-description" class="description">[website-profile item="twitter"]</p>
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
function b3m_get_website_profile_options( $id = '' ) {
	return B3M_Website_Profile::get_theme_option( $id );
}


/**
 *
 * Retrieve a setting using shortcode
 * To return the phone number: [website-profile item="phone"]
 * 
 *
 * @since 1.0.0
 *
 */
function b3m_website_profile_shortcode( $atts ) {
    
    return nl2br( b3m_get_website_profile_options( $atts['item'] ) );
}
add_shortcode( 'website-profile', 'b3m_website_profile_shortcode' );

