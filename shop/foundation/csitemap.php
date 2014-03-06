<?php
  class sitemap{
     var $head = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
     var $footer="</urlset>\n";
     var $item;
     function item($item){
     	$this->item.="<url>\n";
        foreach($item as $key=>$val){
        	$this->item.="<$key>".htmlentities($val,ENT_QUOTES)."</$key>\n";;
        }
        $this->item.="</url>\n";
     }
	function generate(){
		$all=$this->head;
		$all.=$this->item;
		$all.=$this->footer;
		return $all;
	}


  }
?>
