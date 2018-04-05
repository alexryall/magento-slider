<?php
namespace AlexRyall\Slider\Model;

class Slide extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'alexryall_slider_slide';

    protected $_cacheTag = 'alexryall_slider_slide';

    protected $_eventPrefix = 'alexryall_slider_slide';

    public function _construct()
    {
        $this->_init('AlexRyall\Slider\Model\ResourceModel\Slide');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
