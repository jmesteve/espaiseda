<?php
class Ma2_FeaturedProducts_Block_Adminhtml_FeaturedProducts_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
   public function __construct()
    {
        parent::__construct();
        $this->setId('FeaturedProductsGrid');
        // This is the primary key of the database
        $this->setDefaultSort('FeaturedProducts_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('FeaturedProducts/FeaturedProducts')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('FeaturedProducts_id', array(
            'header'    => Mage::helper('FeaturedProducts')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'FeaturedProducts_id',
        ));
 
        $this->addColumn('title', array(
            'header'    => Mage::helper('FeaturedProducts')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
 
        $this->addColumn('numberaction', array(            
            'header'    => Mage::helper('FeaturedProducts')->__('Display'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'numberaction',
            'type'      => 'options',
            'options'   => array(
                62 => '62',
                54 => '54',
                42 => '42',
                36 => '36',
                33 => '33',
                30 => '30',
                27 => '27',    
                21 => '21',
                18 => '18',
                15 => '15',
                12 => '12',
                9 => '9',
                6 => '6',
                3 => '3',
            ),
        ));
                        
        $this->addColumn('status', array(
 
            'header'    => Mage::helper('FeaturedProducts')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),            
        ));
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}