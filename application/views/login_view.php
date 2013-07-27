<div id="admin_container">
	<h1 align="center">Admin Login</h1>
	<form id="login_form" name="login_form" action="<?=site_url('user/login');?>" method="post">
		<table border="0" cellpadding="0" cellspacing="0" style="font-weight:bold; font-size:15; color:#565555;" align="center">
			<tr>
				<td align="left" style="padding-left:10px;">User Name:</td>
				<td align="left"><input type="text" name="username" value="" id="login_code" class="login_text" /></td>
			</tr>
			<tr >
				<td align="left" style="padding-top:5px; padding-left:10px;">Password:</td>
				<td align="left" style="padding-top:5px;"><input type="password" name="password" value="" id="password" /></td>
			</tr>
			<tr>
				<td align="right" style="padding-top:8px;">
					<input type="submit" name="login_button" id="login_button" value="Login" class="login_button" />
				</td>
			</tr>
		</table>
		
	</form>
	<p align="center"><?php echo $this->session->flashdata('error');?></p>
</div>
