<?php
$module_name = 'CXP_purchase_requisition';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 
          array (
            'customCode' => '<input type="submit" class="button" onClick="this.form.action.value=\'converToOrder\';" value="Convertir a Orden de Compra">',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => 'Convertir a Orden de Compra',
              'htmlOptions' => 
              array (
                'class' => 'button',
                'id' => 'convert_order_button',
                'title' => 'Convertir a Orden de Compra',
                'onclick' => 'this.form.action.value=\'converToOrder\';',
                'name' => 'Convert To Order',
              ),
            ),
          ),
          3 => 'DELETE',
          4 => 'FIND_DUPLICATES',
        ),
      ),
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
        'LBL_EDITVIEW_PANEL4' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL5' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'requisition_number',
            'label' => 'LBL_REQUISITION_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status_requisition',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_REQUISITION',
          ),
          1 => 'assigned_user_name',
        ),
        2 => 
        array (
          0 => 'description',
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'authrorized_by',
            'studio' => 'visible',
            'label' => 'LBL_AUTHRORIZED_BY',
          ),
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'authorized_date',
            'label' => 'LBL_AUTHORIZED_DATE',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'is_authorized',
            'label' => 'LBL_IS_AUTHORIZED',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel5' => 
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
      ),
    ),
  ),
);
;
?>
