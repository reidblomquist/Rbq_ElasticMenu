<?php

/*
 *
 * ES Helper rewrites and extends the CatalogSearch Helper
 *
 */
class Rbq_Elastic_Helper_Data extends Mage_CatalogSearch_Helper_Data {

	/*
	 *
	 * Returns URL which serves the ES result page
	 *
	 */
	public function getResultUrl() {
		return Mage::getUrl('elastic/search/result');
	}

	/*
	 *
	 * Returns URL which serves the ES auto-suggest results
	 *
	 */
	public function getFetchUrl() {
		return Mage::getUrl('elastic/search/fetch');
	}

	/*
	 *
	 * Returns URL which serves the ES result page, with a parameter
	 *
	 */
	public function getCorrectedUrl($string) {
		return Mage::getUrl('elastic/search/result') . '?q=' . $string;
	}

}
