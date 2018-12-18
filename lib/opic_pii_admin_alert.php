<?php
function opic_pii_admin_errors_notice() {
	global $opicpii_lang;	
	$result = array();
	
	$link = admin_url("options-general.php?page=".OPICPII_Page_SLUG."&tab=language");
	$opic_cronjob = get_option(OPICPII_Input_SLUG . 'cronjobtime');
	$opic_ch_lang = get_option(OPICPII_Input_SLUG . 'language');
	if (empty($opic_ch_lang)) {
		$result[] = "<p>".sprintf($opicpii_lang['alert-opic_must_select_lang'],$link)."</p>";
	}
	
	$link = admin_url("options-general.php?page=".OPICPII_Page_SLUG."&tab=options");
	$opic_pii_cronjob = get_option(OPICPII_Input_SLUG . 'cronjobtime');
	if (empty($opic_pii_cronjob)) {
		$result[] = "<p>".sprintf($opicpii_lang['alert-opic_must_select_cron_time'],$link)."</p>";
	}
	
	$link = admin_url("options-general.php?page=".OPICPII_Page_SLUG."&tab=options");
	$opic_source = get_option(OPICPII_Input_SLUG . 'source');
	if (empty($opic_source)) {
		$result[] = "<p>".sprintf($opicpii_lang['alert-opic_must_add_source_link'],$link)."</p>";
	}	
	
	return $result;
}


function display_opicpii_admin_errors_notice() {
	global $opicpii_lang;	
	$errors = opic_admin_errors_notice();
	if(is_array($errors) && !empty($errors)){
		$class = "error";
		echo "<div class=\"$class\"><h3 class='opic_logo'>".$opicpii_lang['label-opic_plugin_title']."</h3><ol>";
		foreach ($errors as $key => $value) {
			echo "<li>".$value."</li>";
		}
		echo "</ol></div>";
	}

}
//add_action('admin_notices', 'display_opic_admin_errors_notice');
?>