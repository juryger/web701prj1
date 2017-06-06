<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account-dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/** 
 * NOTE: Depending on user role show specific Dashboard page (Customer vs Vendor)
 * Author: Iurii Gerasimov
 * Date: 03.06.2017
 */
$userId = get_current_user_id();
if ($userId > 0) {
	$userInfo = new WP_User( $userId );
	if ( !empty( $userInfo->roles ) && is_array( $userInfo->roles ) ) {
		foreach ( $userInfo->roles as $role ) {
			If (strcasecmp($role, "customer") == 0)
				$isCustomerRole = true;
			If (strcasecmp($role, "vendor") == 0)
				$isVendorRole = true;
		}
	}
}

if ($isCustomerRole) {
	do_action('woocommerce_account_dashboard');

	do_action('woocommerce_view_dashboard');

	do_action('woocommerce_account_downloads');

	do_action('woocommerce_account_orders');

	do_action('woocommerce_account_address');

	do_action('woocommerce_account_editaccount');
} else if ($isVendorRole) {
	/**
	 *  Dokan Dashboard Template
	 *
	 *  Dokan Main Dahsboard template for Fron-end
	 *
	 *  @since 2.4
	 *
	 *  @package dokan
	 */
?>
<div class="dokan-dashboard-wrap">
	<?php

		/**
		 *  dokan_dashboard_content_before hook
		 *
		 *  @hooked get_dashboard_side_navigation
		 *
		 *  @since 2.4
		 */
		do_action( 'dokan_dashboard_content_before' );
	?>

	<div class="dokan-dashboard-content">

		<?php

			/**
			 *  dokan_dashboard_content_before hook
			 *
			 *  @hooked show_seller_dashboard_notice
			 *
			 *  @since 2.4
			 */
			do_action( 'dokan_dashboard_content_inside_before' );
		?>

		<article class="dashboard-content-area">

			<?php

				/**
				 *  dokan_dashboard_before_widgets hook
				 *
				 *  @hooked dokan_show_profile_progressbar
				 *
				 *  @since 2.4
				 */
				do_action( 'dokan_dashboard_before_widgets' );
			?>

			<div class="dokan-w6 dokan-dash-left">

				<?php

					/**
					 *  dokan_dashboard_left_widgets hook
					 *
					 *  @hooked get_big_counter_widgets
					 *  @hooked get_orders_widgets
					 *  @hooked get_products_widgets
					 *
					 *  @since 2.4
					 */
					do_action( 'dokan_dashboard_left_widgets' );
				?>

			</div> <!-- .col-md-6 -->

			<div class="dokan-w6 dokan-dash-right">
				<?php
					/**
					 *  dokan_dashboard_right_widgets hook
					 *
					 *  @hooked get_sales_report_chart_widget
					 *
					 *  @since 2.4
					 */
					do_action( 'dokan_dashboard_right_widgets' );
				?>

			</div>

		</article><!-- .dashboard-content-area -->

		 <?php

			/**
			 *  dokan_dashboard_content_inside_after hook
			 *
			 *  @since 2.4
			 */
			do_action( 'dokan_dashboard_content_inside_after' );
		?>


	</div><!-- .dokan-dashboard-content -->

	<?php

		/**
		 *  dokan_dashboard_content_after hook
		 *
		 *  @since 2.4
		 */
		do_action( 'dokan_dashboard_content_after' );
	?>

</div><!-- .dokan-dashboard-wrap -->
<?php
}