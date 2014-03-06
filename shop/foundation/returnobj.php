<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

class returnobj {
	public $status;
	public $result;
	public $addon;
	function __construct($status='ok',$result='',$addon='') {
		$this->status = $status;
		$this->result = $result;
		$this->addon = $addon;
	}
}
?>
