<?php
$installer = $this;
$installer->startSetup();

$installer->removeAttribute('catalog_product', 'ma2_featured_product');

$installer->endSetup();