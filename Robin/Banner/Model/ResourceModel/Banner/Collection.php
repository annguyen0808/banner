<?php

namespace Robin\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    
    protected function _construct()
    {
        $this-> _init('Robin\Banner\Model\Banner','Robin\Banner\Model\ResourceModel\Banner');
    }
}