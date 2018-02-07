<?php
namespace AlexRyall\Slider\Model\ResourceModel;

class Slide extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('alexryall_slider_slide', 'id');
    }
}