<?php
/**
 * Plugin Name: 	Rebrand LearnDash
 * Plugin URI: 	    https://rebrandpress.com/rebrand-learndash
 * Description: 	The LearnDash plugin is a learning management system that allows educators to sell more online courses. Customize your LearnDash so enrollees see your colors and logo on the courses. It also allows you to rename the plugin and change the description on both the navigation menu and the site’s plugin page, replace the developer’s link, and remove any mention of LearnDash.
 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_LearnDash_Pro') ) {
	
	class Rebrand_LearnDash_Pro {
		
		public function bzlearndash_load()
		{
			global $bzlearndash_load;

			if ( !isset($bzlearndash_load) )
			{
			  require_once(__DIR__ . '/learndash-settings.php');
			  $PluginLearnDash = new BZLEARNDASH\BZRebrandLearnDashSettings;
			  $PluginLearnDash->init();
			}
			return $bzlearndash_load;
		}
		
	}
}

$PluginRebrandLearnDash = new Rebrand_LearnDash_Pro;
$PluginRebrandLearnDash->bzlearndash_load();
