<?php
// to check whether accessed directly
if (!defined('ABSPATH')) {
	exit;
}
?>
<tr valign="top">
	<td class="tab-setup-account">
		<div class="images-holder">
			<div class="first image-item"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/woocommerce-logo.png'; ?>"></div>

			<div class="second image-item">
				<div class="inner"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/arrow.png'; ?>"></div>
			</div>

			<div class="third image-item"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/the-fill-mill-logo.png'; ?>"></div>
		</div>	
		<h3><?php _e('Thanks for installing The Fill Mill plugin.', $this->plugin_name); ?></h3>
		<p class="sublines"><?php _e('We\'re excited to be your fulfillment partner!', $this->plugin_name); ?><br>
		<?php _e('The first step is to set up your free account.', $this->plugin_name); ?></p>

		<p class="button-holder">
			<a href="https://thefillmill.com/setup-account" target="_blank" class="button-primary woocommerce-save-button"><?php _e('Setup account', $this->plugin_name); ?></a>
		</p>

		<p class="last-line"><?php _e('Once you\'re set up, enter the credentials provided in the "Credentials" tab above', $this->plugin_name); ?></p>
	</td>
</tr>