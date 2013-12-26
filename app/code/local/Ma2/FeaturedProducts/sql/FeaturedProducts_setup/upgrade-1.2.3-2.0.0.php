<?php
$installer = $this;
$installer->startSetup();

$installer->updateAttribute('catalog_product', 'ma2_featured_product', 'is_global', '0');

$installer->endSetup();