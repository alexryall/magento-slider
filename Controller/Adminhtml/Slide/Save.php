<?php
namespace AlexRyall\Slider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * basePath of images
     */
    const BASEPATH = 'alexryallslider/slide/';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var \AlexRyall\Slider\Model\SlideFactory
     */
    private $slideFactory;

    /**
     * @var \Magento\Catalog\Model\ImageUploader
     */
    private $imageUploader;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \AlexRyall\Slider\Model\SlideFactory $slideFactory
     * @param \Magento\Catalog\Model\ImageUploader $imageUploader
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \AlexRyall\Slider\Model\SlideFactory $slideFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->slideFactory = $slideFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Catalog\Model\ImageUploader
     *
     * @deprecated 101.0.0
     */
    private function getImageUploader()
    {
        if ($this->imageUploader === null) {
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\AlexRyall\Slider\SlideImageUpload::class);
        }

        return $this->imageUploader;
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            if (isset($data['image'][0]['name'])) {
                $this->getImageUploader()->moveFileFromTmp($data['image'][0]['name']);

                $data['image'] = Save::BASEPATH . str_replace(Save::BASEPATH, "", $data['image'][0]['name']);
            } else {
                $data['image'] = null;
            }

            /** @var \AlexRyall\Slider\Model\Slide $model */
            $model = $this->slideFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This slide no longer exists.'));
                    /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'cms_page_prepare_save',
                ['page' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the slide.'));
                $this->dataPersistor->clear('alexryallslider_slide');
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the slide.'));
            }

            $this->dataPersistor->set('alexryallslider_slide', $data);
            $param = $this->getRequest()->getParam('alexryallslider_slide');
            return $resultRedirect->setPath('*/*/edit', ['alexryallslider_slide' => $param]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
