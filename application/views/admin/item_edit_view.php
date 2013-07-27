<div id="content_title">Items Manager - Edit Item</div>
<?php echo validation_errors("<p align=\"center\">"); ?>

<?php $attributes = array('class' => 'basic_form', 'id' => 'ItemEditForm');
	echo form_open("items/edit/$user_detail[id]", $attributes) ?>
	<table class="data_table" align="center">
		<tr>
			<td><label for="text">Item code</label></td>
			<td>
				<input type="input" name="item_code" value="<?php if ( ! set_value('item_code')) echo htmlspecialchars($user_detail['item_code']) ; else echo set_value('item_code');?>" />
				
			</td>
		</tr>
		<tr>
			<td><label for="title">Item name</label></td>
			<td><input type="input" name="item_name" value="<?php if ( !set_value('item_name')) echo htmlspecialchars($user_detail['item_name']) ; else echo set_value('item_name');?>"/></td>
		</tr>
		<tr>
			<td><label for="text">Item info</label></td>
			<td><input type="text" name="item_info" value="<?php if ( !set_value('item_info')) echo htmlspecialchars($user_detail['item_info']) ; else echo set_value('item_info');?>"/></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="submit" class="btn" value="Submit" />
				<input type="button" name="cancel" value="Cancel" class="btn" id="cancel" onclick="javascript:redirect('<?=site_url('items');?>');" />
			</td>
			
		</tr>
		

	</table>
		
		
</form>