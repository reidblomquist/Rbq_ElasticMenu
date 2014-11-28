<?php

Class Rbq_Elastic_SearchController extends Mage_Core_Controller_Front_Action {

	/*
	 *
	 * Returns ES Model
	 *
	 */
	public function getModel() {
		return Mage::getModel('elastic/search');
	}

	/*
	 *
	 * Initiates index creation action
	 * Returns "Success!" if successful
	 *
	 */
	public function createAction() {

		$response = $this->getModel()->createAllProductIndexes();

		if($response) {
			echo "Success!";
		}

	}

	/*
	 *
	 * Initiates product delete action
	 * Product Id as input parameter
	 * Prints response
	 *
	 */
	public function deleteAction() {

		$id = $this->getRequest()->getParam('id');

		if(!$id) {
			return false;
		}

		$response = $this->getModel()->deleteProductIndex($id);

		print_r($response); exit;

	}

	/*
	 *
	 * Fetches results for auto-suggest
	 * Search term as input parameter
	 * Generates and returns HTML of ES results
	 *
	 */
	public function fetchAction() {

		$query = $this->getRequest()->getParam('q');

		if(!$query) {
			return false;
		}

		$elasticSearch = $this->getModel();
		$response = $elasticSearch->fetchAutoSuggestResults($query, $elasticSearch::ADVANCED_RESULTS);
		$searchResponse = $response[0];
		$searchResponseType = $response[1];
		$searchResponseSuggestion = $response[2];

		$html = $this->getLayout()->createBlock('core/template')
			->setResult($searchResponse)
			->setSearchText($query)
			->setSearchResponseType($searchResponseType)
			->setSearchResponseSuggestion($searchResponseSuggestion)
			->setModel($elasticSearch)
			->setTemplate('elastic/autosuggest.phtml')
			->toHtml();
		$this->getResponse()->setBody($html);
		return;

	}

	/*
	 *
	 * Fetches results for search page
	 * Search term as input parameter
	 * Generates and injects HTML of ES results into layout
	 *
	 */
	public function resultAction() {

		$query = $this->getRequest()->getParam('q');

		if(!$query) {
			return false;
		}

		$elasticSearch = $this->getModel();
		$searchResponse = $elasticSearch->fetchResults($query);

		$this->loadLayout();

		$block = $this->getLayout()
			->createBlock('elastic/collection')
			->setName('search')
			->setResult($searchResponse)
			->setTemplate('elastic/product/list.phtml');

		$this->getLayout()->getBlock('content')->append($block);

		$this->renderLayout();

	}

}
