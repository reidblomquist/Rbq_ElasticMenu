<?php

/*
 *
 * Collection Block extends the Catalog Block
 * Used for rendering product list of ES results on search page
 *
 */

class Rbq_Elastic_Block_Collection extends Mage_Catalog_Block_Product_List
{
    /*
     *
     * Sets the collection retrieved from ES results as product collection for template
     *
     */
    protected function _getProductCollection()
    {
        $searchResult = $this->getResult();
        $ids = array();
        foreach ($searchResult as $product) {
            $ids[] = $product['product_id'];
        }
        $collection = Mage::getModel('catalog/product')->getCollection()->addIdFilter($ids);
        $collection->load();
        $this->setProductCollection($collection);
        return $collection;
    }
}
