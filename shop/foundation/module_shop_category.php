<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
function getnbsp($i) {
	$str = '';
	if($i) {
		for($j=0; $j<$i; $j++) {
			$str .= "　";
		}
	}
	return $str;
}

function get_dg_category($array,$parentid=0,$level=0,$add=2) {
	$str_pad = getnbsp($level);
	$newarray = array();
	$temp = array();
	foreach($array as $v) {
		if($v['parent_id'] == $parentid) {
			$newarray[] = array(
				'cat_id' => $v['cat_id'],
				'cat_name' => $v['cat_name'],
				'parent_id' => $v['parent_id'],
				'shops_num' => $v['shops_num'],
				'sort_order' => $v['sort_order'],
				'str_pad' => $str_pad
			);
			$temp = get_dg_category($array,$v['cat_id'],($level+$add));
			if($temp) {
				$newarray = array_merge($newarray, $temp);
			}
		}
	}
	return $newarray;
}

function get_dg_category_select($array,$parentid=0,$level=0,$add=2) {
	$str_pad = getnbsp($level);
	$newarray = array();
	$temp = array();
	foreach($array as $v) {
		if($v['parent_id'] == $parentid) {
			$newarray[] = array(
				'cat_id' => $v['cat_id'],
				'cat_name' => $v['cat_name'],
				'parent_id' => $v['parent_id'],
				'shops_num' => $v['shops_num'],
				'sort_order' => $v['sort_order'],
				'str_pad' => $str_pad
			);
			//$temp = get_dg_category($array,$v['cat_id'],($level+$add));
			if($temp) {
				$newarray = array_merge($newarray, $temp);
			}
		}
	}
	return $newarray;
}

function insert_category_info(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
//	echo $sql;
	$suc=$dbo->exeUpdate($sql);
	if($suc){
		return mysql_insert_id();
	}else{
		return false;
	}
}
function update_category_info($dbo,$table,$update_items,$cat_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where cat_id='$cat_id'";
	return $dbo->exeUpdate($sql);
}

function get_categories_info_item(&$dbo,$select_items,$table)
{
	$item_sql = get_select_item($select_items);
	$sql = "select $item_sql from `$table`";
	return $dbo->getRs($sql);
}

function get_categories_item_parentid(&$dbo,$table,$parent_id)
{
	$sql = "select cat_id,cat_name from `$table` where parent_id=$parent_id";
	return $dbo->getRs($sql);
}
function get_categories_info_catid(&$dbo,$table,$cat_id)
{
	$sql = "select * from `$table` where cat_id=$cat_id";
	return $dbo->getRow($sql);
}

function get_categories_info(&$dbo,$table)
{
	return get_categories_info_item($dbo,'*',$table);
}

function get_categories_rank($cat,&$dbo,$table)
{
    if ($cat == 0){
        return array();
    }
    $arr = $dbo->getRs("SELECT cat_id,cat_name, parent_id FROM `$table`");
    if (empty($arr)){
        return array();
    }
    $index = 0;
    $cats  = array();
    while (1){
        foreach ($arr AS $row){
            if ($cat == $row['cat_id']){
                $cat = $row['parent_id'];
                $cats[$index]['cat_id'] = $row['cat_id'];
                $cats[$index]['cat_name'] = $row['cat_name'];
                $index++;
                break;
            }
        }
        if ($index == 0 || $cat == 0){
            break;
        }
    }
    return array_reverse($cats);
}


?>