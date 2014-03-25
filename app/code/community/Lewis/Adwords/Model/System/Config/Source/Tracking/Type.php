<?php

class Lewis_Adwords_Model_System_Config_Source_Tracking_Type {
	public function toArray() {
		$helper = Mage::helper('adwords');

		return array(
			$helper::TRACKING_TYPE_CONVERSION => $helper->__('Conversion Only'),
			$helper::TRACKING_TYPE_REMARKETING => $helper->__('Remarketing Only'),
			$helper::TRACKING_TYPE_BOTH => $helper->__('Conversion and Remarketing')
		);
	}

	public function toOptionArray() {
		$opts = array();
		foreach( $this->toArray() as $value => $label ) {
			$opts[] = array( 'value' => $value, 'label' => $label );
		}

		return $opts;
	}
}
