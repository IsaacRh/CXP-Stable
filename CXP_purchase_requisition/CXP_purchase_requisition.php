<?php
require_once('modules/CXP_purchase_requisition/CXP_purchase_requisition_sugar.php');
class CXP_purchase_requisition extends CXP_purchase_requisition_sugar
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save($check_notify = false)
    {
        global $sugar_config;
        $return_id = parent::save($check_notify);
        require_once('modules/CXP_line_items_purchase_requisition/CXP_line_items_purchase_requisition.php');
        $lines = new CXP_line_items_purchase_requisition();
        $lines->save_lines($_POST, $this);
        return $return_id;
    }

    public function mark_deleted($id)
    {
        $productQuote = new AOS_Products_Quotes();
        $productQuote->mark_lines_deleted($this);
        parent::mark_deleted($id);
    }
}
