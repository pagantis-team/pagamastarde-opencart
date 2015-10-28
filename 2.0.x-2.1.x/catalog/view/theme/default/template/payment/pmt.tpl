<form style="display:none" action="<?php echo $action; ?>" method="post" id="pmtCheckout">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
<input type="hidden" name="amount" value="<?php echo $total; ?>" />
<input type="hidden" name="currency" value="<?php echo $currency_code; ?>" />
<input type="hidden" name="description" value="<?php echo $description; ?>" />
<input type="hidden" name="ok_url" value="<?php echo $redirector_success; ?>" />
<input type="hidden" name="nok_url" value="<?php echo $redirector_failure; ?>" />
<input type="hidden" name="locale" value="<?php echo $locale; ?>" />
<input type="hidden" name="full_name" value="<?php echo $full_name; ?>" />
<input type="hidden" name="email" value="<?php echo $email; ?>" />
<?php
foreach ($products as $i => $p ){
?>
<input name="items[<?php echo $i; ?>][description]" type="hidden" value="<?php echo $p['description']; ?>">
<input name="items[<?php echo $i; ?>][quantity]" type="hidden" value="<?php echo $p['quantity']; ?>">
<input name="items[<?php echo $i; ?>][amount]" type="hidden" value="<?php echo $p['amount']; ?>">
<?php
}
?>
<input type="hidden" name="address[street]" value="<?php echo $street; ?>" />
<input type="hidden" name="address[city]" value="<?php echo $city; ?>" />
<input type="hidden" name="address[province]" value="<?php echo $province; ?>" />
<input type="hidden" name="address[zipcode]" value="<?php echo $citycode; ?>" />
<input type="hidden" name="account_id" value="<?php echo $customer_code; ?>" />
<input type="hidden" name="signature" value="<?php echo $signature; ?>" />
<input type="hidden" name="callback_url" value="<?php echo $callback; ?>" />
<input type="hidden" name="discount[full]" value="<?php echo $discount; ?>" />
</form>
<div class="buttons">
    <div class="pull-right">
    <input onclick="confirmSubmit();" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" type="button">
  </div>
</div>
<script type="text/javascript">
			<!--
			function confirmSubmit() {
				$('#pmtCheckout').submit();
			}
			//-->
</script>
