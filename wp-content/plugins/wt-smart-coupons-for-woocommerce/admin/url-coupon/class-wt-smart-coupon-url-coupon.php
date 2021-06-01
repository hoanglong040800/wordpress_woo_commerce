<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * Implement Basic URL coupon
 * @since 1.2.3
 */
if( ! class_exists ( 'Wt_Smart_Coupon_URL_Coupon' ) ) {
    class Wt_Smart_Coupon_URL_Coupon {

        protected $overwrite_coupon_message;

        public function __construct() {
            add_action('wp_loaded',array($this,'wt_apply_smart_coupon'));
            add_action('wt_smart_coupon_after_help_instrcution_contents',array($this,'add_coupon_instruction'));
            $overwrite_coupon_message  = array();
        }
        /**
         * Apply coupon by URL
         * @since 1.2.3
         */
        function wt_apply_smart_coupon(  ) {

            if( isset( $_GET['wt_coupon'] ) && '' != $_GET['wt_coupon'] ) {
                $coupon_code = $_GET['wt_coupon'];
                if( WC()->cart->get_cart_contents_count() != 0 ) {
                    $new_message = apply_filters( 'wt_smart_coupon_url_coupon_message', __('Coupon code applied successfully','wt-smart-coupons-for-woocommerce') );
                }  else {
                    $woo_shop_page = get_option( 'woocommerce_shop_page_id' );
                    $shop_page_url = get_page_link( $woo_shop_page );
                    
                    $new_message = apply_filters( 'wt_smart_coupon_url_coupon_message', sprintf( __( 'Oops your cart is empty! Add %1$s to your cart to avail the offer.','wt-smart-coupons-for-woocommerce'),'<a href="'.$shop_page_url.'">'.esc_html__('prodcuts','wt-smart-coupons-for-woocommerce').'</a>' ) );
                }
                $this->start_overwrite_coupon_success_message( $coupon_code,$new_message );
                WC()->cart->add_discount( sanitize_text_field( $coupon_code ));
                $this->stop_overwrite_coupon_success_message();

            }
        }
        
        /**
         * overwrite the coupon added message
         * @since 1.2.3
         */
        function start_overwrite_coupon_success_message( $coupon,$new_message = "" ) {
            $this->overwrite_coupon_message[$coupon] =  $new_message;
            add_filter( 'woocommerce_coupon_message', array( $this, 'owerwrite_coupon_code_message' ), 10, 3 );
        }

        /**
         * stop owerwriting coupon
         * @since 1.2.3
         */
        function stop_overwrite_coupon_success_message() {
            remove_filter( 'woocommerce_coupon_message', array( $this, 'owerwrite_coupon_code_message' ), 10 );
            $this->overwrite_coupon_message = array();
        }
        /**
         * Display the coupon message
         * @since 1.2.3
         */
        function owerwrite_coupon_code_message( $msg, $msg_code, $coupon ) {
            if ( isset( $this->overwrite_coupon_message[ $coupon->get_code() ] ) ) {
                $msg = $this->overwrite_coupon_message[ $coupon->get_code() ];
            }
            return $msg;
        }

        /**
         * Add URL coupon instruction on general settings.
         * @since 1.2.3
         */
        function add_coupon_instruction() {
            ?>
             <div class="wt_section_title">
                <h2>
                    <?php _e('URL coupon','wt-smart-coupons-for-woocommerce') ?>
                    
                </h2>

                <p><?php _e('URL Coupons help you add a unique URL to any coupon in your e-commerce store. Clicking this URL ensures that the underlying coupon is applied as per its respective configuration e.g allow discount, giveaway free product whatever the case maybe.','wt-smart-coupons-for-woocommerce') ?></p>
                <p><b><?php _e('Usage:','wt-smart-coupons-for-woocommerce') ?> {site_url}/?wt_coupon={coupon_code}</b> </p>
                <p style="color:#b3b2b2"><?php _e('e.g','wt-smart-coupons-for-woocommerce'); ?>, https://www.webtoffee.com/cart/?wt_coupon=flat30</p>
                <p style="color:#b3b2b2"><?php _e('A URL coupon that offers a flat 30 percentage of discount at www.webtoffee.com, coupon_code = FLAT30, site_url(preferably cart page)','wt-smart-coupons-for-woocommerce')?> = https://www.webtoffee.com/cart </p>
            </div>
            <div class="premium-features">
                <h2>
                    <?php _e('Premium features','wt-smart-coupons-for-woocommerce') ?>
                    
                </h2>
                <ul>
                    <li><?php _e('Pass coupon via link that will redirect to the cart/checkout page with products added into it.','wt-smart-coupons-for-woocommerce'); ?></li>
                    <li><?php _e('Ability to create customized URL with personalized text. For example, www.mystore.com/happybirthday','wt-smart-coupons-for-woocommerce'); ?></li>
                    <li><?php _e('Embed URL coupon in a QRCode','wt-smart-coupons-for-woocommerce'); ?> </li>
                </ul>
                <p> <?php _e('For advanced URL coupon please check our','wt-smart-coupons-for-woocommerce'); ?>
                <a href="https://www.webtoffee.com/product/url-coupons-for-woocommerce/" target="_blank" class=""><?php _e( 'Premium version','wt-smart-coupons-for-woocommerce'); ?></a>
            </div>


            <?php
        }
    

    }

   $url_coupon =  new Wt_Smart_Coupon_URL_Coupon();
}