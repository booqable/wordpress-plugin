<?php
    /*
    Plugin Name: Booqable online rental shop
    Description: Enables your customers to make rental reservations from your website by Connecting Wordpress to the Booqable Reservation Software. Reservations are securely stored in the Booqable backoffice app.
    Author: Johan van Zonneveld
    Version: 2.0.0
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

// Media buttons
function add_booqable_media_buttons( $editor_id ) {
	?>
	<button id="secp-add-shortcode" class="button secp-add-shortcode" data-editor-id="<?php echo esc_attr( $editor_id ); ?>">
		<?php esc_html_e( 'Add Booqable Component', 'add-booqable-component' ); ?>
	</button>
	<?php
}
add_action( 'media_buttons', 'add_booqable_media_buttons' );

// Insert client configuration

function add_booqable_client_configuration_js() {
  ?>
  <script>
    var booqableOptions = {
      company: '<?php echo get_option('booqable_company'); ?>'
    };
  </script>
  <?php
}

add_action('wp_head', 'add_booqable_client_configuration_js');

// Company url function

function booqable_company_url() {
  $slug = get_option('booqable_company');
  $slug = sanitize_title_with_dashes($slug, null, 'save');

  return 'https://' . $slug . '.booqable.shop';
}

// Add BBcode function

function booqable_product_bb($params) {

  // default parameters
  extract(shortcode_atts(array(
    'id' => ''
  ), $params));

  return '<div class="booqable-product" data-id="' . $id . '"></div>';
}

function booqable_product_button_bb($params) {

  // default parameters
  extract(shortcode_atts(array(
    'id' => ''
  ), $params));

  return '<div class="booqable-product-button" data-id="' . $id . '"></div>';
}

function booqable_product_detail_bb($params) {

  // default parameters
  extract(shortcode_atts(array(
    'id' => ''
  ), $params));

  return '<div class="booqable-product-detail" data-id="' . $id . '"></div>';
}

function booqable_product_list_bb($params) {

  // default parameters
  extract(shortcode_atts(array(
    'tags' => ''
  ), $params));

  return '<div class="booqable-product-list" data-tags="' . $tags . '"></div>';
}

?>
