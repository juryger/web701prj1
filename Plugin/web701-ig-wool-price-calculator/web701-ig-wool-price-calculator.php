<?php
/*
Plugin Name: WEB701 Wool price calculator
Plugin URI: https://wordpress.org/plugins/hello-dolly/
Description: WEB701 Individual Project 1 plugin which implement wool price calculator.
Author: Iurii Gerasimov
Version: 1.0
Author URI: https://iuriiweb701atnmit.wordpress.com/
Text Domain: hello-dolly
*/

function w701igwpc_log( $code ) {

    if ( is_null( $code ) || is_string($code) || is_int( $code ) || is_bool($code) || is_float( $code ) ) :
        $code = var_export( $code, true );
    else :
        $code = print_r( $code, true );
    endif;

    error_log( $code );
}

function w701igwpc_on_setup_plugin()
{
    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc]: init');

    w701igwpc_register_custom_css_js();

    if (shortcode_exists('w701igwpc_calculator') == false )
    {
        // register shortcode for calculator
        add_shortcode('w701igwpc_calculator', 'w701igwpc_show_calculator');
        w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc]: shortcode [w701igwpc_calculator] has been registered (exist? - ' . shortcode_exists('w701igwpc_calculator') . ')');
    }
}
add_action( 'init', 'w701igwpc_on_setup_plugin' );

function w701igwpc_register_custom_css_js()
{
    //registering custom javascript and css
    wp_register_script('WoolPriceCalculator', plugins_url('public/js/WoolPriceCalculator.js', __FILE__), array('jquery'));
    wp_register_style('WoolPriceCalculator', plugins_url('public/css/WoolPriceCalculator.css', __FILE__));
}

function w701igwpc_show_calculator()
{
    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc]: executing shortcode [w701igwpc_calculator]...');

    ob_start();
    require 'WoolPriceCalculator.php';
    //$return = ob_get_flush();
    $return = ob_get_contents();
    ob_end_clean();

    // always return
    return $return;
}

function w701igwpc_enqueue_css_js(){
    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc]: enqueue css and js files (ajax_url)');

    wp_enqueue_script('WoolPriceCalculator');
    wp_enqueue_style( 'WoolPriceCalculator' );

    wp_localize_script( 'admin_ajax_front', 'front', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'w701igwpc_enqueue_css_js');

function w701igwpc_calculate_price_action() {
    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc]: action called - calculate_price_action');

    $fiberDiameter = $_POST['fiberDiameter'];
    $fiberLength = $_POST['fiberLength'];
    $fiberStrength = $_POST['fiberStrength'];
    $woolColour = $_POST['woolColour'];

    echo 'Your price: ' . $fiberDiameter . ', ' . $fiberLength . ', ' . $fiberStrength . ',' . $woolColour;

    die();
}
add_action('wp_ajax_nopriv_w701igwpc_calculate_price_action', 'w701igwpc_calculate_price_action');
add_action('wp_ajax_w701igwpc_calculate_price_action', 'w701igwpc_calculate_price_action');

function w701igwpc_on_activate()
{
    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc] has been activated successfully');
}
register_activation_hook( __FILE__, 'w701igwpc_on_activate' );

function w701igwpc_on_deactivation()
{
    if ( shortcode_exists('w701igwpc_calculator') )
    {
        // unregister shortcode for calculator
        remove_shortcode('w701igwpc_calculator');
        w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc]: shortcode [w701igwpc_calculator] has been unregistered (exist? - ' . shortcode_exists('w701igwpc_calculator') . ')');
    }

    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc] has been deactivated successfully');
}
register_deactivation_hook( __FILE__, 'w701igwpc_on_deactivation' );

function w701igwpc_on_uninstall()
{
    w701igwpc_log('WoolPriceCalculator Plugin [w701igwpc] has been uninstalled');
}
register_uninstall_hook(__FILE__, 'w701igwpc_on_uninstall');