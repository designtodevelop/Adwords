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

    protected function _getTagParams ()
    {
        $module = Mage::app()->getRequest()->getRequestedRouteName();
        $controller = Mage::app()->getRequest()->getRequestedControllerName();
        $action = Mage::app()->getRequest()->getRequestedActionName();
        switch ($module) :
            case 'catalog':
                if ("product" == $controller && "view" == $action) {
                    $product = Mage::registry('current_product');
                    $params = array(
                        "ecomm_prodid" => $product->getEntityId(),
                        "ecomm_pagetype" => 'product',
                        "ecomm_totalvalue" => $product->getPrice()
                    );
                    break;
                }
                if ("category" == $controller && "view" == $action) {
                    $params = array(
                        "ecomm_prodid" => "",
                        "ecomm_pagetype" => 'category',
                        "ecomm_totalvalue" => ""
                    );
                    break;
                }
            case 'checkout':
                if ("cart" == $controller) {
                    /** @var Mage_Sales_Model_Quote $cart */
                    $cart = Mage::getModel('checkout/cart')->getQuote();
                    foreach ($cart->getAllItems() as $_item) {
                        $itemsIds[] = (int)$_item->getProduct()->getId();
                    }
                    $params = array(
                        "ecomm_prodid" => $itemsIds,
                        "ecomm_pagetype" => 'cart',
                        "ecomm_totalvalue" => $cart->getSubtotal()
                    );
                    break;
                }
                if ("onepage" == $controller && "success" == $action) {
                    $lastQuoteId = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastSuccessQuoteId();
                    /** @var Mage_Sales_Model_Quote $cart */
                    $cart = Mage::getModel('sales/quote')->load($lastQuoteId);
                    foreach ($cart->getAllItems() as $_item) {
                        $itemsIds[] = (int)$_item->getProduct()->getId();
                    }
                    $params = array(
                        "ecomm_prodid" => $itemsIds,
                        "ecomm_pagetype" => 'purchase',
                        "ecomm_totalvalue" => $cart->getSubtotal()
                    );
                    break;
                }
            case 'cms':
                if (Mage::getBlockSingleton('page/html_header')->getIsHomePage()) {
                    $params = array(
                        "ecomm_prodid" => "",
                        "ecomm_pagetype" => "home",
                        "ecomm_totalvalue" => ""
                    );
                    break;
                }
            default :
                $params = array(
                    "ecomm_prodid" => "",
                    "ecomm_pagetype" => "other",
                    "ecomm_totalvalue" => ""
                );
        endswitch;
        return Zend_Json::encode($params);
    }
}