<?php

class Rbq_TopMenu_Block_Html_Topmenu extends Mage_Page_Block_Html_Topmenu
{
    /**
     * overwrite  top menu html generator
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Varien_Data_Tree_Node $menuTree
     * @param string $childrenWrapClass
     * @return string
     */
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';
        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;
        $counter = 1;
        $childrenCount = $children->count();
        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';
        foreach ($children as $child) {
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);
            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();
            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }
            $productsCountHtml = '';
            $productCount = $child->getProductCount();
            if ($child->getIsCategory() && ($productCount > 0)) {
                $productsCountHtml = ' (' . $productCount . ') ';
            }
            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>'
                . $this->escapeHtml($child->getName()) . $productsCountHtml . '</span></a>';
            if ($child->hasChildren()) {
                if (!empty($childrenWrapClass)) {
                    $html .= '<div class="' . $childrenWrapClass . '">';
                }
                $html .= '<ul class="level' . $childLevel . '">';
                $html .= $this->_getHtml($child, $childrenWrapClass);
                $html .= '</ul>';
                if (!empty($childrenWrapClass)) {
                    $html .= '</div>';
                }
            }
            $html .= '</li>';
            $counter++;
        }
        return $html;
    }
}
