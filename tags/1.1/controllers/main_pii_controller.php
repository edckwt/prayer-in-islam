<?php
/**
 *
 */
class PrayerinislamMaincontroller extends app_pii_controlers {

	function __construct() {
		parent::__construct();
		add_action('admin_menu', array($this, 'pii_admin_menu'));
	}

	function pii_admin_menu() {
		add_options_page('Islamic Content Archive Prayer in islam', 'Islamic Content Archive Prayer in islam', 'manage_options',OPICPII_Page_SLUG, array($this, 'piisettings_page'));
	}

	function piisettings_page() {
		if(isset($_GET['tab'])){
			$tab = strip_tags($_GET['tab']);
		}else{
			$tab = '';
		}
		switch ($tab) {
			case 'options':
				$this->loadController('options');
				break;
			case 'language':
				$this->loadController('language');
				break;
			case 'categories':
				echo $this->loadController('categories');
				break;
			default:
				$this->loadController('language');
				break;
		}
	}

}
new PrayerinislamMaincontroller();
?>