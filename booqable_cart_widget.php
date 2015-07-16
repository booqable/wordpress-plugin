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
        data-checkout-button-label="' . $instance['checkout_button_label'] . '"
        data-information-text="' . $instance['information_text'] . '"
        data-cart-empty-text="' . $instance['cart_empty_text'] . '"
      ></div>';
    }

    public function form( $instance ) {
      $checkout_url = ! empty( $instance['checkout_url'] ) ? $instance['checkout_url'] : __( '', 'text_domain' );
      $checkout_button_label = ! empty( $instance['checkout_button_label'] ) ? $instance['checkout_button_label'] : __( 'Checkout', 'text_domain' );
      $information_text = ! empty( $instance['information_text'] ) ? $instance['information_text'] : __( 'You have {count} products in your cart', 'text_domain' );
      $cart_empty_text  = ! empty( $instance['cart_empty_text'] ) ? $instance['cart_empty_text'] : __( 'Your cart is empty', 'text_domain' );
      ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'checkout_url' ); ?>"><?php _e( 'Chekcout url:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'checkout_url' ); ?>" name="<?php echo $this->get_field_name( 'checkout_url' ); ?>" type="text" value="<?php echo esc_attr( $checkout_url ); ?>" placeholder="Leave blank to use the Booqable hosted checkout...">
      </p>

      <p>
        <label for="<?php echo $this->get_field_id( 'checkout_button_label' ); ?>"><?php _e( 'Checkout button label:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'checkout_button_label' ); ?>" name="<?php echo $this->get_field_name( 'checkout_button_label' ); ?>" type="text" value="<?php echo esc_attr( $checkout_button_label ); ?>">
      </p>

      <p>
        <label for="<?php echo $this->get_field_id( 'information_text' ); ?>"><?php _e( 'Information text:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'information_text' ); ?>" name="<?php echo $this->get_field_name( 'information_text' ); ?>" type="text" value="<?php echo esc_attr( $information_text ); ?>">
      </p>

      <p>
        <label for="<?php echo $this->get_field_id( 'cart_empty_text' ); ?>"><?php _e( 'Cart empty text:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'cart_empty_text' ); ?>" name="<?php echo $this->get_field_name( 'cart_empty_text' ); ?>" type="text" value="<?php echo esc_attr( $cart_empty_text ); ?>">
      </p>
      <?php
    }

    public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['checkout_url'] = ( ! empty( $new_instance['checkout_url'] ) ) ? strip_tags( $new_instance['checkout_url'] ) : '';
      $instance['checkout_button_label'] = ( ! empty( $new_instance['checkout_button_label'] ) ) ? strip_tags( $new_instance['checkout_button_label'] ) : 'Checkout';
      $instance['information_text'] = ( ! empty( $new_instance['information_text'] ) ) ? strip_tags( $new_instance['information_text'] ) : 'You have {count} products in your cart';
      $instance['cart_empty_text'] = ( ! empty( $new_instance['cart_empty_text'] ) ) ? strip_tags( $new_instance['cart_empty_text'] ) : 'Your cart is empty';

      return $instance;
    }
  }
?>
