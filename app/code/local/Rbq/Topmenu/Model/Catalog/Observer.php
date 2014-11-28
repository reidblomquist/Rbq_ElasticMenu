<?php

class Rbq_Topmenu_Model_Catalog_Observer extends Mage_Catalog_Model_Observer
{
    /**
     * overwrite
     *
     * Recursively adds categories to top menu
     *
     * @param Varien_Data_Tree_Node_Collection|array $categories
     * @param Varien_Data_Tree_Node $parentCategoryNode
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode)
    {
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $categoryId = $category->getId();
            $categoryUrl = Mage::helper('catalog/category')->getCategoryUrl($category);
            $nodeId = 'category-node-' . $categoryId;
            $tree = $parentCategoryNode->getTree();
            $categoryData = array(
                'name' => $category->getName(),
                'id' => $nodeId,
                'url' => $categoryUrl,
                'is_active' => $this->_isActiveMenuCategory($category),
                'is_category' => true
            );
            $categoryNode = new Varien_Data_Tree_Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);
            $rawProducts = $this->_getProductData($categoryId);
            if ($rawProducts && $rawProducts->getTotalHits() > 0) {
                foreach ($rawProducts as $product) {
                    $rawProduct = $product->getData();
                    $productData = array(
                        'name' => $rawProduct['name'],
                        'id' => $rawProduct['product_id'],
                        'url' => $rawProduct['url'],
                        'product_count' => 0,
                        'is_active' => 1,
                        'is_category' => true
                    );
                    $productNode = new Varien_Data_Tree_Node($productData, 'id', $tree, $categoryNode);
                    $categoryNode->addChild($productNode);
                }
            }
            if ($rawProducts && $rawProducts->getTotalHits() > 10) {
                $addData = array(
                    'name' => 'See more...',
                    'url' => $categoryUrl,
                    'is_active' => 1,
                    'is_category' => true
                );
                $addNode = new Varien_Data_tree_Node($addData, $tree, $categoryNode);
                $categoryNode->addChild($addNode);
            }
            if (Mage::helper('catalog/category_flat')->isEnabled()) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }
            $this->_addCategoriesToMenu($subcategories, $categoryNode);
        }
    }

    protected function _getProductData($categoryId)
    {
        $products = Mage::getModel('elastic/search')->getCategoryProducts($categoryId);
        return $products;
    }
}
