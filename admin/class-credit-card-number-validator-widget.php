<?php

class Credit_Card_Number_Validator_Widget extends WP_Widget {

	// Class Constructor
	function __construct() {

		parent::__construct(

			// widget ID
			'Credit_Card_Number_Validator_Widget',

			// widget name
			__('Credit Card Number Validator', 'credit-card-number-generator'),

			// widget description
			array( 'description' => __( 'Simple widget for Credit Card Number Validator', 'credit-card-number-generator' ), )
		);
	}

	// Function for widget output
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

		//if title is present
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		//sub title
		echo apply_filters( 'ccng_validator_sub_title', __( 'Please credit card number to validate.', 'credit-card-number-generator' ) );

		//Get details
		$txtPHValid = get_option( 'CCNG_validate_input_ph' );
		$txtPHValid = trim($txtPHValid) != '' ? $txtPHValid : __( 'Enter credit card number', 'credit-card-number-generator' );
		$txtValidInput = get_option( 'CCNG_validate_btn_txt' );
		$txtValidInput = trim($txtValidInput) != '' ? $txtValidInput : __( 'Validate', 'credit-card-number-generator' );
		$colorValidBtn = get_option( 'CCNG_validate_btn_color' );
		$colorValidBtn = !empty($colorValidBtn) ? $colorValidBtn : sanitize_hex_color("#000000");
		$bgcolorValidBtn = get_option( 'CCNG_validate_btn_bgcolor' );
		$bgcolorValidBtn = !empty($bgcolorValidBtn) ? $bgcolorValidBtn : sanitize_hex_color("#ffbd33");

		//Allow third party to add their content
		do_action( 'ccng_before_validator_content', $instance );
		?>
		<div class="ccng-content-wrapper">
			<ul class="cards list-unstyled">
				<li><span class="card v" title="Visa"><?php _e('Visa', 'credit-card-number-generator'); ?></span></li>
				<li><span class="card m" title="Master Card"><?php _e('Master Card', 'credit-card-number-generator'); ?></span></li>
				<li><span class="card a" title="American Express"><?php _e('American Express', 'credit-card-number-generator'); ?></span></li>
				<li><span class="card d" title="Discover"><?php _e('Discover', 'credit-card-number-generator'); ?></span></li>
				<li><span class="card j" title="JCB"><?php _e('JCB', 'credit-card-number-generator'); ?></span></li>
				<li><span class="card di" title="Diners"><?php _e('Diners', 'credit-card-number-generator'); ?></span></li>
			</ul>
			<div class="ccng-input-wrapper icn">
				<input type="text" name="ccng_card_number" class="ccng_card_number" placeholder="<?php echo $txtPHValid;?>">
			</div>
	        <button style="background-color:<?php echo esc_html($bgcolorValidBtn); ?>; color:<?php echo esc_html($colorValidBtn); ?>" class="btn-validate" title="Validate Number"><?php echo esc_html($txtValidInput); ?></button>
	        <div class="ccng_validate_message"></div>
    	</div>
        <?php

		//Allow third party to add their content
		do_action( 'ccng_after_validator_content', $instance );

		echo $args['after_widget'];
	}

	// Function for Widget form
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ];
		else
			$title = __( 'Credit Card Number Validator', 'credit-card-number-generator' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	// Function for Update widget
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

// Function for Register Widget.
function ccng_register_validator_widget() {

	register_widget( 'Credit_Card_Number_Validator_Widget' );
}

// Add action for widget register
add_action( 'widgets_init', 'ccng_register_validator_widget' );