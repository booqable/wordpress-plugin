<?php
  if($_POST['booqable_hidden'] == 'Y') {
    //Form data sent
    $company_name = sanitize_text_field($_POST['booqable_company_name']);
    update_option('booqable_company_name', $company_name);

    $booqable_add_button_label = sanitize_text_field($_POST['booqable_add_button_label']);
    update_option('booqable_add_button_label', $booqable_add_button_label);

    $booqable_added_button_label = sanitize_text_field($_POST['booqable_added_button_label']);
    update_option('booqable_added_button_label', $booqable_added_button_label);

    // Don't process values that aren't boolean

    $show_prices = strtolower($_POST['booqable_show_prices']);
    if (in_array($show_prices, array("true", "false", "1", "0", "yes", "no"), true)) {
      $show_prices = $_POST['booqable_show_prices'];
    } else {
      $show_prices = '';
    }

    update_option('booqable_show_prices', $show_prices);
    ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
  } else {
    $company_name = get_option('booqable_company_name');
    $booqable_add_button_label = get_option('booqable_add_button_label');
    $booqable_added_button_label = get_option('booqable_added_button_label');
    $show_prices = get_option('booqable_show_prices');
  }
?>

<div class="wrap">
  <?php    echo "<h2>" . __( 'Booqable Options', 'booqable_trdom' ) . "</h2>"; ?>

  <form name="booqable_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="booqable_hidden" value="Y">
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">
            <label for="booqable_company_name"><?php _e("Company name" ); ?></label>
          </th>
          <td>
            <input type="text" name="booqable_company_name" value="<?php echo $company_name; ?>" size="20" class="regular-text">
            <p class="description"><?php _e(" ex: irent" ); ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label for="booqable_add_button_label"><?php _e("Add to cart button label" ); ?></label>
          </th>
          <td>
            <input type="text" name="booqable_add_button_label" value="<?php echo $booqable_add_button_label; ?>" size="20" class="regular-text">
            <p class="description"><?php _e(" ex: Add to cart" ); ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label for="booqable_added_button_label"><?php _e("Added to cart button label" ); ?></label>
          </th>
          <td>
            <input type="text" name="booqable_added_button_label" value="<?php echo $booqable_added_button_label; ?>" size="20" class="regular-text">
            <p class="description"><?php _e(" ex: Added. Go to cart" ); ?></p>
          </td>
        </tr>
        <!-- <tr>
          <th scope="row">
            <label for="booqable_show_prices"><?php _e("Show prices" ); ?></label>
          </th>
          <td>
            <select name="booqable_show_prices">
              <option value="true" <?php if ($show_prices == "true") { echo "selected"; } ?>>Yes</option>
              <option value="false" <?php if ($show_prices == "false") { echo "selected"; } ?>>No</option>
            </select>
          </td>
        </tr> -->
      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'booqable_trdom' ) ?>" class="button button-primary" />
    </p>
  </form>
</div>
