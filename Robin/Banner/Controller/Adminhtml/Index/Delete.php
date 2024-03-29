<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Banner\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Delete CMS page action.
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Robin_Banner::page_delete';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // echo '<h1> this is delete</h1>';
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Robin\Banner\Model\Banner::class);
                $model->load($id);
                
                $title = $model->getId();
                $model->delete();
                
                // display success message
                $this->messageManager->addSuccessMessage(__('The page has been deleted.'));
                
                // go to grid
                // $this->_eventManager->dispatch('adminhtml_cmspage_on_delete', [
                //     'title' => $title,
                //     'status' => 'success'
                // ]);
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // $this->_eventManager->dispatch(
                //     'adminhtml_cmspage_on_delete',
                //     ['title' => $title, 'status' => 'fail']
                // );
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a page to delete.'));
        
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
