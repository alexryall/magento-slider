<?php
namespace AlexRyall\Slider\Model\Adminhtml\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Slides implements ArrayInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var \AlexRyall\Slider\Model\ResourceModel\Slide\Collection
     */
    private $slideCollection;

    /**
     * @param \AlexRyall\Slider\Model\ResourceModel\Slide\Collection $slideCollection
     */
    public function __construct(\AlexRyall\Slider\Model\ResourceModel\Slide\Collection $slideCollection)
    {
        $this->slideCollection = $slideCollection;
    }

    /**
     * @param bool $isMultiselect
     * @return array
     */
    public function toOptionArray($isMultiselect = false)
    {
        if (!$this->options) {
            $this->options = $this->slideCollection
                ->loadData()
                ->toOptionArray(false);
        }

        $options = $this->options;
        if (!$isMultiselect) {
            array_unshift($options, ['value' => '', 'label' => __('--Please Select--')]);
        }

        return $options;
    }
}
