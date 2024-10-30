<?php


class Credit_Card_Number_Generator_Admin {

	public function __construct() {

		// Add Admin CSS & JS
		add_action( 'admin_enqueue_scripts', array($this, 'ccng_admin_enqueue_CSS_JS'));

		// Add JS Files
		add_action('wp_head', array($this, 'ccng_hook_js'));

		// Add menu in admin setting
		add_action( 'admin_menu', array($this, 'ccng_dummy_card_plugin_menu' ));

		// Action for form edit Ajax
		add_action('wp_ajax_nopriv_wli_credit_card_edit', array($this, 'ccng_credit_card_edit_callback'));
		add_action('wp_ajax_wli_credit_card_edit', array($this, 'ccng_credit_card_edit_callback'));

		// Filter for add plugin settings link
		add_filter( 'plugin_action_links_credit-card-number-generator/credit-card-number-generator.php',  array($this,'ccng_add_action_links'));

		// Admin ajax variable
		//add_action( 'admin_head', array( $this, 'ccng_admin_global_js_vars' ) );

		// Admin footer text.
		add_filter( 'admin_footer_text', array( $this, 'ccng_admin_footer' ), 1, 2 );
	}

	// General section callback function.
	public function ccng_general_section_callback() {

		?>
		<div class="ccng-plugin-cta">
			<h2 class="ccng-heading">Thank you for downloading our plugin - Credit Card Number Generator.</h2>
			<h2 class="ccng-heading">We're here to help !</h2>
			<p>Our plugin comes with free, basic support for all users. We also provide plugin customization in case you want to customize our plugin to suit your needs.</p>
			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Free%20Support" target="_blank" class="button">Need help?</a>
			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Plugin%20Customization" target="_blank" class="button">Want to customize plugin?</a>
		</div>
		<?php
		$all_plugins = get_plugins();
		if (!(isset($all_plugins['xml-sitemap-for-google/xml-sitemap-for-google.php']))) {
			?>
				<div class="ccng-plugin-cta show-other-plugin" id="xml-plugin-banner">
					<h2 class="ccng-heading">Want to Rank Higher on Google?</h2>
					<h3 class="ccng-heading">Install <span>XML Sitemap for Google</span> Plugin</h3>
					<hr>
					<p>Our plugin comes with free, basic support for all users.</p>
					<ul class="custom-bullet">
						<li>Easy Setup and Effortless Integration</li>	
						<li>Automatic Updates</li>	
						<li>Improve Search Rankings</li>	
						<li>SEO Best Practices</li>
						<li>Optimized for Performance</li>
					</ul>						
					<br>
					<button id="open-install-ccng" class="button-install">Install Plugin</button>
				</div>
			<?php 
		}	
	}



	// Function For Include Color Picker CSS in Admin

	public function ccng_admin_enqueue_CSS_JS($hook_suffix ){

		if( is_admin() ) { 

        	// Add the color picker CSS file       
        	wp_enqueue_style( 'wp-color-picker' );

        	// Add the color picker JS file       
        	wp_enqueue_script( 'wp-color-picker' );

        	// Add Admin CSS
			wp_enqueue_style( 'ccng-admin-css',CCNG_CARD_GENERATOR_ASSESTS_URL.'admin/ccng-admin-notices.css',false,null,'all');

			// Enqueue Card JS
			wp_enqueue_script("wli-card-js",CCNG_CARD_GENERATOR_ASSESTS_URL.'js/install-plugin-ccng.js',array('jquery'),null,true);  

			add_thickbox();

        }
	}

	//Function For Include Plugin JS and CSS
	public function ccng_hook_js() {	

		global $wpdb;

		$wli_plugin_status = esc_attr(get_option( 'CCNG_DUMMY_CARD_status' ));

		if( "true" == $wli_plugin_status ) {

			// Enqueue Clipboard JS
			wp_enqueue_script("wli-clipboard-js",CCNG_CARD_GENERATOR_ASSESTS_URL.'js/clipboard.min.js',array('jquery'),null,true);


			// Enqueue Card JS
			wp_enqueue_script("wli-card-js",CCNG_CARD_GENERATOR_ASSESTS_URL.'js/wli_card.js',array('jquery'),null,true);  

			// Enqueue Card CSS
			wp_enqueue_style( 'wli-card-css',CCNG_CARD_GENERATOR_ASSESTS_URL.'css/style.css',false,null,'all');


		}
	}

	// Function for define ajax variables
	public function ccng_admin_global_js_vars() {

	    $ajax_url = 'var admin_ajax_params = {"ajax_url":"'. admin_url( 'admin-ajax.php' ) .'"};';
	    echo "<script type='text/javascript'>\n";
	    echo "/* <![CDATA[ */\n";
	    echo $ajax_url;
	    echo "\n/* ]]> */\n";
	    echo "</script>\n";
	}

	// Function for add setting menu
	public function ccng_dummy_card_plugin_menu() {

		add_options_page(
			__('Credit Card Number Generator','credit-card-number-generator'), 
			__('Credit Card Number Generator','credit-card-number-generator'),
			'manage_options',
			'wli-credit-card-generator',
			array( $this, 'ccng_card_plugin_menu_option' )
		);
	}

	// Function for admin settings page
	public function ccng_card_plugin_menu_option() {

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'Opps... You do not have sufficient permissions to access this page.', 'credit-card-number-generator' ) );
		}?>
		<div class="wrap-ccng">
			<div class="inner-ccng">
				<div class="left-box-ccng">
					<form id="wli_frm_update" method="post" action="">
					<h1 style="line-height: 32px;"><?php _e("Credit Card Number Generator",'credit-card-number-generator'); ?></h1>
						<table class="form-table">
							<tbody>
								<!-- Enable Field Start -->
								<tr>
									<th scope="row">
										<label for="WLI_plugin_status"><?php _e("Enable Plugin",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="WLI_plugin_status" type="checkbox" id="WLI_plugin_status" value="enable" <?php if("true" == esc_attr(get_option( 'CCNG_DUMMY_CARD_status' ))){ echo 'checked'; } ?>>
										<p class="description" id="wli_enable_desc"><?php _e("Uncheck this check box to disable the plugin features.",'credit-card-number-generator'); ?></p>
									</td>
								</tr><!-- Enable Field End -->

								<!-- Field Section Start -->
								<tr>
									<th scope="row" colspan="2">
										<h2><?php _e("Credit Card Generator Options",'credit-card-number-generator'); ?></h2>
									</th>
								</tr>
								<!-- Field Section End -->

								<!-- Generate button Text Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_generate_btn_txt"><?php _e("Generate Button Text",'credit-card-number-generator'); ?></label>
									</th>

									<td>
										<input name="wli_generate_btn_txt" type="text" id="wli_generate_btn_txt" value="<?php echo esc_attr(get_option( 'CCNG_generate_btn_link_text' )); ?>" class="regular-text">
										<p class="description" id="btn_text_desc"><?php _e("Enter generate button text, Leave empty if you want to display default text \"Generate\".",'credit-card-number-generator'); ?></p>
									</td>
								</tr><!-- Generate button Text Field End -->

								<!-- Generate button Text Color Start -->
								<tr>
									<th scope="row">
										<label for="ccng_generate_btn_txt_color"><?php _e("Generate Button Text Color",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="ccng_generate_btn_txt_color" type="text" id="ccng_generate_btn_txt_color" value="<?php echo esc_attr(get_option( 'CCNG_generate_btn_txt_color' )); ?>" class="regular-text wli-color">
										<p class="description" id="btn_text_desc"><?php _e("Choose generate button text color.",'credit-card-number-generator'); ?></p>
									</td>
								</tr><!-- Generate button Text Color End -->

								<!-- Generate button Color Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_generate_btn_color"><?php _e("Generate Button Background Color",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_generate_btn_color" type="text" id="wli_generate_btn_color" value="<?php echo esc_attr(get_option( 'CCNG_generate_btn_link_color' )); ?>" class="regular-text wli-color">
										<p class="description" id="btn_color_desc"><?php _e("Choose generate button background color.",'credit-card-number-generator'); ?></p>
									</td>
								</tr>
								<!-- Generate button Color Field End -->

								<!-- Copy button Text Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_copy_btn_txt"><?php _e("Copy Button Text",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_copy_btn_txt" type="text" id="wli_copy_btn_txt" value="<?php echo esc_attr(get_option( 'CCNG_copy_btn_link_text' )); ?>" class="regular-text">
										<p class="description" id="btn_text_desc"><?php _e("Enter copy button text, Leave empty if you want to display default text \"Copy to Clipboard\".",'credit-card-number-generator'); ?></p>
									</td>
								</tr>
								<!-- Copy button Text Field End -->

								<!-- Copy button text color Field Start -->
								<tr>
									<th scope="row">
										<label for="WLI_copy_text_color"><?php _e("Copy Button Text Color",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="WLI_copy_text_color" type="text" id="WLI_copy_text_color" value="<?php echo esc_attr(get_option( 'CCNG_cpy_btn_txt_color' )); ?>" class="regular-text wli-color">
										<p class="description" id="btn_color_desc"><?php _e("Choose copy button text color.",'credit-card-number-generator'); ?></p>
									</td>
								</tr>
								<!-- Copy button text color Field End -->

								<!-- Copy button Color Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_copy_btn_color"><?php _e("Copy Button Background Color",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_copy_btn_color" type="text" id="wli_copy_btn_color" value="<?php echo esc_attr(get_option( 'CCNG_copy_btn_link_color' )); ?>" class="regular-text wli-color">
										<p class="description" id="btn_color_desc"><?php _e("Choose copy button background color.",'credit-card-number-generator'); ?></p>
									</td>
								</tr>
								<!-- Copy button Color Field End -->

								<!-- Shortcode Info. Start -->
								<tr>
									<th scope="row">
										<label><?php _e("Shortcode:",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<code>[ccng_credit_cards]</code>
										<p class="description"><?php _e("Use this shortcode to display credit card generator on any posts and pages",'credit-card-number-generator'); ?></p>
									</td>
								</tr> <!-- Shortcode Info. End -->

								<!-- Field Section Start -->
								<tr>
									<th scope="row" colspan="2">
										<h2><?php _e("Credit Card Validator Options",'credit-card-number-generator'); ?></h2>
									</th>
								</tr>
								<!-- Field Section End -->

								<!-- Validate input placeholder Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_validate_input_placeholder"><?php _e("Validate Input placeholder",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_validate_input_placeholder" type="text" id="wli_validate_input_placeholder" value="<?php echo esc_attr(get_option( 'CCNG_validate_input_ph' )); ?>" class="regular-text">
										<p class="description" id="btn_text_desc"><?php _e("Enter validate input placeholder text, Leave empty if you want to display default text \"Enter credit card number\".",'credit-card-number-generator'); ?></p>
									</td>
								</tr><!-- Validate input placeholder Field End -->

								<!-- Validate button Text Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_validate_btn_txt"><?php _e("Validate Button Text",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_validate_btn_txt" type="text" id="wli_validate_btn_txt" value="<?php echo esc_attr(get_option( 'CCNG_validate_btn_txt' )); ?>" class="regular-text">
										<p class="description" id="btn_text_desc"><?php _e("Enter validate button text, Leave empty if you want to display default text \"Validate\".",'credit-card-number-generator'); ?></p>
									</td>
								</tr><!-- Validate button Text Field End -->

								<!-- Validate button Color Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_validate_btn_color"><?php _e("Validate Button Text Color",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_validate_btn_color" type="text" id="wli_validate_btn_color" value="<?php echo esc_attr(get_option( 'CCNG_validate_btn_color' )); ?>" class="regular-text wli-color">
										<p class="description" id="btn_color_desc"><?php _e("Choose validate button text color.",'credit-card-number-generator'); ?></p>
									</td>
								</tr>
								<!-- Validate button Color Field End -->

								<!-- Validate button BG Color Field Start -->
								<tr>
									<th scope="row">
										<label for="wli_validate_btn_bgcolor"><?php _e("Validate Button Background Color",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<input name="wli_validate_btn_bgcolor" type="text" id="wli_validate_btn_bgcolor" value="<?php echo esc_attr(get_option( 'CCNG_validate_btn_bgcolor' )); ?>" class="regular-text wli-color">
										<p class="description" id="btn_color_desc"><?php _e("Choose validate button background color.",'credit-card-number-generator'); ?></p>
									</td>
								</tr>
								<!-- Validate button BG Color Field End -->

								<!-- Validator Shortcode Info. Start -->
								<tr>
									<th scope="row">
										<label><?php _e("Shortcode:",'credit-card-number-generator'); ?></label>
									</th>
									<td>
										<code>[ccng_credit_cards_validate]</code>
										<p class="description"><?php _e("Use this shortcode to display credit card validator on any posts and pages.",'credit-card-number-generator'); ?></p>
									</td>
								</tr> <!-- Validator Shortcode Info. End -->

							</tbody>
						</table>

						<?php $wli_img_loader = CCNG_CARD_GENERATOR_ASSESTS_URL.'images/settings.gif'; ?>

						<img src="<?php echo esc_url($wli_img_loader); ?>" alt="Updating..." height="42" width="50" id="wli_loder_img" style="display:none;" />

						<div class="col span_12" id="WLI_form_success" style="display: none;font-size: 14px; color:#0073aa;"></div>

						<p class="submit">
							<input type="button" name="wli_frm_submit" id="wli_frm_submit" class="button button-primary" value="<?php _e("Save Changes",'credit-card-number-generator'); ?>">
						</p>
					</form>
				</div>
				<div class="right-box-ccng">
					<?php $this->ccng_general_section_callback(); ?>
				</div>
			</div>
		</div>
		<?php
		$this->ccng_add_script();
	}

	// Function for handle admin form submission
	public function ccng_add_script() {

		//Get details
		$ajaxurl 	= admin_url('admin-ajax.php');
		$updated_message = __( 'Settings Updated Successfully!', 'credit-card-number-generator' );
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){

				// Initilize WP color picker
				jQuery('.wli-color').wpColorPicker();

				// Handle Admin Form Submission
				jQuery('#wli_frm_submit').click(function(e){

					e.preventDefault();
					jQuery('#WLI_form_success').css('display', 'none');
					jQuery('#wli_loder_img').css('display','block');
					if (jQuery('input#WLI_plugin_status').is(':checked')) { 
						var wli_plguin_state = "true";
					} else {
						var wli_plguin_state = "false";
					}

					//Get all details
					var wli_generate_btn_link_text = jQuery("#wli_generate_btn_txt").val();
					var wli_generate_btn_link_color = jQuery("#wli_generate_btn_color").val();
					var wli_copy_btn_link_text = jQuery("#wli_copy_btn_txt").val();
					var wli_copy_btn_link_color = jQuery("#wli_copy_btn_color").val();
					var ccng_generate_btn_txt_color = jQuery("#ccng_generate_btn_txt_color").val();
					var ccng_copy_btn_txt_color = jQuery("#WLI_copy_text_color").val();

					var validate_input_ph = jQuery("#wli_validate_input_placeholder").val();
					var validate_btn_txt = jQuery("#wli_validate_btn_txt").val();
					var validate_btn_color = jQuery("#wli_validate_btn_color").val();
					var validate_btn_bgcolor = jQuery("#wli_validate_btn_bgcolor").val();

					var data_string = "action=wli_credit_card_edit&WLI_plugin_status="+wli_plguin_state+"&WLI_btn_title="+wli_generate_btn_link_text+"&WLI_btn_color="+wli_generate_btn_link_color+"&WLI_copy_title="+wli_copy_btn_link_text+"&WLI_copy_color="+wli_copy_btn_link_color+"&WLI_gen_text_color="+ccng_generate_btn_txt_color+"&WLI_cpy_text_color="+ccng_copy_btn_txt_color+"&validate_input_ph="+validate_input_ph+"&validate_btn_txt="+validate_btn_txt+"&validate_btn_color="+validate_btn_color+"&validate_btn_bgcolor="+validate_btn_bgcolor;

					jQuery.ajax({

						type:    "POST",
						url:     "<?php echo $ajaxurl;?>",
						dataType: 'json',
						data:    data_string,
						// async : false,
						success: function(data){

							jQuery('#wli_loder_img').css('display','none');
							jQuery('#WLI_form_success').css('display', 'block');
							jQuery('#WLI_form_success').text('<?php echo $updated_message;?>');
						}
					}); 
				});
			});
		</script>
	<?php }

	// Function for handle ajax
	public function ccng_credit_card_edit_callback() {

		if( isset($_POST) ) {

			//Enable and Generator Options
			update_option( 'CCNG_DUMMY_CARD_status', sanitize_text_field($_POST['WLI_plugin_status']) );
			update_option( 'CCNG_generate_btn_link_text', sanitize_text_field($_POST['WLI_btn_title']) );
			update_option( 'CCNG_generate_btn_link_color', sanitize_hex_color($_POST['WLI_btn_color']) );
			update_option( 'CCNG_generate_btn_txt_color', sanitize_hex_color($_POST['WLI_gen_text_color']) );
			update_option( 'CCNG_copy_btn_link_text', sanitize_text_field($_POST['WLI_copy_title']) );
			update_option( 'CCNG_copy_btn_link_color', sanitize_hex_color($_POST['WLI_copy_color']) );
			update_option( 'CCNG_cpy_btn_txt_color', sanitize_hex_color($_POST['WLI_cpy_text_color']) );

			//Validator options
			update_option( 'CCNG_validate_input_ph', sanitize_text_field($_POST['validate_input_ph']) );
			update_option( 'CCNG_validate_btn_txt', sanitize_text_field($_POST['validate_btn_txt']) );
			update_option( 'CCNG_validate_btn_color', sanitize_hex_color($_POST['validate_btn_color']) );
			update_option( 'CCNG_validate_btn_bgcolor', sanitize_hex_color($_POST['validate_btn_bgcolor']) );

			//Return success
			return array('success' => true);
	    }

		die();
	}

	// Function for add action link
	public function ccng_add_action_links( $links_array ){

		array_unshift( $links_array, '<a href="' . admin_url( 'options-general.php?page=wli-credit-card-generator' ) . '">'. __( 'Settings', 'credit-card-number-generator' ) .'</a>' );

		return $links_array;
	}

	// When user is on a Credit Card Number Generator related admin page, display footer 
	public function ccng_admin_footer( $text ) {

		global $current_screen;

		if ( ! empty( $current_screen->id ) && strpos( $current_screen->id, 'wli-credit-card-generator' ) !== false ) {

			$url  = 'https://wordpress.org/support/plugin/credit-card-number-generator/reviews/?filter=5#new-post';

			$wpdev_url  = 'https://www.weblineindia.com/wordpress-development.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Footer%20CTA';

			$text = sprintf(
				wp_kses(
					'Please rate our plugin %1$s <a href="%2$s" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%3$s" target="_blank" rel="noopener">WordPress.org</a> to help us spread the word. Thank you from the <a href="%4$s" target="_blank" rel="noopener noreferrer">WordPress development</a> team at WeblineIndia.',
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
						),
					)
				),
				'<strong>"Credit Card Number Generator"</strong>',
				$url,
				$url,
				$wpdev_url
			);
		}

		return $text;
	}
}

// Class Obj.
new Credit_Card_Number_Generator_Admin;
?>