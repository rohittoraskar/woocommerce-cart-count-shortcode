<?php

/*
 * Plugin Name: WooCommerce Cart Count Shortcode
 * Plugin URI: https://github.com/prontotools/woocommerce-cart-count-shortcode
 * Description: Display a link to your shopping cart with the item count anywhere on your site with a customizable shortcode.
 * Version: 1.0.0
 * Author: Pronto Tools
 * Author URI: http://www.prontotools.io
 */

function woocommerce_cart_count_shortcode( $atts ) {
    $defaults = array(
        "icon"               => "",
        "empty_cart_text"    => "",
        "items_in_cart_text" => "",
        "show_items"         => "",
        "custom_css"         => ""
    );

    $atts = shortcode_atts( $defaults, $atts );

    $icon_html = "";
    if ( $atts["icon"] ) {
        if ( $atts["icon"] == "cart" ) {
            $icon_html = '<i class="fa fa-shopping-cart"></i> ';
        } else {
            $icon_html = '<i class="fa fa-' . $atts["icon"] . '"></i> ';
        }
    }

    $cart_count = "";
    if ( class_exists( "WooCommerce" ) ) {
        global $woocommerce;
        $cart_count = $woocommerce->cart->get_cart_contents_count();
    }

    $cart_count_html = "";
    if ( $atts["show_items"] == "true" ) {
        $cart_count_html = " (" . $cart_count . ")";
    }

    $cart_text_html = "";
    $link_to_page = "";
    if ( $cart_count > 0 ) {
        if ( $atts["items_in_cart_text"] != "" ) {
            $cart_text_html = $atts["items_in_cart_text"];
        }
        $link_to_page = ' href="/cart/"';
    } else {
        if ( $atts["empty_cart_text"] != "" ) {
            $cart_text_html = $atts["empty_cart_text"];
        }
        $link_to_page = ' href="/shop/"';
    }

    $custom_css = "";
    if ( $atts["custom_css"] ) {
        $custom_css = ' class="' . $atts["custom_css"] . '"';
    }

    $html  = "<a" . $link_to_page . $custom_css . ">";
    $html .= $icon_html . $cart_text_html . $cart_count_html;
    $html .= "</a>";

    return $html;
}

add_shortcode( "cart_button", "woocommerce_cart_count_shortcode" );
