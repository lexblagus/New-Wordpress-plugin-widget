<?php
/*
Plugin Name: NewPluginWidget
Plugin URI: https://github.com/lexblagus/New-Wordpress-plugin-widget
Description: A empty sample widget
Author: Lex Blagus <new-wordpress-plugin-widget@blag.us>
Version: 0.01
Author URI: http://blag.us/
*/

//error_reporting(E_ALL);
add_action("widgets_init", array('newPluginWidget', 'register'));

register_activation_hook( __FILE__, array('newPluginWidget', 'activate'));
register_deactivation_hook( __FILE__, array('newPluginWidget', 'deactivate'));


/* =============================================================================
Widget class
============================================================================= */
class newPluginWidget {
	/* -----------------------------------------------------------------------------
	Activation actions
	----------------------------------------------------------------------------- */
	function activate(){
		$data = array( 
			'option1'          => '1',
			'option2'          => '2',
			'option3'          => '3' 
		);
		if ( ! get_option('newPluginWidget')){
			add_option('newPluginWidget' , $data);
		} else {
			update_option('newPluginWidget' , $data);
		}
	}
	/* -----------------------------------------------------------------------------
	Deactivation actions
	----------------------------------------------------------------------------- */
	function deactivate(){
		delete_option('newPluginWidget');
	}
	/* -----------------------------------------------------------------------------
	Options at widgets admin page
	----------------------------------------------------------------------------- */
	function control(){
		$data = get_option('newPluginWidget');
	?>
		<p><b>Options</b></p>
		<p>
			<label>Option 1:<br />
			<input name="newPluginWidget_option1" type="text" value="<?php echo $data['option1']; ?>" /></label><br />
			<i>help text goes here…</i>
		</p>
		<p>
			<label>Option 2:<br />
			<input name="newPluginWidget_option2" type="text" value="<?php echo $data['option2']; ?>" /></label><br />
			<i>help text goes here…</i>
		</p>
		<p>
			<label>Option 3:<br />
			<input name="newPluginWidget_option3" type="text" value="<?php echo $data['option3']; ?>" /></label><br />
			<i>help text goes here…</i>
		</p>

		<p><b>Usage</b></p>
		<p>Main help goes here…</p>
	<?php
		if (  isset( $_POST['newPluginWidget_option1'] )  ){
			$data['option1'] = attribute_escape($_POST['newPluginWidget_option1']);
			$data['option2'] = attribute_escape($_POST['newPluginWidget_option2']);
			$data['option3'] = attribute_escape($_POST['newPluginWidget_option3']);
			update_option('newPluginWidget', $data);
		}
	}
	/* -----------------------------------------------------------------------------
	Widget rendering at site pages
	----------------------------------------------------------------------------- */
	function widget($args){
		echo $args['before_widget'];
		echo $args['before_title'];
		echo $args['after_title'];
		$data = get_option('newPluginWidget');
	?>
			<h1 class="widget-title">New widget title</h1>
			<div>
				<b>Option 1:</b> <?php echo( $data['option1'] ); ?><br>
				<b>Option 2:</b> <?php echo( $data['option2'] ); ?><br>
				<b>Option 3:</b> <?php echo( $data['option3'] ); ?><br>
			</div>
	<?php
		echo $args['after_widget'];
	}
	/* -----------------------------------------------------------------------------
	Registering
	----------------------------------------------------------------------------- */
	function register(){
		register_sidebar_widget('NewPluginWidget', array('newPluginWidget', 'widget'));
		register_widget_control('NewPluginWidget', array('newPluginWidget', 'control'));
	}
}
?>