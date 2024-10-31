<?php
namespace BZLEARNDASH;

define('BZLEARNDASH_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZLEARNDASH_PRODUCT_ID',   'BZLD');
define('BZLEARNDASH_VERSION',   	'1.0');
define('BZLEARNDASH_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZLEARNDASH_PLUGIN_FILE', 'rebrand-learndash/rebrand-learndash.php');
define('BZLEARNDASH_PRO_PLUGIN_FILE', 'sfwd-lms/sfwd_lms.php');

class BZRebrandLearnDashSettings {
		
		public $pageslug 	   = 'learndash_lms_rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	=> '',
				'plugin_desc'       	=> '',
				'plugin_author'     	=> '',
				'plugin_uri'        	=> '',
				
			);
			
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			} 

			if ( is_plugin_active( 'blitz-rebrand-learndash-pro/blitz-rebrand-learndash-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
			$this->bzlearndash_activation_hooks();
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzlearndash_activation_hooks() {
		
			global $blog_id;
	
			add_filter( 'gettext', 					array($this, 'bzlearndash_update_label'), 20, 3 );
			add_filter( 'all_plugins', 				array($this, 'bzlearndash_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzlearndash_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzlearndash_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzlearndash_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzlearndash_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzlearndash_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzlearndash_hide_rebrand_from_menu'), 20, 2);
			}
			
			if(is_plugin_active(BZLEARNDASH_PRO_PLUGIN_FILE)){
				add_filter( 'admin_title', array($this, 'bzlearndash_learndashpage_title'),10,2);
			}
		}
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzlearndash_hide_rebrand_from_menu($learndashcurrent, $screen) {

			$rebranding = $this->bzlearndash_get_rebranding();

			$learndashcurrent .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';
			

			if($this->bzlearndash_getOption( 'rebrand_learndash_screen_option','' )){
				
				$cartflows_screen_option = $this->bzlearndash_getOption( 'rebrand_learndash_screen_option',''); 
				
				if($cartflows_screen_option == 'show'){

					$learndashcurrent .='Hide the "'.$rebranding['plugin_name'].' - Rebrand" menu item?' .$hide;
					$learndashcurrent .= '<style>#adminmenu .toplevel_page_learndash_lms a[href="admin.php?page='.$this->pageslug.'"]{display:block;}</style>';
				} else {
					$learndashcurrent .='Show the "'.$rebranding['plugin_name'].' - Rebrand" menu item?' .$show;
					$learndashcurrent .= '<style>#adminmenu .toplevel_page_learndash_lms a[href="admin.php?page='.$this->pageslug.'"]{display:none;}</style>';
				}		
				
			} else {
					$learndashcurrent .='Hide the "'.$rebranding['plugin_name'].' - Rebrand" menu item?' .$hide;
					$learndashcurrent .= '<style>#adminmenu .toplevel_page_learndash_lms a[href="admin.php?page='.$this->pageslug.'"]{display:block;}</style>';
			}	

			$learndashcurrent .=' <br/><br/> </fieldset>' ;
			
			return $learndashcurrent;
		}
				
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzlearndash_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzlearndash_css', plugins_url('assets/css/bzlearndash-main.css', __FILE__) );
					wp_enqueue_style( 'bzlearndash_css' );
					
					wp_register_script( 'bzlearndash_js', plugins_url('assets/js/bzlearndash-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzlearndash_js' );
			
					
				}
			}
		}
		

	   	public function bzlearndash_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'learndash_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'learndash_rebrand');	
				}
			}
			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzlearndash_render_fields() {
			
			$branding = get_option( 'learndash_rebrand');
			include BZLEARNDASH_BASE_DIR . 'admin/bzlearndash-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		public function bzlearndash_menu() {
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzlearndash');
			$rebranding = $this->bzlearndash_get_rebranding();

			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzlearndash_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'admin_menu', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'admin_menu', $title, $title, $cap, $slug, $func );
				}
			}
			
			$submenu['edit.php?post_type=sfwd-assignment'][12] = array("Rebrand","learndash_lms_rebrand","Rebrand");

			foreach($menu as $custommenusK => $custommenusv ) {
				
				if($custommenusv[2] == 'learndash-lms'){
					if( isset($rebranding['learndash_menu_icon']) && $rebranding['learndash_menu_icon'] != '' ) {
						$menu[$custommenusK][6] = $rebranding['learndash_menu_icon']; // Change menu Icon
					}
				}
			}

			return $menu;
		}
		
		/**
		 * Renders to fields
		*/
		public function bzlearndash_render() {
			
			$this->bzlearndash_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzlearndash_save_settings() {
			
			if ( ! isset( $_POST['learndash_wl_nonce'] ) || ! wp_verify_nonce( $_POST['learndash_wl_nonce'], 'learndash_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['learndash_submit'] ) ) {
				return;
			}
			$this->bzlearndash_update_branding();
		}
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzlearndash_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzlearndash_get_rebranding();
			
			//~ echo '<pre/>';
			//~ print_r($rebranding);
			
			
			echo '<style id="learndash-wl-admin-style">';
			include BZLEARNDASH_BASE_DIR . 'admin/bzlearndash-style.css.php';
			echo '</style>';
			
			echo '<script id="learndash-wl-admin-script">';
			include BZLEARNDASH_BASE_DIR . 'admin/bzlearndash-script.js.php';
			echo '</script>';
		}
		

		/**
		 * Update branding
		*/
	    public function bzlearndash_update_branding() {
			
			if ( ! isset($_POST['learndash_wl_nonce']) ) {
				return;
			}  
			

			$data = array(
				'plugin_name'       => isset( $_POST['learndash_wl_plugin_name'] ) ? sanitize_text_field( $_POST['learndash_wl_plugin_name'] ) : '',
				
				'plugin_desc'       => isset( $_POST['learndash_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['learndash_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['learndash_wl_plugin_author'] ) ? sanitize_text_field( $_POST['learndash_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['learndash_wl_plugin_uri'] ) ? sanitize_text_field( $_POST['learndash_wl_plugin_uri'] ) : '',
				
			);
				
			update_option( 'learndash_rebrand', $data );
		}
  
		
		/**
		 * change plugin meta
		*/  
        public function bzlearndash_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['sfwd-lms/sfwd_lms.php'] ) ) {
				return $all_plugins;
			}
		
			$rebranding = $this->bzlearndash_get_rebranding();
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['sfwd-lms/sfwd_lms.php']['Name'];
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['sfwd-lms/sfwd_lms.php']['PluginURI'];
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['sfwd-lms/sfwd_lms.php']['Description'];
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['sfwd-lms/sfwd_lms.php']['Author'];
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['sfwd-lms/sfwd_lms.php']['AuthorURI'];
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['sfwd-lms/sfwd_lms.php']['Title'];
			
			$all_plugins['sfwd-lms/sfwd_lms.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['sfwd-lms/sfwd_lms.php']['AuthorName'];
			
			
			if(is_plugin_active(BZLEARNDASH_PRO_PLUGIN_FILE)){
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['sfwd-lms/sfwd_lms.php']['Name'];
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['sfwd-lms/sfwd_lms.php']['PluginURI'];
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['sfwd-lms/sfwd_lms.php']['Description'];
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['sfwd-lms/sfwd_lms.php']['Author'];
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['sfwd-lms/sfwd_lms.php']['AuthorURI'];
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['sfwd-lms/sfwd_lms.php']['Title'];
				
				$all_plugins['sfwd-lms/sfwd_lms.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['sfwd-lms/sfwd_lms.php']['AuthorName'];
								
			}
			
			return $all_plugins;			
		}    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzlearndash_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzlearndash_get_rebranding();
			
			$bzlearndash_new_text = $translated_text;
			$bzlearndash_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			if ( ! empty( $bzlearndash_name ) ) {

				if( is_plugin_active(BZLEARNDASH_PRO_PLUGIN_FILE) ) {
					
					$bzlearndash_new_text = str_replace( array( 'LearnDash Pro','LearnDash Pro', 'WP LearnDash', 'LearnDash LMS','LearnDash LMS','LearnDash', 'LearnDash Bootcamp' ), $bzlearndash_name, $bzlearndash_new_text );
					
				} else {
					
					$bzlearndash_new_text = str_replace( array('LearnDash Pro','LearnDash Pro', 'WP LearnDash', 'LearnDash LMS','LearnDash LMS','LearnDash', 'LearnDash Bootcamp'), $bzlearndash_name, $bzlearndash_new_text );
				}
				
			}
			
			return $bzlearndash_new_text;
		}
	
		   
		/**
		 * update options
		*/
		public function bzlearndash_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
	
		
		   
		/**
		 * get options
		*/	
		public function bzlearndash_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}	
		
		
		   
		/**
		 * get options
		*/	
		public function bzlearndash_learndashpage_title($admin_title, $title) {
			
			$rebranding = $this->bzlearndash_get_rebranding();
			$new_title = str_replace( array( 'LearnDash','LearnDash Pro','LearnDash','LearnDash LMS', 'LearnDash Bootcamp' ), $rebranding['plugin_name'], $title );
			return $new_title;
			
		}
} //end Class
