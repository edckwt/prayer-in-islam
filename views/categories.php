<?php
$PIIHtml = new html_pii_helper();
global $piicategories,$opicpii_categories_lang;
 
$category_slug = esc_attr($_GET['cat_slug']);

$opicpii_lang = get_option(OPICPII_Input_SLUG.'language');
$link = $opicpii_categories_lang[$opicpii_lang][$category_slug]['url'];
$jsoncaturl = $opicpii_categories_lang[$opicpii_lang][$category_slug]['cat'];
$slug = $category_slug.'_'.$opicpii_lang;
$cat_options = $PIIHtml->categoryFromTransient($jsoncaturl,$slug);
?>
<div class="category-head">
	<table width="100%">
		<tr>
			<td width="80px"><span class="category-logo"><?php echo opicpii_cat_logo($category_slug,array('width'=>'80px','class'=>$category_slug)) ?></span></td>
			<td><h1 class="category-title"><a target="_blank" href="<?php echo $link; ?>"><?php echo $this->getLang($category_slug); ?></a></h1></td>
		</tr>
	</table>

</div>
<hr />
<?php
	echo $PIIHtml->Input('checkbox',array('name'=>'category_'.$opicpii_lang.'_'.$category_slug.'[]','options'=>$cat_options));
?>
