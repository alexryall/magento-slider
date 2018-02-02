<?php
namespace AlexRyall\Slider\Block\Widget;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = "widget/slider.phtml";

    /**
     * Store Banner resource instance
     *
     * @var \Magento\Banner\Model\ResourceModel\Banner
     */
    protected $_bannerResource;

    /**
     * @var int
     */
    protected $_currentStoreId;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Banner\Model\ResourceModel\Banner $resource
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Banner\Model\ResourceModel\Banner $resource,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_bannerResource = $resource;
        $this->_currentStoreId = $this->_storeManager->getStore()->getId();
        $this->_filterProvider = $filterProvider;
    }

    /**
     * Set unique id of widget instance
     *
     * @return string
     */
    public function getUniqueId()
    {
        return md5($this->getBannerIds());
    }

    /**
     * Get array of banner images
     *
     * @return array
     */
    public function getBanners() {
        $banners = [];

        $bannerIds = explode(',', $this->getBannerIds());

        foreach ($bannerIds as $bannerId) {
            $html = $this->_filterProvider->getPageFilter()->filter($this->_bannerResource->getStoreContent($bannerId, $this->_currentStoreId)); //change {{media url=""}}

            array_push($banners, $html);
        }

        return $banners;
    }

    /**
     * Get speed in milliseconds
     *
     * @return int
     */
    public function getSpeedInMs() {
        return (int)$this->getSpeed() * 1000;
    }

    /**
     * Get if it is 'left to right' or 'right to left'
     *
     * @return string
     */
    public function getIsRtl() {
        if ($this->getDirection() == 'right') {
            //return 'true'; //rtl is broken in slick
        }
        return 'false';
    }

    /**
     * Get if the slider should fade
     *
     * @return string
     */
    public function getIsFade() {
        if ($this->getFade() == 'yes') {
            return 'true';
        }
        return 'false';
    }
}
