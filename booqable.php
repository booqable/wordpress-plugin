<?php
    /*
    Plugin Name: Booqable Online Rental Shop
    Description: Enables your customers to make rental reservations from your website by Connecting Wordpress to the Booqable Reservation Software. Reservations are securely stored in the Booqable backoffice app.
    Author: Johan van Zonneveld
    Version: 2.1.0
    Author URI: https://booqable.com
    Copyright: 2017 Booqable
    */


// Booqable admin

function booqable_admin() {
  include('booqable_admin.php');
}

function booqable_admin_actions() {
  add_options_page("Booqable", "Booqable", 1, "Booqable", "booqable_admin");
}
add_action('admin_menu', 'booqable_admin_actions');

// Load client script

function add_booqable_js() {
  wp_enqueue_script('booqable_v2', 'https://d4lmxg2kcswpo.cloudfront.net/assets/store/booqable_v2.js', array(), '2.0.0', true);
}

add_action('wp_enqueue_scripts', 'add_booqable_js');

// Insert client configuration
function add_booqable_client_configuration_js() {
  ?>
  <script>var booqableOptions = { company: '<?php echo get_option('booqable_company_name'); ?>' };</script>
  <?php
}
add_action('wp_head', 'add_booqable_client_configuration_js');

// BBcodes

// Convert shortcode options to data-{key}={value}
function shortcode_options_to_data($options) {
  $data = implode(' ', array_map(
    function ($v, $k) {
      if (! empty($v)) {
        return sprintf("data-%s=\"%s\"", $k, $v);
      }
    },
    $options,
    array_keys($options)
  ));

  return $data;
}

// BBcode for embedding a product
// [booqable_card id="ipad"]
function booqable_card_bb($params) {
  $options = shortcode_atts(array(
    'id' => NULL
  ), $params);

  return '<div class="booqable-product" ' . shortcode_options_to_data($options) . '></div>';
}
add_shortcode('booqable_card', 'booqable_card_bb');

// BBcode for embedding a product button
// [booqable_button id="ipad"]
function booqable_button_bb($params) {
  $options = shortcode_atts(array(
    'id' => NULL
  ), $params);

  return '<div class="booqable-product-button" ' . shortcode_options_to_data($options) . '></div>';
}
add_shortcode('booqable_button', 'booqable_button_bb');
add_shortcode('booqable_product', 'booqable_button_bb');

// BBcode for embedding a product detail view
// [booqable_detail id="ipad"]
function booqable_detail_bb($params) {
  $options = shortcode_atts(array(
    'id' => NULL
  ), $params);

  return '<div class="booqable-product-detail" ' . shortcode_options_to_data($options) . '></div>';
}
add_shortcode('booqable_detail', 'booqable_detail_bb');

// BBcode for embedding a product list
// [booqable_list]
// [booqable_list tags="tablets"]
function booqable_list_bb($params) {
  $options = shortcode_atts(array(
    'tags'        => NULL,
    'per'         => NULL,
    'limit'       => NULL,
    'show-search' => NULL,
    'search-key'  => NULL
  ), $params);

  return '<div class="booqable-product-list" ' . shortcode_options_to_data($options) . '></div>';
}
add_shortcode('booqable_list', 'booqable_list_bb');

// BBcode for embedding a product search
// [booqable_search]
// [booqable_search search-key="only-tablets"]
function booqable_search_bb($params) {
  $options = shortcode_atts(array(
    'search-key'  => NULL,
  ), $params);

  return '<div class="booqable-product-search" ' . shortcode_options_to_data($options) . '></div>';
}
add_shortcode('booqable_search', 'booqable_search_bb');

?>
