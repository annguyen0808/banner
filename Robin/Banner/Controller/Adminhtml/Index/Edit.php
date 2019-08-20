<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Banner\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

/**
 * Edit CMS page action.
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Robin_Banner::save';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        //trả về page như binh thường
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry  //đắng ký 1 biến để dùng ngoài view
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Robin_Banner::banner_manager');
            // ->addBreadcrumb(__('CMS'), __('CMS'))
            // ->addBreadcrumb(__('Manage Pages'), __('Manage Pages'));
        return $resultPage;
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // echo '<h1>this is Edit</h1>';
        // 1. Get ID and create model
        //lấy ra param là id khởi tạo model là banner tham số trên url
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Robin\Banner\Model\Banner::class);

        // 2. Initial checking
        //kiểm tra xem có id hay ko
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                //thông báo lỗi ra man bình nếu ko tìm thấy id 
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                //trả về trang ban đầu tải về trang mới 
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }
//đắng ký 1 biến dùng bên ngoài view
        $this->_coreRegistry->register('banner', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        // $resultPage->addBreadcrumb(
        //     $id ? __('Edit Page') : __('New Page'),
        //     $id ? __('Edit Page') : __('New Page')
        // );
        // $resultPage->getConfig()->getTitle()->prepend(__('Pages'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getSort_order() : __('New Bannere'));
            //điều kiện láy ra id nếu mà có thì  title của nó là $model ->getTitle else là New Bannere
        return $resultPage;
    }
}
