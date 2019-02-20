<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_ACF_Field_Repeater extends ACA_ACF_Field {

	// Display
	public function get_value( $id ) {
		if ( 'count' === $this->get_repeater_display() ) {
			$count = $this->get_row_count( $id );

			return $count ? $count : $this->column->get_empty_char();
		}

		return $this->get_sub_field_value( $id );
	}

	public function get_row_count( $id ) {
		return count( $this->get_raw_value( $id ) );
	}

	public function get_sub_field_value( $id ) {
		$sub_field = $this->get_acf_sub_field();

		if ( empty( $sub_field ) ) {
			return false;
		}

		$raw_values = $this->get_raw_value( $id );

		if ( empty( $raw_values ) ) {
			return $this->column->get_empty_char();
		}

		$values = new AC_Collection();

		foreach ( $raw_values as $raw_value ) {
			if ( isset( $raw_value[ $sub_field['key'] ] ) ) {
				$values->push( $raw_value[ $sub_field['key'] ] );
			}
		}

		return $this->column->get_formatted_value( $values );
	}

	// Settings

	public function get_dependent_settings() {
		return array(
			new ACA_ACF_Setting_RepeaterDisplay( $this->column ),
		);
	}

	/**
	 * @return false|string
	 */
	private function get_repeater_display() {
		$setting = $this->column->get_setting( 'repeater_display' );

		if ( ! $setting instanceof ACA_ACF_Setting_RepeaterDisplay ) {
			return false;
		}

		return $setting->get_repeater_display();
	}

	// Helpers

	private function get_acf_sub_field() {
		if ( 'count' === $this->get_repeater_display() ) {
			return false;
		}

		return ACA_ACF_API::get_field( $this->column->get_setting( 'sub_field' )->get_value() );
	}

	public function export() {
		return new ACP_Export_Model_StrippedValue( $this->column );
	}

	public function sorting() {
		if ( 'count' === $this->get_repeater_display() ) {
			return new ACA_ACF_Sorting_Repeater( $this->column );
		}

		return new ACP_Sorting_Model_Disabled( $this->column );
	}

	public function filtering() {
		if ( 'count' === $this->get_repeater_display() ) {
			return new ACA_ACF_Filtering_Repeater( $this->column );
		}

		return new ACP_Filtering_Model_Disabled( $this->column );
	}
}
