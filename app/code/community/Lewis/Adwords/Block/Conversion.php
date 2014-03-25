<?php

class Lewis_Adwords_Block_Conversion extends Lewis_Adwords_Block_Abstract {
	public function getCacheLifetime() {
		return null;
	}

	protected function isTypeEnabled() {
		$type = $this->getTrackingType();
		$helper = Mage::helper('adwords');

		return $type == $helper::TRACKING_TYPE_CONVERSION || $type == $helper::TRACKING_TYPE_BOTH;
	}

	protected function getImgSrc() {
		return sprintf( '//www.googleadservices.com/pagead/conversion/%s/?', $this->getAdwordsId()).$this->getImgSrcQueryString(true);
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
			'label' => $this->getLabel(),
			'value' => $this->getValue()
		);
	}

	protected function getOrder() {
		if( $_order = $this->getData('order')) {
			return $_order;
		}

		if( $orderId = Mage::getSingleton('checkout/session')->getLastOrderId()) {
			$_order = Mage::getModel('sales/order')->load($orderId);
			$this->setOrder($_order);
			return $_order;
		}

		return false;
	}

	protected function getValue() {
		if( ! $_order = $this->getOrder()) {
			return 0;
		}

		return round( $_order->getGrandTotal(), 2 );
	}
}
