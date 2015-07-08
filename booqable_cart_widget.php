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
      echo '<div id="booqable-cart-component" class="widget"></div>';
  	}

  	public function form( $instance ) {
  		?>
  		<p></p>
  		<?php
  	}

  	public function update( $new_instance, $old_instance ) {
      array();
  	}
  }

?>
