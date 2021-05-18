<?php
/**
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

function display_lines($focus, $field, $value, $view)
{
    global $sugar_config, $locale, $app_list_strings, $mod_strings;

    $enable_groups = (int)$sugar_config['aos']['lineItems']['enableGroups'];
    $total_tax = (int)$sugar_config['aos']['lineItems']['totalTax'];

    $html = '';
    $html .= '<link rel="stylesheet" href="modules/CXP_line_items_purchase_order/css/style.css">';

    if ($view == 'EditView') {
        $html .= '<script src="modules/CXP_line_items_purchase_order/js/line_items.js"></script>'; 
        
        if (file_exists('custom/modules/ADM_products_po/line_items.js')) {
            $html .= '<script src="custom/modules/ADM_products_po/line_items.js"></script>';
        }
        $html .= '<script language="javascript">var sig_digits = '.$locale->getPrecision().';';
        $html .= 'var module_sugar_grp1 = "'.$focus->module_dir.'";';
        $html .= 'var enable_groups = '.$enable_groups.';';
        $html .= 'var total_tax = '.$total_tax.';';
        $html .= '</script>';

        $html .= "<table border='0' cellspacing='4' id='lineItems'></table>";

        if ($enable_groups) {
            $html .= "<div style='padding-top: 10px; padding-bottom:10px;'>";
            $html .= "<script>
                        insertGroup(0);
                    </script>";
            //$html .= "<input type=\"button\" tabindex=\"116\" class=\"button\" value=\"".$mod_strings['LBL_ADD_GROUP']."\" id=\"addGroup\" onclick=\"insertGroup(0)\" />";
            $html .= "</div>";
        }
        $html .= '<input type="hidden" name="vathidden" id="vathidden" value="'.get_select_options_with_id($app_list_strings['vat_list'], '').'">
				  <input type="hidden" name="discounthidden" id="discounthidden" value="'.get_select_options_with_id($app_list_strings['discount_list'], '').'">';
        if ($focus->id != '') {
            require_once('modules/CXP_line_items_purchase_requisition/CXP_line_items_purchase_requisition.php');

            $sql = "SELECT pg.id FROM cxp_line_items_purchase_order pg  WHERE pg.cxp_purchase_order_id_c='".$focus->id."' AND pg.deleted = 0 ";

            $result = $focus->db->query($sql);
            $html .= "<script>
                if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}
                </script>";

            while ($row = $focus->db->fetchByAssoc($result)) {
                $line_item = BeanFactory::newBean('CXP_line_items_purchase_order');
                $line_item->retrieve($row['id'], false);
                $line_item = json_encode($line_item->toArray());

                $html .= "<script>
                        insertLineItems(" . $line_item . ");
                    </script>";
            }
        }
        if (!$enable_groups) {
            $html .= '<script>insertGroup();</script>';
        }
    } elseif ($view == 'DetailView') {
        $params = array('currency_id' => $focus->currency_id);

        $sql = "SELECT pg.id FROM cxp_line_items_purchase_order pg  WHERE pg.cxp_purchase_order_id_c='".$focus->id."' AND pg.deleted = 0 ";

        $result = $focus->db->query($sql);
        $sep = get_number_separators();

        $html .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

        $i = 0;
        $productCount = 0;
        $serviceCount = 0;
        $group_id = '';
        $groupStart = '';
        $groupEnd = '';
        $product = '';
        $service = '';

        while ($row = $focus->db->fetchByAssoc($result)) {
            $line_item = new CXP_line_items_purchase_order();
            $line_item->retrieve($row['id']);

            $unit_measurement = BeanFactory::getBean("CXP_unit_measure", $line_item->cxp_unit_measure_id_c);

            if ($i == 0) {
                $html .= $groupStart.$product.$service.$groupEnd;
                if ($i != 0) {
                    $html .= "<tr><td colspan='9' nowrap='nowrap'><br></td></tr>";
                }
                $groupStart = '';
                $groupEnd = '';
                $product = '';
                $service = '';
                $i = 1;
                $productCount = 0;
                $serviceCount = 0;
                $group_id = $row['group_id'];

               
                $groupEnd .= "</tr>";
            }

            if ($line_item->id != '0') {
                if ($productCount == 0) {
                    $product .= "<tr>";
                    $product .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>&nbsp;</td>";
                    $product .= "<td width='10%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>Producto</td>";
                    $product .= "<td width='30%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>Descripción</td>";
                    $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>Unidad de Medida</td>";
                    $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>Cantidad</td>";
                    $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>Precio Unitario</td>";
                    $product .= "<td width='12%' class='tabDetailViewDL' style='text-align: right;padding:2px;' scope='row'>Total</td>";
                    $product .= "</tr>";
                }

                $product .= "<tr>";
                $product_note = wordwrap($line_item->description, 40, "<br />\n");

                $product .= "<td class='tabDetailViewDF' style='text-align: left; padding:2px;'>".++$productCount."</td>";

                $product .= "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=AOS_Products&action=DetailView&record=".$line_item->id."' class='tabDetailViewDFLink'>".$line_item->name."</a><br /></td>";

                $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".$product_note."</td>";

                $product .= "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=AOS_Products&action=DetailView&record=".$unit_measurement->id."' class='tabDetailViewDFLink'>".$unit_measurement->name."</a><br /></td>";

                $product .= "<td class='tabDetailViewDF' style='padding:2px;'>".stripDecimalPointsAndTrailingZeroes(format_number($line_item->quantity), $sep[1])."</td>";

                $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->price, $params)."</td>";


                $product .= "<td class='tabDetailViewDF' style='text-align: right; padding:2px;'>".currency_format_number($line_item->total_price, $params)."</td>";
                
                $product .= "</tr>";
            }
        }
        $html .= $groupStart.$product.$service.$groupEnd;
        $html .= "</table>";
    }
    return $html;
}

//Bug #598
//The original approach to trimming the characters was rtrim(rtrim(format_number($line_item->product_qty), '0'),$sep[1])
//This however had the unwanted side-effect of turning 1000 (or 10 or 100) into 1 when the Currency Significant Digits
//field was 0.
//The approach below will strip off the fractional part if it is only zeroes (and in this case the decimal separator
//will also be stripped off) The custom decimal separator is passed in to the function from the locale settings
function stripDecimalPointsAndTrailingZeroes($inputString, $decimalSeparator)
{
    return preg_replace('/'.preg_quote($decimalSeparator).'[0]+$/', '', $inputString);
}

function get_discount_string($type, $amount, $params, $locale, $sep)
{
    if ($amount != '' && $amount != '0.00') {
        if ($type == 'Amount') {
            return currency_format_number($amount, $params)."</td>";
        } elseif ($locale->getPrecision()) {
            return rtrim(rtrim(format_number($amount), '0'), $sep[1])."%";
        }
        return format_number($amount)."%";
    }
    return "-";
}

function display_shipping_vat($focus, $field, $value, $view)
{
    if ($view == 'EditView') {
        global $app_list_strings;

        if ($value != '') {
            $value = format_number($value);
        }

        $html = "<input id='shipping_tax_amt' type='text' tabindex='0' title='' value='".$value."' maxlength='26,6' size='22' name='shipping_tax_amt' onblur='calculateTotal(\"lineItems\");'>";
        $html .= "<select name='shipping_tax' id='shipping_tax' onchange='calculateTotal(\"lineItems\");' >".get_select_options_with_id($app_list_strings['vat_list'], (isset($focus->shipping_tax) ? $focus->shipping_tax : ''))."</select>";

        return $html;
    }
    return format_number($value);
}
