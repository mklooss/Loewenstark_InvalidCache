<?php

class Loewenstark_InvalidCache_Model_Observer
{
    /**
     * Remove the annoying notification on product save.
     * @see https://gist.github.com/1074482
     *
     * @param Varien_Event_Observer $observer
     */
    public function clearBlockCache(Varien_Event_Observer $observer)
    {
        Mage::app()->getCacheInstance()->cleanType('block_html');
        Mage::app()->getCacheInstance()->cleanType('fpc'); // for magento enterprise
        return $this;
    }
    
    /**
     * Clean Up Cache via CronJob
     *
     * @return void
     */
    public function clearInvalidCache()
    {
        // get all Cache Types
        $types = Mage::app()->getCacheInstance()->getInvalidatedTypes();
        foreach($types as $_type)
        {
            // clear invalid caches
            Mage::app()->getCacheInstance()->cleanType($_type->getId());
            Mage::Log(sprintf("Cleared Cache: %s",$_type->getId()),null);
        }
        return $this;
    }
}