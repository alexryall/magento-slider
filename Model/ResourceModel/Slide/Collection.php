<?php
namespace AlexRyall\Slider\Model\ResourceModel\Slide;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init('AlexRyall\Slider\Model\Slide', 'AlexRyall\Slider\Model\ResourceModel\Slide');
    }
}
