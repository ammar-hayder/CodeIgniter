
<?php echo validation_errors(); ?>

<?php $attributes = array('class' => 'basic_form', 'id' => 'RegistrationForm');
	echo form_open('registration', $attributes) ?>
	<table class="data_table" align="center">
		<tr>
			<td><label for="text">Email</label></td>
			<td><input type="input" name="email" value="<?php echo set_value('email'); ?>" />
			</td>
		</tr>
		<tr>
			<td><label for="title">Username</label></td>
			<td><input type="input" name="username" value="<?php echo set_value('username'); ?>"/></td>
		</tr>
		<tr>
			<td><label for="text">Password</label></td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td><label for="text">Confirm Password</label></td>
			<td><input type="password" name="passconf" /></td>
		</tr>
		<tr>
			<td><?php echo $checkimg; ?></td>
			<td><input type="text" name="captcha" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" class="btn" value="Submit" /><input type="button" name="cancel" value="Cancel" class="btn" id="cancel" onclick="javascript:redirect('<?=site_url();?>');" /></td>
		</tr>
	</table>		
</form>


