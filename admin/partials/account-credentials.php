<?php
// to check whether accessed directly
if (!defined('ABSPATH')) {
	exit;
}

$api_key = get_option( 'tfm_api_key' );
$company_name = get_option( 'tfm_company_name' );
$company_id = get_option( 'tfm_company_id' );

$status_connected = false;
if (!empty($api_key) && !empty($company_name) && !empty($company_id)) {
	$status_connected = true;
}

?>
<tr valign="top">
	<td class="tab-account-credentials">

		<div class="wrap">
		    <div class="meta-box-sortables ui-sortable">
		        
		        <div class="postbox left-col" id="p1">
		            <h3 class="hndle"><?php _e('Connection Details', $this->plugin_name); ?></h3>
		            <div class="container">
		                <div class="inside">
							
							<table class="form-table tfm-form">
									<tbody>

										<tr>
								           <td>
								           		<label for="tfm_form_api_key"><?php _e('API Key', $this->plugin_name); ?> 
													<span class="dashicons dashicons-editor-help" title="<?php _e('Your API Key', $this->plugin_name); ?>"></span>
												</label>
												<input type="text" id="tfm_form_api_key" class="tfm_form_api_key" name="api_key" value="<?php echo !empty($api_key) ? $api_key : ''; ?>">
											</td>
										</tr>
										<tr>
								           <td>
								           		<label for="tfm_form_company_name"><?php _e('Company Name', $this->plugin_name); ?> 
													<span class="dashicons dashicons-editor-help" title="<?php _e('Your Company Name', $this->plugin_name); ?>"></span>
												</label>
												<input type="text" id="tfm_form_company_name" class="tfm_form_company_name" name="company_name" value="<?php echo !empty($company_name) ? $company_name : ''; ?>">
											</td>
										</tr>
										<tr>
								           <td>
								           		<label for="tfm_form_company_id"><?php _e('Company Id', $this->plugin_name); ?> 
													<span class="dashicons dashicons-editor-help" title="<?php _e('Your Company Id', $this->plugin_name); ?>"></span>
												</label>
												<input type="text" id="tfm_form_company_id" class="tfm_form_company_id" name="company_id" value="<?php echo !empty($company_id) ? $company_id : ''; ?>">
											</td>
										</tr>
										<tr>
								           <td>
								           		<input name="save" type="button" class="button button-primary button-large" id="button-save-tfm-form" value="<?php _e('Save', $this->plugin_name); ?>">
								           		<div class="loader" style="display:none;text-align: right;"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/ajax-loader.gif'; ?>" /></div>
											</td>
										</tr>

									</tbody>
								</table>
										
						</div>
		            </div>
		        </div><!-- .postbox -->

		        <div class="postbox right-col" id="p2">
		            <h3 class="hndle"><?php _e('Connection Status', $this->plugin_name); ?></h3>
		            <div class="container">
		                <div class="message" <?php echo $status_connected ? 'style="display: none;"' : ''; ?>><?php _e('Enter Credentials.', $this->plugin_name); ?></div>
		                <div class="error inline message" style="display: none;"><p><strong><i class="fa fa-close" aria-hidden="true"></i></strong> <span></span></p></div>
		                <div class="updated inline message" <?php echo !$status_connected ? 'style="display: none;"' : ''; ?>><p><strong><i class="fa fa-check" aria-hidden="true"></i></strong> <?php _e('Connected to Woocommerce', $this->plugin_name); ?></p></div>
		            </div>
		        </div><!-- .postbox -->

		    </div><!-- .meta-box-sortables.ui-sortable-->
		  </div><!-- .wrap -->	
	</td>
</tr>