<?php
/**
Plugin Name: Islamic Archive For Prayer In Islam
Plugin URI: http://www.prayerinislam.com
Description: Prayer In Islam aspires to be a unique and simple online guide on Prayer and how to perform it properly. It seeks to teach Muslims how to pray as correctly as Prophet Muhammad did.
Version: 1.1
Author: EDC Team (E-Da`wah Committee)
Author URI: http://www.islam.com.kw
License: Free
*/
define('OPICPII_PLUGIN_PATH',plugin_dir_path( __FILE__ ));
define('OPICPII_PLUGIN_URL',plugin_dir_url( __FILE__ ));
define('OPICPII_Page_SLUG','islamic_content_archive_prayer_in_islam');
define('OPICPII_Input_SLUG','opicpii_');
define('PIILIB','lib');
define('PIIDS','/');
define('PIICONTROLLERS','controllers');
define('PIIMODELS','models');
define('PIIDBTable', 'opicpii_categories');
define('PIIBootstrappath',OPICPII_PLUGIN_PATH.'style'.PIIDS);
define('PIILogourl',OPICPII_PLUGIN_URL.'style'.PIIDS.'images'.PIIDS.'logo'.PIIDS);
define('PIIIconpath',OPICPII_PLUGIN_PATH.'style'.PIIDS.'images'.PIIDS.'icons'.PIIDS);
define('PIIIconurl',OPICPII_PLUGIN_URL.'style'.PIIDS.'images'.PIIDS.'icons'.PIIDS);
define('PIIFlagspath',OPICPII_PLUGIN_PATH.'style'.PIIDS.'images'.PIIDS.'flags'.PIIDS);
define('PIIFlagsurl',OPICPII_PLUGIN_URL.'style'.PIIDS.'images'.PIIDS.'flags'.PIIDS);

define('PIIControlerspath',OPICPII_PLUGIN_PATH.'controllers'.PIIDS);
define('PIIModelspath',OPICPII_PLUGIN_PATH.'models'.PIIDS);
define('PIIViewspath',OPICPII_PLUGIN_PATH.'views'.PIIDS);
define('PIILayoutpath',OPICPII_PLUGIN_PATH.'views'.PIIDS.'layout'.PIIDS);
define('PIILangpath',OPICPII_PLUGIN_PATH.'views'.PIIDS.'lang'.PIIDS);

function OPICPII_plugin_install(){
	$default_lang = 'eng';
	$source = 'Soucre Link';
	add_option(OPICPII_Input_SLUG.'language', $default_lang);
	add_option(OPICPII_Input_SLUG.'source', $source);
	add_option(OPICPII_Input_SLUG.'cronjobtime', 'everyhour');
	add_option(OPICPII_Input_SLUG.'version', '1.1');
}
function OPICPII_plugin_uninstall(){
	$options = get_option(OPICPII_Input_SLUG.'language');
 	if( is_array($options) && $options['uninstall'] === true){
		delete_option(OPICPII_Input_SLUG.'language');
		delete_option(OPICPII_Input_SLUG.'source');
		delete_option(OPICPII_Input_SLUG.'cronjobtime');
		delete_option(OPICPII_Input_SLUG.'version');
	}
}
register_activation_hook(plugin_basename(__FILE__),'OPICPII_plugin_install'); 
register_deactivation_hook(plugin_basename(__FILE__), 'OPICPII_plugin_uninstall');

include_once(OPICPII_PLUGIN_PATH.'load.php');