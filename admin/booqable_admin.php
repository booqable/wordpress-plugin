<?php
  if($_POST['booqable_hidden'] == 'Y') {
    //Form data sent
    $company = sanitize_text_field($_POST['booqable_company_name']);
    update_option('booqable_company_name', $company);

    ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
  } else {
    $company = get_option('booqable_company_name');
  }
?>

<div class="wrap bq-admin-wrap">
  <div class="card bq-admin-header">
    <div class="bq-admin-pull-left">
      <img src="<?php echo esc_url( plugins_url( '../assets/logo.png', __FILE__ ) ); ?>" alt="Booqable" />
    </div>
    <div class="bq-admin-pull-right">
      <a href="https://help.booqable.com/" target="_blank" rel="noopener" class="button bq-admin-help">Help</a>
    </div>
  </div>

  <div class="card">
    <h2><?php _e("1. Connect to your Booqable account"); ?></h2>
    <p class="bq-admin-subtitle"><?php _e("Don't have a Booqable account? <a href=\"https://signup.booqable.com/\" target=\"_blank\" rel=\"noopener\">Get started for free</a>."); ?></p>
    <hr />
    <form name="booqable_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <input type="hidden" name="booqable_hidden" value="Y">
      <table class="form-table">
        <tbody>
          <tr>
            <th scope="row">
              <label for="booqable_company_name"><?php _e("Company ID"); ?></label>
            </th>
            <td>
              <input type="text" name="booqable_company_name" value="<?php echo $company; ?>" size="20" class="regular-text">
              <p class="description"><?php _e("Find your <b>Company ID</b> in your Booqable account under <b>Settings > Online reservations > Installation > WordPress plugin</b>" ); ?></p>
            </td>
          </tr>
        </tbody>
      </table>

      <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'booqable_trdom') ?>" class="button button-primary" />
      </p>
    </form>
  </div>

  <div class="card">
      <h2><?php _e("2. Add your products"); ?></h2>
      <p class="bq-admin-subtitle"><?php _e("To get started, simply <b>copy</b> and <b>paste</b> this shortcode to any <b>Page</b> or <b>Post</b>."); ?></p>
      <hr />
      <table class="form-table">
        <tbody>
          <tr>
            <th scope="row">
              <label for="embed_code"><?php _e("Embed all products" ); ?></label>
            </th>
            <td>
              <code>[booqable_list]</code>
            </td>
          </tr>
        </tbody>
      </table>
      <a href="https://help.booqable.com/online-reservations/wordpress/showing-products-on-your-wordpress-site" target="_blank" rel="noopener"><?php _e("More embed options"); ?></a>
  </div>

  <div class="card">
    <h2><?php _e("3. Customize your online store"); ?></h2>
    <p class="bq-admin-subtitle"><?php _e("Configure branding, rental periods, opening hours, online payments and more."); ?></p>
    <hr />
    <a href="https://help.booqable.com/online-reservations" target="_blank" rel="noopener"><?php _e("Customize online store"); ?></a>
  </div>
</div>
