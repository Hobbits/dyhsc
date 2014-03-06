<html>
<body onLoad="javascript:document.payForm.submit()">
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"> 
      <form name="payForm" action="https://www.cncard.net/purchase/getorder.asp" method="POST">
			<input type="hidden" name="c_mid" value="<?=$c_mid?>">
			<input type="hidden" name="c_order" value="<?=$c_order?>">
			<input type="hidden" name="c_name" value="<?=$c_name?>">
			<input type="hidden" name="c_address" value="<?=$c_address?>">
			<input type="hidden" name="c_tel" value="<?=$c_tel?>">
			<input type="hidden" name="c_post" value="<?=$c_post?>">
			<input type="hidden" name="c_email" value="<?=$c_email?>">
			<input type="hidden" name="c_orderamount" value="<?=$c_orderamount?>">
			<input type="hidden" name="c_ymd" value="<?=$c_ymd?>">
			<input type="hidden" name="c_moneytype" value="<?=$c_moneytype?>">
			<input type="hidden" name="c_retflag" value="<?=$c_retflag?>">
			<input type="hidden" name="c_paygate" value="<?=$c_paygate?>">
			<input type="hidden" name="c_returl" value="<?=$c_returl?>">
			<input type="hidden" name="c_memo1" value="<?=$c_memo1?>">
			<input type="hidden" name="c_memo2" value="<?=$c_memo2?>">
			<input type="hidden" name="c_language" value="<?=$c_language?>">
			<input type="hidden" name="notifytype" value="<?=$notifytype?>">
			<input type="hidden" name="c_signstr" value="<?=$c_signstr?>">
      </form>
	</td>
  </tr>
</table>
</body>
</html>