<?php
namespace AlexRyall\Slider\Block\Adminhtml\Widget;

class Chooser extends \Magento\Banner\Block\Adminhtml\Widget\Chooser
{
    /**
     * This function is broken in the core and always returns empty collection
     *
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_banners') {
            $bannerIds = $this->getSelectedBanners();
            if (!empty($bannerIds) && $column->getFilter()->getValue()) {
                $this->getCollection()->addBannerIdsFilter($bannerIds);
            } else {
                if ($bannerIds) {
                    $this->getCollection()->addBannerIdsFilter($bannerIds, true);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
