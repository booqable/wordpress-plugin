<?php
  /**
   * @wordpress-plugin
   * Plugin Name: Booqable Rental Plugin
   * Description: Rental plugin for WordPress. Turn your website into a complete online rental store by connecting your Booqable account to WordPress.
   * Author: Booqable Rental Software
   * Version: 2.4.19
   * Author URI: https://booqable.com
   * Copyright: 2023 Booqable
   */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

//
// Admin
//

// Include admin settings page
function booqable_admin() {
  include('admin/booqable_admin.php');
}

function booqable_admin_actions() {
  add_options_page("Booqable", "Booqable", 'administrator', "Booqable", "booqable_admin");
}

function admin_resources($hook) {
  // Load only on ?page=mypluginname
  if($hook != 'settings_page_Booqable') {
    return;
  }
  wp_enqueue_style( 'booqable-admin', plugins_url('assets/booqable-admin.css', __FILE__) );
}

function admin_settings_link($links) {
  $settings_link = '<a href="options-general.php?page=Booqable">' . __( 'Settings' ) . '</a>';
  array_unshift( $links, $settings_link );
  return $links;
}

function admin_notice() {
  global $hook_suffix;

  if ( in_array( $hook_suffix, array( 'jetpack_page_akismet-key-config', 'settings_page_akismet-key-config' ) ) ) {
    // This page manages the notices and puts them inline where they make sense.
    return;
  }

  if ( $hook_suffix == 'plugins.php' && trim(get_option('booqable_company_name')) == false ) {
    include('admin/booqable_notice.php');
  }
}

//
// Assets
//

// Load client script
function add_booqable_js() {
  $asset_url = 'https://' . esc_attr(get_option('booqable_company_name')) . '.assets.booqable.com/v2/booqable.js';
  wp_enqueue_script('booqable_v2', $asset_url, array(), '2.0.0', true);
}

// Insert client configuration
function add_booqable_client_configuration_js() {
  ?>
  <script>var booqableOptions = { company: '<?php echo esc_attr(get_option('booqable_company_name')); ?>', storeProvider: 'wordpress' };</script>
  <?php
}

//
// BBcodes
//

// Convert shortcode options to data-{key}={value}
function shortcode_options_to_data($options) {
  $data = implode(' ', array_map(
    function ($v, $k) {
      if (! empty($v)) {
        return sprintf("data-%s=\"%s\"", $k, esc_attr($v));
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

// BBcode for embedding a product button
// [booqable_button id="ipad"]
function booqable_button_bb($params) {
  $options = shortcode_atts(array(
    'id' => NULL
  ), $params);

  return '<div class="booqable-product-button" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding a product detail view
// [booqable_detail id="ipad"]
function booqable_detail_bb($params) {
  $options = shortcode_atts(array(
    'id' => NULL
  ), $params);

  return '<div class="booqable-product-detail" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding a product list
// [booqable_list]
// [booqable_list tags="tablets"]
// [booqable_list collections="apple"]
function booqable_list_bb($params) {
  $options = shortcode_atts(array(
    'tags'        => NULL,
    'categories'  => NULL,
    'collections' => NULL,
    'per'         => NULL,
    'limit'       => NULL,
    'show-search' => NULL,
    'search-key'  => NULL
  ), $params);

  return '<div class="booqable-product-list" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding a product search
// [booqable_search]
// [booqable_search search-key="only-tablets"]
function booqable_search_bb($params) {
  $options = shortcode_atts(array(
    'search-key'  => NULL
  ), $params);

  return '<div class="booqable-product-search" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for datepicker
// [booqable_datepicker]
function booqable_datepicker_bb($params) {
  $options = shortcode_atts(array(), $params);

  return '<div class="booqable-datepicker" ' . shortcode_options_to_data($options) . '></div>';
}
add_shortcode('booqable_datepicker', 'booqable_datepicker_bb');

// BBcode for embedding a cart button
// [booqable_cart_button]
function booqable_cart_button_bb($params) {
  $options = shortcode_atts(array(
    'href'  => NULL
  ), $params);

  return '<div class="booqable-cart-button" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding the embeddable cart
// [booqable_embeddable_cart]
function booqable_embeddable_cart_bb($params) {
  return '<div class="booqable-embeddable-cart"></div>';
}

// BBcode for embedding the embeddable cart lines
// [booqable_embeddable_cart_lines]
function booqable_embeddable_cart_lines_bb($params) {
  $options = shortcode_atts(array(
    'compact'  => NULL
  ), $params);

  return '<div class="booqable-embeddable-cart-lines" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding the embeddable cart sidebar
// [booqable_embeddable_cart_sidebar]
function booqable_embeddable_cart_sidebar_bb($params) {
  $options = shortcode_atts(array(
    'continue-shopping'  => NULL,
    'datepicker' => NULL
  ), $params);

  return '<div class="booqable-embeddable-cart-sidebar" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding a sidebar with datepicker and collections
// [booqable_sidebar]
function booqable_sidebar_bb($params) {
  return '<div class="booqable-sidebar"></div>';
}

// BBcode for embedding a sorting select
// [booqable_sort]
// [booqable_sort search-key="only-tablets"]
function booqable_sort_bb($params) {
  $options = shortcode_atts(array(
    'search-key'  => NULL
  ), $params);

  return '<div class="booqable-sort" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding a bar with search and sorting select
// [booqable_bar]
// [booqable_bar search-key="only-tablets"]
function booqable_bar_bb($params) {
  $options = shortcode_atts(array(
    'search-key'  => NULL,
  ), $params);

  return '<div class="booqable-bar" ' . shortcode_options_to_data($options) . '></div>';
}

// DEPRECATED: Please use [booqable_collection] instead
// BBcode for embedding a category list
// [booqable_categories]
function booqable_categories_bb($params) {
  $options = shortcode_atts(array(
    'search-key'  => NULL
  ), $params);

  return '<div class="booqable-categories" ' . shortcode_options_to_data($options) . '></div>';
}

// BBcode for embedding a collection list
// [booqable_collection]
function booqable_collections_bb($params) {
  return '<div class="booqable-collections"></div>';
}


function initialize() {
  add_action('admin_menu', 'booqable_admin_actions');
  add_action('admin_notices', 'admin_notice');
  add_action('admin_enqueue_scripts', 'admin_resources');

  $plugin = plugin_basename( __FILE__ );
  add_filter("plugin_action_links_$plugin", 'admin_settings_link' );

  add_action('wp_enqueue_scripts', 'add_booqable_js');
  add_action('wp_head', 'add_booqable_client_configuration_js');

  add_shortcode('booqable_card', 'booqable_card_bb');
  add_shortcode('booqable_button', 'booqable_button_bb');
  add_shortcode('booqable_product', 'booqable_button_bb');
  add_shortcode('booqable_detail', 'booqable_detail_bb');
  add_shortcode('booqable_list', 'booqable_list_bb');
  add_shortcode('booqable_search', 'booqable_search_bb');
  add_shortcode('booqable_cart_button', 'booqable_cart_button_bb');
  add_shortcode('booqable_embeddable_cart', 'booqable_embeddable_cart_bb');
  add_shortcode('booqable_embeddable_cart_sidebar', 'booqable_embeddable_cart_sidebar_bb');
  add_shortcode('booqable_embeddable_cart_lines', 'booqable_embeddable_cart_lines_bb');
  add_shortcode('booqable_sidebar', 'booqable_sidebar_bb');
  add_shortcode('booqable_sort', 'booqable_sort_bb');
  add_shortcode('booqable_bar', 'booqable_bar_bb');
  add_shortcode('booqable_categories', 'booqable_categories_bb');
  add_shortcode('booqable_collections', 'booqable_collections_bb');
}
initialize();

?>
