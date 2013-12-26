<?php
class Ma2_WidgetTabs_Model_Mysql4_Widget_Instance_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('widget/widget_instance');
    }
 
    /**
     * Filter by store ids
     *
     * @param array|integer $storeIds
     * @param boolean $withDefaultStore if TRUE also filter by store id '0'
     * @return Mage_Widget_Model_Mysql4_Widget_Instance_Collection
     */
    public function addStoreFilter($storeIds = array(), $withDefaultStore = true)
    {
        if (!is_array($storeIds)) {
            $storeIds = array($storeIds);
        }
        if ($withDefaultStore && !in_array(0, $storeIds)) {
            array_unshift($storeIds, 0);
        }
        $select = $this->getSelect();
        foreach ($storeIds as $storeId) {
            $select->orWhere('FIND_IN_SET(?, `store_ids`)', $storeId);
        }
        return $this;
    }
     
    public function addTypeFilter($type) {
        $this->getSelect()->where('type=?', $type);
        return $this;
    }
     
    public function addTitleFilter($type) {
        $this->getSelect()->where('title=?', $type);
        return $this;
    }
     
    public function addAttributeToSort($attribute, $dir='asc') {
        $this->getSelect()->order("{$attribute} {$dir}");
        return $this;
    }
}
?>