<?php
  if($_POST['booqable_hidden'] == 'Y') {
    //Form data sent
    $company = sanitize_text_field($_POST['booqable_company']);
    update_option('booqable_company', $company);

    ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
  } else {
    $company = get_option('booqable_company');
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
            <label for="booqable_company"><?php _e("Company" ); ?></label>
          </th>
          <td>
            <input type="text" name="booqable_company" value="<?php echo $company; ?>" size="20" class="regular-text">
            <p class="description"><?php _e(" ex: irent" ); ?></p>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'booqable_trdom' ) ?>" class="button button-primary" />
    </p>
  </form>
</div>
