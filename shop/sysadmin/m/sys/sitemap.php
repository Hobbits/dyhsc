<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;

require("../foundation/csitemap.php");

if(file_exists($webRoot.'cache/'.'cachesitemap.txt')){
	$out=file_get_contents($webRoot.'cache/'.'cachesitemap.txt');
	list($tindex,$uindex,$tshop,$ushop,$tcategory,$ucategory,$tactivity,$uactivity,$tbrand,$ubrand,$tgoods,$ugoods)=explode("|",$out);

}

$tb_settings=$tablePreStr."settings";


dbtarget('r',$dbServs);
$dbo=new dbex;

$sql="select * from $tb_settings";
$result=$dbo->getRs($sql);
if($result){
	foreach($result as $v){
		$SYSINFO[$v['variable']]=$v['value'];
	}
}
$pu=array(1,0.9,0.8,0.7,0.6,0.5,0.4,0.3,0.2,0.1);
//时间设置
$adtime = array(
"always"=>$a_langpackage->a_alway_update,//"一直更新",
"hourly"=>$a_langpackage->a_hour_ever,//"小时",
"daily"=>$a_langpackage->a_day2,//"天",
"weekly"=>$a_langpackage->a_week,//"周",
"monthly"=>$a_langpackage->a_month2,//"月",
"yearly"=>$a_langpackage->a_year,//"年",
"never"=>$a_langpackage->a_never_update,//"从不更新",
);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span {color:red;}
.green {color:green;}
.red {color:red;}
#upload_img span {display:block; margin-left:10px;}
</style>
</head>
<body>
<div id="maincontent">
    <div class="wrap">
        <div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_promotion_manage; ?> &gt;&gt; <?php echo $a_langpackage->a_m_sitemap;?></div>
    	<hr />
        <div class="infobox">
        	<h3><?php echo $a_langpackage->a_m_sitemap;?></h3>

            <div class="form-table">
			<table width="100%">
			<tr><td><?php echo $a_langpackage->a_sitemaps_note; ?></td></tr>
			<tr><td style="color:#F00;"></td></tr>
			</table>
            </div>
            <div class="content" style="margin:10px auto; padding:10px 0px">
            <form method="post" action="a.php?act=sitemap" name="theForm"><table width="100 align="center">
                <tr>
                    <td class="" align="right" style ="padding-right:5px" width="30%"><?php echo $a_langpackage->a_homepage_changefreq; ?></td>
                    <td>
                        <select name="tindex_priority">
                        <?php
                        foreach ($pu AS $item){
                        ?>
                                <option value = "<?php echo $item;?>" <?php if(!empty($tindex)&&$item==$tindex) {echo 'selected';} ?>> <?php echo $item;?></option>
                        <?php }?>
                        </select>&nbsp<select name="uindex_changefreq">
                       <?php
                        foreach ($adtime AS $key=>$value){
                        ?>
                                <option value = "<?php echo $key;?>" <?php if(!empty($uindex)&&$key==$uindex) {echo 'selected';} ?>> <?php echo $value;?></option>
                        <?php }?>
                    	</select></td>
                </tr>
                <tr>
                    <td class="" align="right" style ="padding-right:5px"><?php echo $a_langpackage->a_shop_changefreq; ?></td>
                    <td><select name="tshop_priority">
						<?php
                        foreach ($pu AS $item){
                            echo $item;
                        ?>
                            <option value = "<?php echo $item;?>" <?php if(!empty($tshop)&&$item==$tshop) {echo 'selected';} ?> > <?php echo $item;?></option>
                    	<?php }?>
                    	</select>&nbsp<select name="ushop_changefreq">
                  		<?php
                   		 foreach ($adtime AS $key=>$value){
						?>
								<option value = "<?php echo $key;?>"<?php if(!empty($ushop)&&$key==$ushop) {echo 'selected';} ?>> <?php echo $value;?></option>
						<?php }?>
                  		</select></td>
                </tr>
                <tr>
                        <td class="" align="right" style ="padding-right:5px"><?php echo $a_langpackage->a_category_changefreq; ?></td>
                        <td><select name="tcategory_priority">
							<?php
                            foreach ($pu AS $item){
                                echo $item;
                            ?>
                                    <option value = "<?php echo $item;?>" <?php if(!empty($tcategory)&&$item==$tcategory) {echo 'selected'; }?> > <?php echo $item;?></option>
                            <?php }?>
                            </select>&nbsp<select name="ucategory_changefreq">
                           <?php
                            foreach ($adtime AS $key=>$value){
                            ?>
                                    <option value = "<?php echo $key;?>" <?php if(!empty($ucategory)&&$key==$ucategory){ echo 'selected';} ?>> <?php echo $value;?></option>
                            <?php }?>
                     	    </select></td>
                </tr>

                 <tr>
                        <td class="" align="right" style ="padding-right:5px"><?php echo $a_langpackage->a_activity_changefreq; ?></td>
                        <td><select name="tactivity_priority">
							<?php
                            foreach ($pu AS $item){
                                echo $item;
                            ?>
                                    <option value = "<?php echo $item;?>" <?php if(!empty($tactivity)&&$item==$tactivity) {echo 'selected'; }?> > <?php echo $item;?></option>
                            <?php }?>
                            </select>&nbsp<select name="uactivity_changefreq">
                           <?php
                            foreach ($adtime AS $key=>$value){
                            ?>
                                    <option value = "<?php echo $key;?>" <?php if(!empty($uactivity)&&$key==$uactivity){ echo 'selected';} ?>> <?php echo $value;?></option>
                            <?php }?>
                     	    </select></td>
                </tr>

                 <tr>
                        <td class="" align="right" style ="padding-right:5px"><?php echo $a_langpackage->a_brand_changefreq; ?></td>
                        <td><select name="tbrand_priority">
							<?php
                            foreach ($pu AS $item){
                                echo $item;
                            ?>
                                    <option value = "<?php echo $item;?>" <?php if(!empty($tbrand)&&$item==$tbrand) {echo 'selected'; }?> > <?php echo $item;?></option>
                            <?php }?>
                            </select>&nbsp<select name="ubrand_changefreq">
                           <?php
                            foreach ($adtime AS $key=>$value){
                            ?>
                                    <option value = "<?php echo $key;?>" <?php if(!empty($ubrand)&&$key==$ubrand){ echo 'selected';} ?>> <?php echo $value;?></option>
                            <?php }?>
                     	    </select></td>
                </tr>

                <tr>
                        <td class="" align="right" style ="padding-right:5px"><?php echo $a_langpackage->a_goods_changefreq; ?></td>
                        <td><select name="tgoods_priority">
							<?php
                            foreach ($pu AS $item){
                                echo $item;
                            ?>
                                    <option value = "<?php echo $item;?>" <?php if(!empty($tgoods)&&$item==$tgoods) {echo 'selected'; }?> > <?php echo $item;?></option>
                            <?php }?>
                            </select>&nbsp<select name="ugoods_changefreq">
                           <?php
                            foreach ($adtime AS $key=>$value){
                            ?>
                                    <option value = "<?php echo $key;?>" <?php if(!empty($ugoods)&&$key==$ugoods){ echo 'selected';} ?>> <?php echo $value;?></option>
                            <?php }?>
                     	    </select></td>
                </tr>
                <tr>

                            <td colspan="2" style ="padding-left:380px">
                            <input type="submit" value="<?php echo $a_langpackage->a_submit; ?>" class="regular-button" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="reset" value="<?php echo $a_langpackage->a_button_reset; ?>" class="regular-button" />
                            </td>
                </tr>
            </table></form>
            </div>
        </div>
    </div>
</div>

</body>
</html>