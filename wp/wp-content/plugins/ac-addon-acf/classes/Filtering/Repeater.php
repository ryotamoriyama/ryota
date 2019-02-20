<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_ACF_Filtering_Repeater extends ACA_ACF_Filtering {

	public function get_data_type() {
		return 'numeric';
	}

	public function is_ranged() {
		return true;
	}

	public function get_filtering_vars( $vars ) {
		$field = $this->column->get_acf_field();
		$args = $this->get_filter_value();
		$args['key'] = $field['name'];

		return $this->get_filtering_vars_ranged( $vars, $args );
	}

}
