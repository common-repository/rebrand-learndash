<div class="learndash-wl-settings-header">
	<h3>
		<?php 
		if( is_plugin_active(BZlearndash_PRO_PLUGIN_FILE) ) {
			_e('Rebrand LearnDash Pro', 'bzlearndash');
		} else {
			_e('Rebrand LearnDash', 'bzlearndash');	
		}
	
		?>
	</h3>
</div>
<div class="learndash-wl-settings-wlms">

	<div class="learndash-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'learndash_wl_nonce', 'learndash_wl_nonce' ); ?>

			<div class="learndash-wl-setting-tabs-content">

				<div id="learndash-wl-branding" class="learndash-wl-setting-tab-content active">
					<h3 class="bzlearndash-section-title"><?php esc_html_e('Branding', 'bzlearndash'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzlearndash'); ?></p>
					<table class="form-table learndash-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="learndash_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzlearndash'); ?></label>
								</th>
								<td>
									<input id="learndash_wl_plugin_name" name="learndash_wl_plugin_name" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_name']); ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="learndash_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzlearndash'); ?></label>
								</th>
								<td>
									<input id="learndash_wl_plugin_desc" name="learndash_wl_plugin_desc" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_desc']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="learndash_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzlearndash'); ?></label>
								</th>
								<td>
									<input id="learndash_wl_plugin_author" name="learndash_wl_plugin_author" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_author']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="learndash_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzlearndash'); ?></label>
								</th>
								<td>
									<input id="learndash_wl_plugin_uri" name="learndash_wl_plugin_uri" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_uri']); ?>"/>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="learndash_wl_primary_color"><?php esc_html_e('Primary Color', 'bzlearndash'); ?></label>
								</th>
								<td>
									<input id="learndash_wl_primary_color" name="learndash_wl_primary_color" type="text" class="learndash-wl-color-picker" value="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="learndash_menu_icon"><?php esc_html_e('Menu Icon', 'bzlearndash'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="learndash_menu_icon" id="learndash_menu_icon" type="text" value="" disabled />
									<input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#learndash_menu_icon" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
									
							 <tr valign="top">
									<th scope="row" valign="top">
										<label for="learndash_wl_hide_addons_menu"><?php echo esc_html_e('Hide Add-ons menu', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="learndash_wl_hide_addons_menu" name="learndash_wl_hide_addons_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
									
							<tr valign="top">
									<th scope="row" valign="top">
										<label for="learndash_wl_hide_reports_menu"><?php echo esc_html_e('Hide Reports menu', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="learndash_wl_hide_reports_menu" name="learndash_wl_hide_reports_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
									
							<tr valign="top">
									<th scope="row" valign="top">
										<label for="learndash_wl_hide_settings_menu"><?php echo esc_html_e('Hide Settings Menu', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="learndash_wl_hide_settings_menu" name="learndash_wl_hide_settings_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="learndash-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="learndash_submit" id="learndash_save_branding" class="button button-primary bzlearndash-save-button" value="<?php esc_html_e('Save Settings', 'bzlearndash'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
