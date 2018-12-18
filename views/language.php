

<div class="category-head">
		<table width="100%">
		<tr>
			<td width="80px"><span class="category-logo"><?php echo opicpii_icon_logo('language.png',array('width'=>'80px')) ?></span></td>
			<td><h1 class="category-title"><?php echo $this->getLang('control-language') ?></h1></td>
		</tr>
	</table>
</div>
<hr />
<?php
$lang = array('ara' => 'Arabic', 'eng' => 'English'/*,'rom'=>'Romanian','rus'=>'Russian','spa'=>'Spanish','hin'=>'Hindi','tag'=>'Tagalog','ben'=>'Bengali','sin'=>'Sinhalese','nep'=>'Nepali','tam'=>'Tamil','tel'=>'Telugu','mal'=>'Malayalm'*/);
echo $this -> Input('select', array('name' => 'language', 'options' => $lang, 'label' => $this -> getLang('label-selectlang')));
?>