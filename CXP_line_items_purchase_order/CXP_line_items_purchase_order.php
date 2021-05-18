<?php
require_once("modules/CXP_line_items_purchase_order/CXP_line_items_purchase_order_sugar.php");
class CXP_line_items_purchase_order extends CXP_line_items_purchase_order_sugar
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save_lines($data, $parent)
    {
        global $sugar_config;

        $line_count = isset($data['product_name']) ? count($data['product_name']) : 0;
        $GLOBALS['log']->debug("hi from save lines");
        $GLOBALS['log']->debug(print_r($data, true));
        $index = 0;
        for ($i=0; $i <= $line_count ; $i++) { 
            if (isset($data['product_name'][$i])) {
                if (isset($data['product_deleted'][$i]) && $data['product_deleted'][$i] == 1) {
                    $this->mark_deleted($data['line_item_id'][$i]);
                } else {
                    if (!isset($data['line_item_id'][$i])) {
                        //LoggerManager::getLogger()->warn('Post date has no key id');
                        $postDataKeyIdI = 0;
                    } else {
                        $postDataKeyIdI = $data['line_item_id'][$i];
                    }
                    $GLOBALS['log']->debug("POST DATA ID ", $postDataKeyIdI);
                    $product = BeanFactory::getBean('CXP_line_items_purchase_order', $postDataKeyIdI);
                    if (!$product) {
                        $product = BeanFactory::newBean('CXP_line_items_purchase_order');
                    }
                    foreach ($this->field_defs as $field_def) {
                        $field_name = $field_def['name'];
                        if (isset($data['product_'.$field_name][$i]) && $field_name != 'id') {
                            $product->$field_name = $data['product_'.$field_name][$i];
                        }
                    }
                    if (trim($product->name) != '') {
                        $product->number_line = ++$j;
                        $product->assigned_user_id = $parent->assigned_user_id;
                        $product->currency_id = $parent->currency_id;

                        $product_id = $data['product_id'][$i];
                        $unit_measurement_id = $data['product_unit_measurement_id'][$i];
                        $product->cxp_unit_measure_id_c = $unit_measurement_id;
                        $product->cxp_purchase_order_id_c = $parent->id;
                        
                        // SET PRODUCT RELATIONSHIP TO LINE IN REQUISITION
                        $product->parent_id = $product_id;
                        $parent_type = $product->type === "input" ? "AOS_Products" : "CXP_raw_material_product";
                        $product->parent_type = $parent_type;

                        //Setting product line unit relationship
                        require_once('modules/Relationships/Relationship.php');
                        $key = Relationship::retrieve_by_modules('CXP_line_items_purchase_order', 'CXP_unit_measure', $GLOBALS['db']);
                        if (!empty($key)) {
                            $product->load_relationship($key);
                            $product->$key->add($unit_measurement_id);
                            $product->save();
                        }

                        $product->save();
                        $_POST['product_id'][$i] = $product->id;
                    }
                }
            }
        }
    }

    public function mark_deleted($id)
    {
        $productQuote = new AOS_Products_Quotes();
        $productQuote->mark_lines_deleted($this);
        parent::mark_deleted($id);
    }
}
?>