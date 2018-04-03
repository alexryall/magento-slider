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
    protected $_currentStoreId;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

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
        return md5($this->getSlideIds());
    }

    /**
     * Get array of slide images
     *
     * @return array
     */
    public function getBanners() {
        $slides = [];

        $slideIds = explode(',', $this->getSlideIds());

        foreach ($slideIds as $slideId) {
            $slide = $this->slideFactory->create()->load($slideId);

            $html = '';

            if ($slide->getUrl()) {
                $html .= '<a href="' . $slide->getUrl() . '">';
            }

            $html .= '<img src="' . $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $slide->getImage() . '" alt="' . $slide->getName() . '"/>';

            if ($slide->getUrl()) {
                $html .= '</a>';
            }

            array_push($slides, $html);
        }

        return $slides;
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
