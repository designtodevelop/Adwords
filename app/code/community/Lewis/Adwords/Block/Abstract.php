<?php

abstract class Lewis_Adwords_Block_Abstract extends Mage_Core_Block_Template
{
	protected function _toHtml() {
		if( $this->isEnabled() && $this->isTypeEnabled()) {
			return parent::_toHtml();
		}

		return '';
	}

	protected function getScriptUrl() {
		return '//www.googleadservices.com/pagead/conversion.js';
	}

	protected function isEnabled() {
		return Mage::getStoreConfig('google/adwords/enabled');
	}

	protected function getTrackingType() {
		return Mage::getStoreConfig('google/adwords/tracking_type');
	}

	protected function isTypeEnabled() {
		return false;
	}

	protected function getAdwordsId() {
		return Mage::getStoreConfig('google/adwords/id');
	}

	protected function getLanguage() {
		return Mage::getStoreConfig('google/adwords/language');
	}

	protected function getFormat() {
		return Mage::getStoreConfig('google/adwords/format');
	}

	protected function getColor() {
		return Mage::getStoreConfig('google/adwords/color');
	}

	protected function getLabel() {
		return Mage::getStoreConfig('google/adwords/label');
	}
}
