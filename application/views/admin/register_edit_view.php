<div id="content_title">User Manager - Edit User</div>
<?php echo validation_errors(); ?>

<?php $attributes = array('class' => 'basic_form', 'id' => 'RegistrationForm');
	echo form_open("admin/register_edit/$user_detail[id]", $attributes) ?>
		<table class="data_table" align="center">
		<tr>
			<td><label for="text">Email</label></td>
			<td><input type="input" name="email" value="<?php if ( !set_value('email'))echo $user_detail['email'] ; else echo set_value('email');?>" /></td>
		</tr>
		<tr>
			<td><label for="title">Username</label></td>
			<td><input type="input" name="username" value="<?php if ( !set_value('username'))echo $user_detail['username'] ; else echo set_value('username');?>"/></td>
		</tr>
		<tr>
			<td><label for="text">Password</label></td>
			<td><input type="password" name="password" value="<?php if ( !set_value('password'))echo $user_detail['password'] ; else echo set_value('password');?>"/></td>
		</tr>
		<tr>
			<td><label for="text">Confirm Password</label></td>
			<td><input type="password" name="passconf" value="<?php if ( !set_value('passconf'))echo $user_detail['password'] ; else echo set_value('passconf');?>"/></td>
		</tr>
		<tr>
			<td><label for="text">Status</label></td>
			<td>
				<select name="status">
					<option value="1" <?php if ( !set_value('email') && $user_detail['is_admin'] == 1) echo "selected" ; ?>>Active</option>
					<option value="0" <?php if ( !set_value('email') && $user_detail['is_admin'] == 0) echo "selected" ; ?>>Block</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" name="submit"  class="btn" value="Submit" />
				<input type="button" name="cancel" value="Cancel" class="btn" id="cancel" onclick="javascript:redirect('<?=site_url('admin/register_manage');?>');" />
			</td>
		</tr>
	</table>		
</form>
							
		
</form>