<div id="content_title">Items Manager - Add Item</div>
<?php echo validation_errors("<p align=\"center\">"); ?>


<?php $attributes = array('class' => 'basic_form', 'id' => 'ItemCreateForm');
	echo form_open('items/create', $attributes) ?>
	<table class="data_table" align="center">
		<tr>
			<td><label for="text">Item Code</label></td>
			<td><input type="input" name="item_code" value="<?php echo set_value('item_code'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="title">Item Name</label></td>
			<td><input type="input" name="item_name" value="<?php echo set_value('item_name'); ?>"/></td>
		</tr>
		<tr>
			<td><label for="text">Item Info</label></td>
			<td><input type="item_info" name="item_info" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="submit" class="btn" value="Submit" />
				<input type="button" name="cancel" value="Cancel" class="btn" id="cancel" onclick="javascript:redirect('<?=site_url('items');?>');" />
			</td>
		</table>
		
</form>


