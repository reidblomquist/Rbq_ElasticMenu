<?php

class Rbq_Elastic_Model_Observer {

	/*
	 *
	 * Observer invoked when a product is saved
	 * Updates / creates product document in ES
	 *
	 */
	public function productSave(Varien_Event_Observer $observer) {

		$productData = $observer->getEvent()->getProduct()->getData();
		$productId = $productData['entity_id'];

		$elasticSearch = Mage::getModel('elastic/search')->updateProductIndex($productId);

	}

	/*
	 *
	 * Observer invoked when a product is deleted
	 * Deletes the product document in ES
	 *
	 */
	public function productDelete(Varien_Event_Observer $observer) {

		$productData = $observer->getEvent()->getProduct()->getData();
		$productId = $productData['entity_id'];

		$elasticSearch = Mage::getModel('elastic/search')->deleteProductIndex($productId);

	}

}
