<?php
$module_name = 'CXP_purchase_requisition';
$listViewDefs [$module_name] = 
array (
  'REQUISITION_NUMBER' => 
  array (
    'type' => 'int',
    'label' => 'LBL_REQUISITION_NUMBER',
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
  'STATUS_REQUISITION' => 
  array (
    'type' => 'dynamicenum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS_REQUISITION',
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
  'AUTHORIZED_DATE' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_AUTHORIZED_DATE',
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
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
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
  'CXP_PURCHASE_REQUISITION_CM01_PEDIDO_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CXP_PURCHASE_REQUISITION_CM01_PEDIDO_FROM_CM01_PEDIDO_TITLE',
    'id' => 'CXP_PURCHASE_REQUISITION_CM01_PEDIDOCM01_PEDIDO_IDA',
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
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'AUTHRORIZED_BY' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AUTHRORIZED_BY',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
