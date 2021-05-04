<?php
/*
Plugin Name: Force Authentification Before Checkout for WooCommerce
Description: Force customer to log in or register before checkout
Version: 1.3.2
Author: Luiz Bills
Author URI: https://luizpb.com/

License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Text Domain: wc-force-auth
Domain Path: /languages

WC requires at least: 3.0
WC tested up to: 5.2
*/

if ( ! defined( 'WPINC' ) ) die();

class WC_Force_Auth_Before_Checkout {

	const FILE = __FILE__;
	const URL_ARG = 'redirect_to_checkout';

	protected static $_instance = null;

	protected function __construct () {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function is_woocommerce_installed () {
		return function_exists( 'WC' );
	}

	public function init () {
		if ( ! $this->is_woocommerce_installed() ) {
			add_action( 'admin_notices', [ $this, 'add_admin_notice' ] );
			return;
		};

		add_action( 'admin_notices', [ $this, 'add_donation_notice' ] );
		add_action( 'init', [ $this, 'load_plugin_textdomain' ] );

		add_action( 'template_redirect', [ $this, 'redirect_to_account_page' ] );
		add_action( 'wp_head', [ $this, 'on_account_page' ] );

		add_filter( 'woocommerce_registration_redirect', [ $this, 'redirect_to_checkout' ], 100 );
		add_filter( 'woocommerce_login_redirect', [ $this, 'redirect_to_checkout' ], 100 );
	}

	public function redirect_to_account_page () {
		$condition = apply_filters(
			'wc_force_auth_redirect_to_account_page',
			is_checkout() && ! is_user_logged_in()
		);
		if( $condition ) {
			$login_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$redirect = apply_filters( 'wc_force_auth_login_page_url', $login_page_url );
			wp_safe_redirect( add_query_arg( self::URL_ARG, '', $redirect ) );
			die;
		}
	}

	public function redirect_to_checkout ( $redirect ) {
		if ( isset( $_GET[ self::URL_ARG ] ) ) {
			$redirect = apply_filters( 'wc_force_auth_checkout_page_url', wc_get_checkout_url() );
		}
		return $redirect;
	}

	public function on_account_page () {
		if ( is_account_page() && isset( $_GET[ self::URL_ARG ] ) ) {
			if ( ! is_user_logged_in() ) {
				wc_add_notice( $this->get_alert_message(), 'notice' );
			} else {
				?>
				<meta http-equiv="Refresh" content="0; url='<?= esc_attr( wc_get_checkout_url() ); ?>'" />
				<?php
				exit();
			}
		}
	}

	public function get_alert_message () {
		return apply_filters( 'wc_force_auth_message', __( 'Please log in or register to complete your purchase.', 'wc-force-auth' ) );
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wc-force-auth', false, dirname( plugin_basename( self::FILE ) ) . '/languages/' );
	}

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function add_admin_notice () {
		?>
		<div class="notice notice-error">
			<p>
				<?= esc_html__( 'You need install and activate the WooCommerce plugin.', 'wc-force-auth' ) ?>
			</p>
		</div>
		<?php
	}

	public function add_donation_notice () {
		global $pagenow;
		$plugin_data = \get_plugin_data( __FILE__ );
		$plugin_name = $plugin_data['Name'];

		if ( 'plugins.php' !== $pagenow ) return;

		if ( isset( $_GET['wc_force_auth_dismiss_donation_notice'] ) ) {
			update_option(
				'wc_force_auth_donation_notice_dismissed',
				time()
			);
		}

		$notice_dismissed = (int) get_option( 'wc_force_auth_donation_notice_dismissed' );
		$timeout = (4 * MONTH_IN_SECONDS) + $notice_dismissed;
		if ( time() <= $timeout ) {
			return;
		}
		?>
		<div id="wc_force_auth_donation_notice" class="notice notice-info is-dismissible">
			<p>
				<?= sprintf(
					esc_html__( 'Thanks for using the %s plugin! Consider making a donation to help keep this plugin always up to date.', 'wc-force-auth' ),
					"<strong>$plugin_name</strong>"
				); ?>
			</p>
			<p>
				<a href="https://www.paypal.com/donate?hosted_button_id=29U8C2YV4BBQC&source=url" class="button button-primary">
					<?= esc_html__( 'Donate', 'wc-force-auth' ); ?> 
				</a>
			</p>
		</div>
		<script>
			window.jQuery(function ($) {
				const dismiss_selector = '#wc_force_auth_donation_notice .notice-dismiss';
				$(document).on('click', dismiss_selector, function (evt) {
					const current_page = window.location.origin + window.location.pathname;
					window.location = current_page + '?wc_force_auth_dismiss_donation_notice'
				})
			})
		</script>
		<?php
	}
}

WC_Force_Auth_Before_Checkout::get_instance();
