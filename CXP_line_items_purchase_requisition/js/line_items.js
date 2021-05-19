/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

 $(document).ready(() => {
  document.querySelector("[data-label='LBL_LINE_ITEMS']").innerHTML = "Partidas";
});
 var lineno;
 var prodln = 0;
 var servln = 0;
 var groupn = 0;
 var group_ids = {};
 
 
 /**
  * Load Line Items
  */
 
function insertLineItems(product){
    var type = 'product_';
    var ln = 0;
    var current_group = 'lineItems';
    console.log(product);
    if(product.id != '0' && product.id !== ''){
      ln = insertProductLine('product_group0',0);
      $("#line_item_id" + ln).val(product.id);
      type = 'product_';
    }

    for(var p in product){
      console.log("P => ", p);
      if(p === "id"){
        console.log("P in ID => ", product[p]);
        // $("#product_requisition_id" + ln).val(product[p]);
      }else{
        if(document.getElementById(type + p + ln) !== null){
          if (product[p] !== '' && isNumeric(product[p]) && p !== 'vat' && p !== 'product_id' && p !== 'name' && p !== "part_number" && p !== "description" && p !== "item_description") {
              document.getElementById(type + p + ln).value = format2Number(product[p]);
          } else {
              document.getElementById(type + p + ln).value = product[p];
          }
        }
      }
    }
    $("#product_unit_measurement_name" + ln).val(product.unit_id);
    $("#product_unit_measurement_id" + ln).val(product.cxp_unit_measure_id_c);
}
 
 
 /**
  * Insert product line
  */
 
function insertProductLine(tableid, groupid, productType) {
 
   if(!enable_groups){
     tableid = "product_group0";
   }
 
   if (document.getElementById(tableid + '_head') !== null) {
     document.getElementById(tableid + '_head').style.display = "";
   }
 
   var vat_hidden = document.getElementById("vathidden").value;
   var discount_hidden = document.getElementById("discounthidden").value;
 
   sqs_objects["product_name[" + prodln + "]"] = {
     "form": "EditView",
     "method": "query",
     "modules": ["AOS_Products"],
     "group": "or",
     "field_list": ["name", "id", "part_number", "cost", "price", "description", "currency_id"],
     "populate_list": ["product_name[" + prodln + "]", "product_product_id[" + prodln + "]", "product_part_number[" + prodln + "]", "product_product_cost_price[" + prodln + "]", "product_product_list_price[" + prodln + "]", "product_item_description[" + prodln + "]", "product_currency[" + prodln + "]"],
     "required_list": ["product_id[" + prodln + "]"],
     "conditions": [{
       "name": "name",
       "op": "like_custom",
       "end": "%",
       "value": ""
     }],
     "order": "name",
     "limit": "30",
     "post_onblur_function": "formatListPrice(" + prodln + ");",
     "no_match_text": "No Match"
   };

    tablebody = document.createElement("tbody");
    tablebody.id = "product_body" + prodln;
    document.getElementById(tableid).appendChild(tablebody);
    
    
    var x = tablebody.insertRow(-1);
    x.id = 'product_line' + prodln;
    
    var name_product = x.insertCell(-1);
    // name_product.style = 'padding-bottom: 10px';
    name_product.innerHTML = "<input class='sqsEnabled product_name' autocomplete='off' type='text' name='product_name[" + prodln + "]' id='product_name" + prodln + "' maxlength='50' value='' title='' tabindex='116' value=''><input type='hidden' name='product_id[" + prodln + "]' id='product_id" + prodln + "'  maxlength='50' value=''><input type='hidden' value='"+productType+"' name='product_type[" + prodln + "]' id='product_type"+prodln+"'>";
    
    var select_product = x.insertCell(-1);
    select_product.innerHTML = "<button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button product_part_number_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='openProductPopup(" + prodln + ");'><span class=\"suitepicon suitepicon-action-select\"></span></button>";
 
    var product_unit_measurement = x.insertCell(-1);
    product_unit_measurement.innerHTML = "<input type='text' name='unit_measurement_name[" + prodln + "]' id='product_unit_measurement_name" + prodln + "'  value='' title='' tabindex='116'><input type='hidden' name='product_unit_measurement_id[" + prodln + "]' id='product_unit_measurement_id" + prodln + "'  maxlength='50' value=''>";

    var select_unti_measurement = x.insertCell(-1);
    select_unti_measurement.innerHTML = "<button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button product_part_number_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='openMeasurementPopup(" + prodln + ");'><span class=\"suitepicon suitepicon-action-select\"></span></button>";
    
    var product_description = x.insertCell(-1);
    product_description.colSpan = '2';
    product_description.innerHTML = "<input type='text' style='width: 90%;' name='product_description[" + prodln + "]' id='product_description" + prodln + "'  value='' title='' tabindex='116'>";
    
    var qty_product = x.insertCell(-1);
    qty_product.innerHTML = "<input type='text' name='product_quantity[" + prodln + "]' id='product_quantity" + prodln + "'  value='' title='' tabindex='116' onblur='validateInput(this);Quantity_format2Number(" + prodln + ");calculateLine(" + prodln + ",\"product_\");' class='product_qty'>";
    
    
    
    var product_price = x.insertCell(-1);
    product_price.innerHTML = "<input type='text' name='product_price[" + prodln + "]' id='product_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' class='product_price' onblur='validateInput(this);calculateLine(" + prodln + ",\"product_\");'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";

    var product_total_price = x.insertCell(-1);
    product_total_price.innerHTML = "<input type='text' name='product_total_price[" + prodln + "]' id='product_total_price" + prodln + "' maxlength='50' value='' title='' tabindex='116' readonly='readonly' class='product_price'><input type='hidden' name='product_group_number[" + prodln + "]' id='product_group_number" + prodln + "' value='"+groupid+"'>";
  
 
    if (typeof currencyFields !== 'undefined'){
        currencyFields.push("product_product_price" + prodln);
    }
    var h = x.insertCell(-1);
    h.innerHTML = "<input type='hidden' name='product_currency[" + prodln + "]' id='product_currency" + prodln + "' value=''><input type='hidden' name='product_deleted[" + prodln + "]' id='product_deleted" + prodln + "' value='0'><input type='hidden' name='line_item_id[" + prodln + "]' id='line_item_id" + prodln + "' value=''><button type='button' id='product_delete_line" + prodln + "' class='button product_delete_line' value='" + SUGAR.language.get(module_sugar_grp1, 'LBL_REMOVE_PRODUCT_LINE') + "' tabindex='116' onclick='markLineDeleted(" + prodln + ",\"product_\")'><span class=\"suitepicon suitepicon-action-clear\"></span></button><br>";
    
    
    enableQS(true);
    //QSFieldsArray["EditView_product_name"+prodln].forceSelection = true;
    
    // addToValidate('EditView','product_id'+prodln,'id',true,"Please choose a product");
 
    addAlignedLabels(prodln, 'product');
    
    prodln++;
    
    return prodln - 1;
}
 
var addAlignedLabels = function(ln, type) {
   if(typeof type == 'undefined') {
     type = 'product';
   }
   if(type != 'product' && type != 'service') {
     console.error('type could be "product" or "service" only');
   }
   var labels = [];
   $('tr#'+type+'_head td').each(function(i,e){
     if(type=='product' && $(e).attr('colspan')>1) {
       for(var i=0; i<parseInt($(e).attr('colspan')); i++) {
         if(i==0) {
           labels.push($(e).html());
         } else {
           labels.push('');
         }
       }
     } else {
       labels.push($(e).html());
     }
   });
   $('tr#'+type+'_line'+ln+' td').each(function(i,e){
     $(e).prepend('<span class="alignedLabel">'+labels[i]+'</span>');
   });
}
 
 
 /**
  * Open product popup
*/

function openProductPopup(ln){
    var type = $('#product_type'+ln).val();
    lineno=ln;
    var popupRequestData = {
        "call_back_function" : "setProductReturn",
        "form_name" : "EditView",
        "field_to_name_array" : {
        "id" : "product_id" + ln,
        "name" : "product_name" + ln,
        "description" : "product_description" + ln,
        "price" : "product_price" + ln, 
        }
    };

    var module = "";
    if (type === 'input') module = "AOS_Products";
    if (type === 'raw') module = "CXP_raw_material_product";
    
    open_popup(module, 800, 850, '', true, true, popupRequestData);
 
}
 
function setProductReturn(popupReplyData){
    console.log(popupReplyData);
    set_return(popupReplyData);
    formatListPrice(lineno);
}

/**
 * Open measurement popup
*/

function openMeasurementPopup(ln){

    lineno = ln;
    var popupRequestData = {
      "call_back_function" : "setMeasurementReturn",
      "form_name" : "EditView",
      "field_to_name_array" : {
        "id" : "product_unit_measurement_id" + ln,
        "name" : "product_unit_measurement_name" + ln,
      }
    };
  
    open_popup('CXP_unit_measure', 800, 850, '', true, true, popupRequestData);
  
}
  
function setMeasurementReturn(popupReplyData){
    set_return(popupReplyData);
    formatListPrice(lineno);
}
 
function formatListPrice(ln){
 
   if (typeof currencyFields !== 'undefined'){
     var product_currency_id = document.getElementById('product_currency' + ln).value;
     product_currency_id = product_currency_id ? product_currency_id : -99;//Assume base currency if no id
     var product_currency_rate = get_rate(product_currency_id);
     var dollar_product_price = ConvertToDollar(document.getElementById('product_product_list_price' + ln).value, product_currency_rate);
     document.getElementById('product_product_list_price' + ln).value = format2Number(ConvertFromDollar(dollar_product_price, lastRate));
     var dollar_product_cost = ConvertToDollar(document.getElementById('product_product_cost_price' + ln).value, product_currency_rate);
     document.getElementById('product_product_cost_price' + ln).value = format2Number(ConvertFromDollar(dollar_product_cost, lastRate));
   }
   else
   {
     document.getElementById('product_product_list_price' + ln).value = format2Number(document.getElementById('product_product_list_price' + ln).value);
     document.getElementById('product_product_cost_price' + ln).value = format2Number(document.getElementById('product_product_cost_price' + ln).value);
   }
 
   calculateLine(ln,"product_");
}
 
/**
 * Insert product Header
 */

function insertProductHeader(tableid){
    tablehead = document.createElement("thead");
    tablehead.id = tableid +"_head";
    tablehead.style.display="none";
    document.getElementById(tableid).appendChild(tablehead);
  
    var x=tablehead.insertRow(-1);
    x.id='product_head';
  
    var product_name = x.insertCell(-1);
    product_name.colSpan = "2";
    product_name.style.color="rgb(68,68,68)";
    product_name.innerHTML = 'Producto';

    var product_unit_measurement=x.insertCell(-1);
    product_unit_measurement.colSpan = '2';
    product_unit_measurement.style.color="rgb(68,68,68)";
    product_unit_measurement.innerHTML= 'U. de Medida';
  
    var product_description=x.insertCell(-1);
    product_description.colSpan = '2';
    product_description.style.color="rgb(68,68,68)";
    product_description.innerHTML= 'Descripción';
  
    var b=x.insertCell(-1);
    b.style.color="rgb(68,68,68)";
    b.innerHTML= 'Cantidad';
  
    var b1=x.insertCell(-1);
    b1.style.color="rgb(68,68,68)";
    b1.innerHTML='Precio Unitario';

    var b1=x.insertCell(-1);
    b1.style.color="rgb(68,68,68)";
    b1.innerHTML='Precio Total';
  
    var h=x.insertCell(-1);
    h.style.color="rgb(68,68,68)";
    h.innerHTML='&nbsp;';
}

 
 /**
  * Insert Group
  */
 
function insertGroup(){
 
   if(!enable_groups && groupn > 0){
     return;
   }
   var tableBody = document.createElement("tr");
   tableBody.id = "group_body"+groupn;
   tableBody.className = "group_body";
   document.getElementById('lineItems').appendChild(tableBody);
 
   var a=tableBody.insertCell(0);
   a.colSpan="100";
   var table = document.createElement("table");
   table.id = "group"+groupn;
   table.className = "group";
 
   table.style.whiteSpace = 'nowrap';
 
   a.appendChild(table);
 
 
   var productTableHeader = document.createElement("thead");
   table.appendChild(productTableHeader);
   var productHeader_row=productTableHeader.insertRow(-1);
   var productHeader_cell = productHeader_row.insertCell(0);
   productHeader_cell.colSpan="100";
   var productTable = document.createElement("table");
   productTable.id = "product_group"+groupn;
   productTable.className = "product_group";
   productHeader_cell.appendChild(productTable);
 
   insertProductHeader(productTable.id);
 
   var input = "input"; var raw = "raw";
 
   tablefooter = document.createElement("tfoot");
   table.appendChild(tablefooter);
   var footer_row=tablefooter.insertRow(-1);
   var footer_cell = footer_row.insertCell(0);
   footer_cell.scope="row";
   footer_cell.colSpan="20";
   footer_cell.innerHTML = "<input type='button' tabindex='116' class='button add_product_line' value='Agregar Producto' id='"+productTable.id+"addProductLine' onclick='insertProductLine(\""+productTable.id+"\",\""+groupn+"\", \""+ input + "\")' />";
   groupn++;
   return groupn -1;
}

 /**
  * Mark Group Deleted
  */
 
function markGroupDeleted(gn){
   document.getElementById('group_body' + gn).style.display = 'none';
 
   var rows = document.getElementById('group_body' + gn).getElementsByTagName('tbody');
 
   for (x=0; x < rows.length; x++) {
     var input = rows[x].getElementsByTagName('button');
     for (y=0; y < input.length; y++) {
       if (input[y].id.indexOf('delete_line') != -1) {
         input[y].click();
       }
     }
   }
 
}
 
 /**
  * Mark line deleted
  */
 
 function markLineDeleted(ln, key)
 {
   // collapse line; update deleted value
   document.getElementById(key + 'body' + ln).style.display = 'none';
   document.getElementById(key + 'deleted' + ln).value = '1';
   document.getElementById(key + 'delete_line' + ln).onclick = '';
   var groupid = 'group' + document.getElementById(key + 'group_number' + ln).value;
 
   if(checkValidate('EditView',key+'product_id' +ln)){
     removeFromValidate('EditView',key+'product_id' +ln);
   }
 
   calculateTotal(groupid);
   calculateTotal();
 }
 
 
/**
* Calculate Line Values
*/
 
function calculateLine(ln, key){
    var qty = unformat2Number($("#product_quantity" + ln).val());
    var unitPrice = unformat2Number($("#product_price" + ln).val()); 
    
    if(qty !== null && qty === ''){
        $('#product_quantity' + ln).val(format2Number(1));
    }
  
    if ($('#product_name' + ln).val() === ''){
      return;
    }
    var totalPrice = eval(qty * unitPrice);

    $('#product_price' + ln).val(format2Number(unitPrice));
    $('#product_total_price' + ln).val(format2Number(totalPrice));
}
 

 
function set_value(id, value){
   if(document.getElementById(id) !== null)
   {
     document.getElementById(id).value = format2Number(value);
   }
}
 
 function get_value(id){
   if(document.getElementById(id) !== null)
   {
     return unformat2Number(document.getElementById(id).value);
   }
   return 0;
 }
 
 
 function unformat2Number(num)
 {
   return unformatNumber(num, num_grp_sep, dec_sep);
 }
 
 function format2Number(str, sig)
 {
   if (typeof sig === 'undefined') { sig = sig_digits; }
   num = Number(str);
   if(sig == 2){
     str = formatCurrency(num);
   }
   else{
     str = num.toFixed(sig);
   }
 
   str = str.split(/,/).join('{,}').split(/\./).join('{.}');
   str = str.split('{,}').join(num_grp_sep).split('{.}').join(dec_sep);
 
   return str;
 }
 
 function formatCurrency(strValue)
 {
   strValue = strValue.toString().replace(/\$|\,/g,'');
   dblValue = parseFloat(strValue);
 
   blnSign = (dblValue == (dblValue = Math.abs(dblValue)));
   dblValue = Math.floor(dblValue*100+0.50000000001);
   intCents = dblValue%100;
   strCents = intCents.toString();
   dblValue = Math.floor(dblValue/100).toString();
   if(intCents<10)
     strCents = "0" + strCents;
   for (var i = 0; i < Math.floor((dblValue.length-(1+i))/3); i++)
     dblValue = dblValue.substring(0,dblValue.length-(4*i+3))+','+
       dblValue.substring(dblValue.length-(4*i+3));
   return (((blnSign)?'':'-') + dblValue + '.' + strCents);
 }
 
 function Quantity_format2Number(ln)
 {
   var str = '';
   var qty=unformat2Number(document.getElementById('product_quantity' + ln).value);
   if(qty === null){qty = 1;}
 
   if(qty === 0){
     str = '0';
   } else {
     str = format2Number(qty);
     if(sig_digits){
       str = str.replace(/0*$/,'');
       str = str.replace(dec_sep,'~');
       str = str.replace(/~$/,'');
       str = str.replace('~',dec_sep);
     }
   }
 
   document.getElementById('product_quantity' + ln).value=str;
 }
 
function formatNumber(n, num_grp_sep, dec_sep, round, precision) {
   if (typeof num_grp_sep == "undefined" || typeof dec_sep == "undefined") {
     return n;
   }
   if(n === 0) n = '0';
 
   n = n ? n.toString() : "";
   if (n.split) {
     n = n.split(".");
   } else {
     return n;
   }
   if (n.length > 2) {
     return n.join(".");
   }
   if (typeof round != "undefined") {
     if (round > 0 && n.length > 1) {
       n[1] = parseFloat("0." + n[1]);
       n[1] = Math.round(n[1] * Math.pow(10, round)) / Math.pow(10, round);
       if(n[1].toString().includes('.')) {
       n[1] = n[1].toString().split(".")[1];
     }
       else {
       n[0] = (parseInt(n[0]) + n[1]).toString();
       n[1] = "";
       }
     }
     if (round <= 0) {
       n[0] = Math.round(parseInt(n[0], 10) * Math.pow(10, round)) / Math.pow(10, round);
       n[1] = "";
     }
   }
   if (typeof precision != "undefined" && precision >= 0) {
     if (n.length > 1 && typeof n[1] != "undefined") {
       n[1] = n[1].substring(0, precision);
     } else {
       n[1] = "";
     }
     if (n[1].length < precision) {
       for (var wp = n[1].length; wp < precision; wp++) {
         n[1] += "0";
       }
     }
   }
   regex = /(\d+)(\d{3})/;
   while (num_grp_sep !== "" && regex.test(n[0])) {
     n[0] = n[0].toString().replace(regex, "$1" + num_grp_sep + "$2");
   }
   return n[0] + (n.length > 1 && n[1] !== "" ? dec_sep + n[1] : "");
 }
 
 function check_form(formname) {
   if (typeof(siw) != 'undefined' && siw && typeof(siw.selectingSomething) != 'undefined' && siw.selectingSomething)
     return false;
   return validate_form(formname, '');
 }
 
function validateInput(el) {
  if(isNaN(el.value)) set_value(el.id, 0); 
}