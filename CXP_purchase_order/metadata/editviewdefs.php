<?php
$module_name = 'CXP_purchase_order';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'payment_method',
            'studio' => 'visible',
            'label' => 'LBL_PAYMENT_METHOD',
          ),
          1 => 
          array (
            'name' => 'payment_terms',
            'studio' => 'visible',
            'label' => 'LBL_PAYMENT_TERMS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status_order',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_ORDER',
          ),
          1 => 'assigned_user_name',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'cxp_purchase_order_cxp_suppliers_name',
            'label' => 'LBL_CXP_PURCHASE_ORDER_CXP_SUPPLIERS_FROM_CXP_SUPPLIERS_TITLE',
          ),
          1 => 
          array (
            'name' => 'cxp_purchase_order_cxp_purchase_requisition_name',
            'label' => 'LBL_CXP_PURCHASE_ORDER_CXP_PURCHASE_REQUISITION_FROM_CXP_PURCHASE_REQUISITION_TITLE',
          ),
        ),
        3 => 
        array (
          0 => 'description',
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'authorized_by',
            'studio' => 'visible',
            'label' => 'LBL_AUTHORIZED_BY',
          ),
          1 => 
          array (
            'name' => 'authorized_date',
            'label' => 'LBL_AUTHORIZED_DATE',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'line_items',
            'studio' => 'visible',
            'label' => 'LBL_LINE_ITEMS',
          ),
        ),
        1 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'subtotal_one',
            'label' => 'LBL_SUBTOTAL_ONE',
          ),
        ),
        2 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'discount',
            'label' => 'LBL_DISCOUNT',
          ),
        ),
        3 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'subtotal_two',
            'label' => 'LBL_SUBTOTAL_TWO',
          ),
        ),
        4 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'withholdings',
            'label' => 'LBL_WITHHOLDINGS',
          ),
        ),
        5 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'iva',
            'label' => 'LBL_IVA',
          ),
        ),
        6 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'neto_total',
            'label' => 'LBL_NETO_TOTAL',
          ),
        ),
      ),
    ),
  ),
);
;
?>
