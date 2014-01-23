<?php
/*
Plugin Name: What Template Am I Using
Description: This plugin is intended for theme developers to use. It shows the current template being used to render the page, current post type, and much more.
Author: Eric King
Version: 0.1.4
Author URI: http://webdeveric.com/
*/

// This plugin only needs to run on the front end of the site.
if( is_admin() )
	return;

class What_Template_Am_I_Using {

	const VERSION = '0.1.4';

	public static function init(){
		add_action('init', array( __CLASS__, 'setup' ) );
	}

	public static function setup(){
		if( current_user_can( 'edit_theme_options' ) ){
			self::enqueue_assets();
			add_action('wp_footer', array( __CLASS__, 'output' ) );
		}
	}

	public static function enqueue_assets(){
		wp_enqueue_style('what-template-am-i-using', plugins_url( '/css/what-template-am-i-using.css', __FILE__ ), array(), self::VERSION );
		wp_enqueue_script('what-template-am-i-using', plugins_url( '/js/what-template-am-i-using.js', __FILE__ ), array('jquery'), self::VERSION, true );
		
	}

	public static function output(){

		global $template, $post;

		$data = array(
			'Template'		=> str_replace( get_theme_root(), '', $template ),
			'Post Type'		=> isset( $post, $post->post_type ) ? $post->post_type : 'not set',
			'Front Page'	=> is_front_page() ? 'Yes' : 'No',
			'Home Page'		=> is_home() ? 'Yes' : 'No',
			'Server IP'		=> $_SERVER['SERVER_ADDR']
		);

		$data = apply_filters('what_template_am_i_using_data', $data );

		?>

		<div id="what-template-am-i-using">
			<a id="what-template-am-i-using-handle" title="Click to toggle"><span>What Template Am I Using?</span></a>
			<a id="what-template-am-i-using-close" title="Click to remove from page">&times;</a>
			<dl id="what-template-am-i-using-data">
				<?php 
					foreach( $data as $label => $value )
						printf('<dt>%s</dt><dd>%s</dd>', $label, $value );
				?>
			</dl>
		</div>

		<?php
	}
}

What_Template_Am_I_Using::init();

/**
	This is here to show you how to extend what is shown in the panel.
*/
function what_template_am_i_using_server_data( array $data ){
	$data['Remote IP'] = $_SERVER['REMOTE_ADDR'];
	$data['Server Software'] = $_SERVER['SERVER_SOFTWARE'];
	$data['PHP Version'] = phpversion();
	return $data;
}
add_filter('what_template_am_i_using_data', 'what_template_am_i_using_server_data', 10, 1 );