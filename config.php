<?php 
require_once("codebase/connector/scheduler_connector.php");
 
$res=mysql_connect("localhost","root","");
mysql_select_db("schedulerDB");
 
    $list = new OptionsConnector($res, $dbtype);
    $list->render_table("types","type_id","type_id(value),name(label)");
 
    $scheduler = new schedulerConnector($res, $dbtype);
    //we set the same name that was used on the client side - 'sections'
    $scheduler->set_options("sections", $list); 
    $scheduler->render_table("events","id","start_date,end_date,text,address,phone,email,sold_by,comment,type_id,subject,description,howto,cot_bool,ficha_bool,payment_method,facturanombre,apar_bool,nit,cost,personal,created_by,edited_by");

?>