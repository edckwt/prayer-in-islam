<form method="post" action="<?php admin_url( 'options-general.php?page='.OPICPII_Page_SLUG ); ?>">
<?php
	echo wp_nonce_field( "edc-settings-page" ); 
	
	$PIIHtmlHelper = new html_pii_helper();
	$PIIHtmlHelper->opic_admin_tabs();
	$PIIHtmlHelper->MainContent($mainViewFile);
?>
   <p class="submit" style="clear: both;">
      <input type="submit" name="Submit"  class="button-primary" value="<?php echo $PIIHtmlHelper->getLang('btn-updatesetting') ?>" />
      <input type="hidden" name="ilc-settings-submit" value="Y" />
   </p>
</form>