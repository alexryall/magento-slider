<?php
namespace AlexRyall\Slider\Model;

use AlexRyall\Slider\Model\ResourceModel\Slide\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $slideCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $slideCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $slideCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        else {
            $this->loadedData = null;
        }
        $slides = $this->collection->getItems();
        /** @var $slide \AlexRyall\Slider\Model\Slide */
        foreach ($slides as $slide) {
            $this->loadedData[$slide->getId()] = $slide->getData();
            if ($slide->getImage()) {
                $m['image'][0]['name'] = $slide->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$slide->getImage();
                $fullData = $this->loadedData;
                $this->loadedData[$slide->getId()] = array_merge($fullData[$slide->getId()], $m);
            }
        }

        return $this->loadedData;
    }

    /**
     * Get media directory url
     *
     * @return string
     */
    public function getMediaUrl() {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}