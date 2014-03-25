<?php

class Lewis_Adwords_Block_Remarketing extends Lewis_Adwords_Block_Abstract {
	protected function isTypeEnabled() {
		$type = $this->getTrackingType();
		$helper = Mage::helper('adwords');

		return $type == $helper::TRACKING_TYPE_REMARKETING || $type == $helper::TRACKING_TYPE_BOTH;
	}

	protected function getImgSrc() {
		return sprintf( '//googleads.g.doubleclick.net/pagead/viewthroughconversion/%s/?', $this->getAdwordsId()).$this->getImgSrcQueryString(true);
	}

	protected function getImgSrcQueryString($html=false) {
		$args = $this->getImgSrcParameters();
		$queryString = array();
		foreach( $args as $k=>$v ) {
			$queryString[] = sprintf( '%s=%s', $k, $v );
		}

		return implode( $html ? '&amp;' : '&', $queryString );
	}

	protected function getImgSrcParameters() {
		return array(
			'guid' => 'ON',
			'script' => 0,
			'value' => 0
		);
	}
}