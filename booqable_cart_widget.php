<?php
  class BooqableCartWidget extends WP_Widget {

    public function __construct() {
      parent::__construct(
        'booqable_cart_widget', // Base ID
        __( 'Booqable Cart', 'text_domain' ), // Name
        array( 'description' => __( 'Display a cart', 'text_domain' ), ) // Args
      );
    }

    public function widget( $args, $instance ) {
      echo '<div id="booqable-cart-component" class="widget"
        data-checkout-url="' . $instance['checkout_url'] . '"
        data-label="' . $instance['button_label'] . '"
      ></div>';
    }

    public function form( $instance ) {
      $checkout_url = ! empty( $instance['checkout_url'] ) ? $instance['checkout_url'] : __( '', 'text_domain' );
      $button_label = ! empty( $instance['button_label'] ) ? $instance['button_label'] : __( '', 'text_domain' );
      ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'checkout_url' ); ?>"><?php _e( 'Chekcout url:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'checkout_url' ); ?>" name="<?php echo $this->get_field_name( 'checkout_url' ); ?>" type="text" value="<?php echo esc_attr( $checkout_url ); ?>">
      </p>
      <p class="description">Leave blank to use the Booqable hosted checkout</p>

      <p>
        <label for="<?php echo $this->get_field_id( 'button_label' ); ?>"><?php _e( 'Button label:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'button_label' ); ?>" name="<?php echo $this->get_field_name( 'button_label' ); ?>" type="text" value="<?php echo esc_attr( $button_label ); ?>">
      </p>
      <p class="description">Defaults to checkout</p>
      <?php
    }

    public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['checkout_url'] = ( ! empty( $new_instance['checkout_url'] ) ) ? strip_tags( $new_instance['checkout_url'] ) : '';
      $instance['button_label'] = ( ! empty( $new_instance['button_label'] ) ) ? strip_tags( $new_instance['button_label'] ) : '';

      return $instance;
    }
  }
?>
