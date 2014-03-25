<?php

class Lewis_Adwords_Model_PageCache_Container_Conversion extends Enterprise_PageCache_Model_Container_Abstract {
	protected function _getCacheId() {
		return 'ADWORDS_CONVERSION_'.$this->_placeholder->getAttribute('cache_id');
	}

	protected function _renderBlock() {
		$blockClass = $this->_placeholder->getAttribute('block');
		$_block = new $blockClass;

		return $_block->setTemplate( $this->_placeholder->getAttribute('template'))->toHtml();
	}

	protected function _saveCache( $data, $id, $tags = array(), $lifetime = null ) {
		// Prevent block output from being fully cached by Enterprise 'Page Cache'
		return false;
	}
}
