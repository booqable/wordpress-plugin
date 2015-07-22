<?php
    /*
    Plugin Name: Booqable Booking plugin
    Plugin URI: https://booqable.com
    Description: Let your customers directly make rental reservations from your website
    Author: Johan van Zonneveld
    Version: 1.0.0.beta
    Author URI: https://booqable.com
    Copyright: 2015 Booqable
    */


## Booqable admin

function booqable_admin() {
  include('booqable_admin.php');
}

function booqable_admin_actions() {
  add_options_page("Booqable", "Booqable", 1, "Booqable", "booqable_admin");
}

add_action('admin_menu', 'booqable_admin_actions');

## Add client to header

function add_booqable_js() { ?>
  <script>
    var booqableOptions = {
      companyName: '<?php echo get_option('booqable_company_name'); ?>',
      showPrices: '<?php echo get_option('booqable_show_prices'); ?>',
      addButtonLabel: '<?php echo get_option('booqable_add_button_label'); ?>',
      addedButtonLabel: '<?php echo get_option('booqable_added_button_label'); ?>'
    };
  </script>
  <script src="https://d4lmxg2kcswpo.cloudfront.net/assets/store/booqable_v1.js"></script>
<?php }

add_action('wp_head', 'add_booqable_js');

## Add cart widget

include('booqable_cart_widget.php');

add_action('widgets_init',
  create_function('', 'return register_widget("BooqableCartWidget");')
);

## Company url function

function booqable_company_url() {
  $slug = get_option('booqable_company_name');
  $slug = sanitize_title_with_dashes($slug, null, 'save');

  return 'https://' . $slug . '.booqable.com';
}

## Add BBcode function

function booqable_product_bb($params) {

  // default parameters
  extract(shortcode_atts(array(
    'id' => '',
    'show_prices' => '',
    'add_button_label' => '',
    'added_button_label' => ''
  ), $params));

  return '<div class="booqable-product-component"
    data-id="' . $id . '"
    data-add-button-label="' . $add_button_label . '"
    data-added-button-label="' . $added_button_label . '"
    data-show-prices="' . $show_prices . '"></div>';
}

add_shortcode('booqable_product','booqable_product_bb');

function booqable_cart_bb($params) {
  // default parameters
  extract(shortcode_atts(array(
    'checkout_url' => '',
    'checkout_button_label' => ''
  ), $params));

  return '<div id="booqable-cart-component"
    data-checkout-button-label="' . $checkout_button_label . '"
    data-checkout-url="' . $checkout_url . '"></div>';
}

add_shortcode('booqable_cart','booqable_cart_bb');

function booqable_checkout_bb($params) {

  // default parameters
  extract(shortcode_atts(array(
    'width' => '100%',
    'height' => '500'
  ), $params));

  return '<iframe src="' . booqable_company_url() . '/store/checkout"
    width="' . $width . '"
    height="' . $height . '"
    ></div>';
}

add_shortcode('booqable_checkout','booqable_checkout_bb');

?>
