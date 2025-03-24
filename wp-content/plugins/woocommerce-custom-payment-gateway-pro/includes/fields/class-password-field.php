<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Password_Field extends Custom_Payment_Field{

	public function get_html() {
		 return '<input id="'.$this->get_id().'" class="input-text '.$this->get_css_class().' '.$this->get_size().'" type="password" name="'.$this->get_id().'" value="'.esc_attr($this->get_default_value()).'">';
	}

}