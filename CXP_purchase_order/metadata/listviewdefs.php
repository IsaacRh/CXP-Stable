<?php
$module_name = 'CXP_purchase_order';
$listViewDefs [$module_name] = 
array (
  'ORDER_NUMBER' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ORDER_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PAYMENT_METHOD' => 
  array (
    'type' => 'dynamicenum',
    'studio' => 'visible',
    'label' => 'LBL_PAYMENT_METHOD',
    'width' => '10%',
    'default' => true,
  ),
  'PAYMENT_TERMS' => 
  array (
    'type' => 'dynamicenum',
    'studio' => 'visible',
    'label' => 'LBL_PAYMENT_TERMS',
    'width' => '10%',
    'default' => true,
  ),
  'IS_AUTHORIZED' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_IS_AUTHORIZED',
    'width' => '10%',
  ),
  'AUTHORIZED_BY' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AUTHORIZED_BY',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'STATUS_ORDER' => 
  array (
    'type' => 'dynamicenum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS_ORDER',
    'width' => '10%',
    'default' => true,
  ),
  'NETO_TOTAL' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_NETO_TOTAL',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'SUBTOTAL_ONE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_SUBTOTAL_ONE',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
  ),
  'DISCOUNT' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_DISCOUNT',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'SUBTOTAL_TWO' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_SUBTOTAL_TWO',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'WITHHOLDINGS' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_WITHHOLDINGS',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'IVA' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_IVA',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'AUTHORIZED_DATE' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_AUTHORIZED_DATE',
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
