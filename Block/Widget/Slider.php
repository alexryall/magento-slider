<?php
namespace AlexRyall\Slider\Block\Widget;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = "widget/slider.phtml";

    /**
     * @var \AlexRyall\Slider\Model\SlideFactory
     */
    private $slideFactory;

    /**
     * @var int
     */
    private $_currentStoreId;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    private $_filterProvider;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \AlexRyall\Slider\Model\SlideFactory $slideFactory
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \AlexRyall\Slider\Model\SlideFactory $slideFactory,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->slideFactory = $slideFactory;
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
        return hash('sha256', $this->getAutoplay()
            . '_' . $this->getSpeed()
            . '_' . $this->getFade()
            . '_' . $this->getDirection()
            . '_' . $this->getNav()
            . '_' . $this->getSlidesToShow()
            . '_' . $this->getSlidesToScroll()
            . '_' . $this->getSlideIds());
    }

    /**
     * Get array of slide content
     *
     * @return array
     */
    public function getBanners()
    {
        $slides = [];

        $slideIds = explode(',', $this->getSlideIds());

        foreach ($slideIds as $slideId) {
            $slide = $this->slideFactory->create()->load($slideId);

            array_push($slides, $this->_filterProvider->getBlockFilter()->filter($slide->getContent()));
        }

        return $slides;
    }

    /**
     * Get if the slider should autoplay
     *
     * @return string
     */
    public function getIsAutplay()
    {
        if ($this->getAutoplay() == '1') {
            return 'true';
        }
        return 'false';
    }

        /**
     * Get speed in milliseconds
     *
     * @return int
     */
    public function getSpeedInMs()
    {
        return (int)$this->getSpeed() * 1000;
    }

    /**
     * Get if it is 'left to right' or 'right to left'
     *
     * @return string
     */
    public function getIsRtl()
    {
        //rtl is broken in slick
        return 'false';
    }

    /**
     * Get if the slider should fade
     *
     * @return string
     */
    public function getIsFade()
    {
        if ($this->getFade() == '1') {
            return 'true';
        }
        return 'false';
    }
}
