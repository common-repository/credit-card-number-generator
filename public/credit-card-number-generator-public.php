<?php

// CC Generator shortcode for widget
function ccng_get_credit_cards_number( $atts ) {

    //Get and extract shortcode parametors
    extract( shortcode_atts( array(
       'title' => __('Credit Card Number Generator', 'credit-card-number-generator')
    ), $atts ) );

	ob_start();

    //Initial widget args
    $instance = array(
        'title' => $title,
    );

    //Call generator widget
    the_widget('Credit_Card_Number_Generator_Widget', $instance, array(

        'before_widget' => '<div class="shortcode-wrapper">',

        'after_widget' => '</div>',

        'before_title' => '<h3 class="widgettitle">',

        'after_title' => '</h3>'
    ));

    $contents = ob_get_contents();

    ob_get_clean(); 

    return $contents;
}
add_shortcode('ccng_credit_cards', 'ccng_get_credit_cards_number');

// CC Validator shortcode for widget
function ccng_get_credit_cards_number_validate( $atts ) {

    //Get and extract shortcode parametors
    extract( shortcode_atts( array(
       'title' => __('Credit Card Number Validator', 'credit-card-number-generator')
    ), $atts ) );

    ob_start();

    //Initial widget args
    $instance = array(
        'title' => $title,
    );

    //Call validator widget
    the_widget('Credit_Card_Number_Validator_Widget', $instance, array(

        'before_widget' => '<div class="shortcode-wrapper">',

        'after_widget' => '</div>',

        'before_title' => '<h3 class="widgettitle">',

        'after_title' => '</h3>'
    ));

    $contents = ob_get_contents();

    ob_get_clean(); 

    return $contents;
}
add_shortcode('ccng_credit_cards_validate', 'ccng_get_credit_cards_number_validate');
?>