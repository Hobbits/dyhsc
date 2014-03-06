<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Sun Jun 13 16:57:34 CST 2010
	***********************************************
	*/
	
	function get_nav_info($id,$table,&$dbo){
		$sql = "SELECT * FROM $table WHERE id='$id'";
		return $arr = $dbo->getRow($sql);
	}
	function  get_nav_list($table,&$dbo,$postion=''){
		$sql="SELECT * FROM $table";
		if ($postion) {
			$sql.="WHERE postion='$postion' ";
		}
		$sql.=" order by short_order";
		return $res = $dbo->getRs($sql);
	}
?>