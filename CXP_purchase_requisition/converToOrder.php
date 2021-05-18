<?php
/*
* Code overwritten by: Isaac Rojas (isaac.rojas@laimu.mx)
* Financed by: https://laimu.mx/ (info@laimu.mx)
*/
    if (!(ACLController::checkAccess('CXP_purchase_order', 'edit', true))) {
        ACLController::displayNoAccess();
        die;
    }
    include_once('modules/CXP_purchase_requisition/CXP_purchase_requisition.php');
    include_once('modules/CXP_purchase_order/CXP_purchase_order.php');
    include_once('modules/CXP_line_items_purchase_order/CXP_line_items_purchase_order.php');
    
    $cxp_purchase_requisition = new CXP_purchase_requisition();
    $cxp_purchase_requisition->retrieve($_REQUEST['record']);
    $cxp_purchase_requisition->status_requisition = "send";
    $cxp_purchase_requisition->save();

    $cxp_purchase_order = new CXP_purchase_order();
    $rawRow = $cxp_purchase_requisition->fetched_row;
    $rawRow['id'] = '';
    $rawRow['requisition_number'] = '';
    $cxp_purchase_order->populateFromRow($rawRow);
    $cxp_purchase_order->process_save_dates =false;
    $cxp_purchase_order->status_order = "draft";
    $cxp_purchase_order->save();

    //Setting requisition relationship
    require_once('modules/Relationships/Relationship.php');
    $key = Relationship::retrieve_by_modules('CXP_purchase_requisition', 'CXP_purchase_order', $GLOBALS['db']);
    if (!empty($key)) {
        $cxp_purchase_requisition->load_relationship($key);
        $cxp_purchase_requisition->$key->add($cxp_purchase_order->id);
    }

    $sql = "SELECT * FROM CXP_line_items_purchase_requisition pg  WHERE pg.cxp_purchase_requisition_id_c='".$cxp_purchase_requisition->id."' AND pg.deleted = 0 ";
    
    $result = $this->bean->db->query($sql);
    while ($row = $this->bean->db->fetchByAssoc($result)) {
        $row['id'] = '';
        $row['cxp_purchase_order_id_c'] = $cxp_purchase_order->id;

        if ($row['price'] != null) {
            $row['price'] = format_number($row['price']);
        }
        if ($row['total_price'] != null) {
            $row['total_price'] = format_number($row['total_price']);
        }
        $cxp_line_items = new CXP_line_items_purchase_order();
        $cxp_line_items->populateFromRow($row);
        $cxp_line_items->save();
    }

    ob_clean();
    header('Location: index.php?module=CXP_purchase_order&action=EditView&record='.$cxp_purchase_order->id);
?>