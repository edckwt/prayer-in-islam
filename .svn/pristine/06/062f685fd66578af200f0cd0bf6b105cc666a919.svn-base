<?php
/**
 *
 */
class html_pii_helper extends app_pii_helpers {

	var $attrs = array();
	var $section = 'language';
	var $settings;
	var $oldData = array();
	function __construct() {
		parent::__construct();
		global $settings;
		$this -> settings = $settings;
		$this -> attrs['label'] = NULL;
		$this -> attrs['name'] = NULL;
		$this -> attrs['value'] = NULL;
		$this -> attrs['default'] = NULL;
		$this -> attrs['div'] = '<div class="input %s">%s</div>';
		$this -> attrs['options'] = array();

	}

	protected function formateAttr($attr) {
		if ($this -> attrs) {
			foreach ($this->attrs as $key => $value) {
				if (!array_key_exists($key, $attr)) {
					$attr[$key] = $value;
				}

			}
		}

		// ====================== Default Attr Start ======================
		if (!array_key_exists('id', $attr)) {
			$attr['id'] = ucfirst($attr['name']);
		}
		// ====================== Default Attr End ========================

		return $attr;
	}

	public function Input($type = 'text', $attr = array()) {
		$html = '';
		$attr = $this -> formateAttr($attr);
		$type = strtolower($type);

		if (!empty($attr['label'])) {
			$html .= sprintf('<label for="%s">%s</label>', $attr['id'], $attr['label']);
		}
		switch ($type) {
			case 'select' :
				{
					$html .= $this ->_select($attr);
				}
				break;
			case 'radio' :
				{
					$html .= $this -> _radio($attr);
				}
				break;
			case 'textarea' :
				{
					$html .= sprintf('<textarea  name="%s" id="%s" >%s</textarea>', $type, $attr['name'], $attr['id'], $attr['value']);
				}
				break;
			case 'checkbox' :
				$html .= $this -> _checkbox($attr);
				break;
			default :
				{
					if(empty($attr['value'])){
						$attr['value'] = set_value(OPICPII_Input_SLUG.$attr['name']);
					}
					 
					 
					$html .= sprintf('<input type="%s" name="%s" value="%s" id="%s" />', $type, OPICPII_Input_SLUG.$attr['name'], $attr['value'], $attr['id']);
				 
				}
				break;
		}

		return sprintf($attr['div'], $type, $html);

	}
	
	protected function _select($attr = array()) {
		
		if(isset($attr['name'])){
			$get_attr_name = $attr['name'];
			$get_attr_id = $attr['id'];
			$get_attr_options = $attr['options'];
		}else{
			$get_attr_name = '';
			$get_attr_id = '';
			$get_attr_options = '';
		}
		
		$option = get_option(OPICPII_Input_SLUG.$get_attr_name);
		
		$html = sprintf('<select name="%s" id="%s" >', OPICPII_Input_SLUG.$get_attr_name, $get_attr_id);
		foreach ($get_attr_options as $key => $value) {
			if(is_array($option) && in_array($key,$option)){
				$selected = 'selected="selected"';
				
			}elseif($option == $key){
				
				$selected = 'selected="selected"';
				
			}else{
				$selected = NULL;
			}
			
			$html .= sprintf('<option value="%s" %s >%s</option>', $key, $selected, $value);
		}
		$html .= sprintf('</select>');
		
		return $html;
	}

	protected function _radio($attr = array()) {
		foreach ($attr['options'] as $key => $value) {
			$checked = NULL;
			$html .= sprintf('<p><input type="radio" name="%s" id="%s" value="%s"  %s /> <span>%s</span></p>', OPICPII_Input_SLUG.$attr['name'], $attr['id'], $key, $checked, $value);
		}

		return $html;
	}

	protected function _checkbox($attr = array()) {
		
		if(isset($attr['name'])){
			$get_attr_name = $attr['name'];
			$get_attr_id = $attr['id'];
			$get_attr_options = $attr['options'];
		}else{
			$get_attr_name = '';
			$get_attr_id = '';
			$get_attr_options = '';
		}
		
		$option = get_option(OPICPII_Input_SLUG.str_replace('[]','',$get_attr_name));
		$html = '';
		foreach ($get_attr_options as $key => $value) {
			if(is_array($option) && in_array($key, $option)){
				$checked = 'checked="checked"';
			}elseif(is_string($option) && $key = $option ){
				$checked = 'checked="checked"';
			}else{
				$checked = '';
			}
			
			$html .= sprintf('<p><input type="checkbox" name="%s" id="%s" value="%s" %s /> <span>%s</span></p>', OPICPII_Input_SLUG.$get_attr_name, $get_attr_id, $key, $checked, $value);
		}

		return $html;
	}
	
	public function format_category_json($url='')
	{
		$source = json_decode(opic_get_data($url));

		$catList = array();
		if($source->status == 'ok' && !empty($source->categories)){
			foreach ($source->categories as $key => $value) {
				if(is_array($value)){
					foreach ($value as $_key => $_value) {
						$catList[$_value->slug] =  $_value->title;
					}
				}else{
					$catList[$value->slug] = $value->title;//.sprintf('<b> %s </b>',$value->post_count);
				}
				
				
			}
			return $catList;
		}
		
		return array();
	}
	
	public function categoryFromTransient($url=NULL,$slug)
	{
		$oldData = opic_get_transient($slug);
		if(!empty($oldData)){
			return (array)$oldData['opic_value'];	
		}else{
			$set_data = $this->format_category_json($url);
			opic_set_transient($slug,$set_data);
			return $set_data;
		}
		
	}

}


?>