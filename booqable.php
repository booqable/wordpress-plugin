<?php
    /*
    Plugin Name: Booqable Booking plugin
    Plugin URI: https://booqable.com
    Description: Let your customers directly book products from your website
    Author: Johan van Zonneveld
    Version: 1.0
    Author URI: https://booqable.com
    Copyright: 2004 - 2015 Checkfront Inc
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
      showPrices: <?php echo get_option('booqable_show_prices'); ?>,
      defaultLabel: '<?php echo get_option('booqable_default_label'); ?>'
    };
  </script>
  <script src="http://assets.booqable.dev/assets/store/booqable_v1.js"></script>
<?php }

add_action('wp_head', 'add_booqable_js');

## Add cart widget

include('booqable_cart_widget.php');

add_action('widgets_init',
  create_function('', 'return register_widget("BooqableCartWidget");')
);

## Add BBcode function

function booqable_product_bb($params) {

	// default parameters
	extract(shortcode_atts(array(
		'id' => ''
	), $params));

  return '<div class="booqable-product-component" data-id="' . $id . '"></div>';
}

add_shortcode('booqableproduct','booqable_product_bb');

?>
