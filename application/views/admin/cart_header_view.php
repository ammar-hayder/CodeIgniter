<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Administrator</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/codeigniter_admin.css');?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/magnific-popup.css');?>"/>
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.1.10.1.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/all.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery-ui1.10.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery.magnific-popup.js')?>"></script>
	<script type="text/javascript">
	$(function() {
		$(".cart_1").magnificPopup({
										
										type: 'ajax',
										ajax: { setting: {
														closeBtnInside: false,
														closeOnBgClick: true
													}
												}
											});
		
	});
		
	</script>
	
</head>
<body>
	<div id="admin_container">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white">
		  <tr>
		    <td colspan="2" align="center">
		    	<table>
		    		<tr>
		    			<td style="vertical-align:middle;text-align:center;" class="page_title">
		    				<h1>Administrator Panel</h1></td>
		    		</tr>
		    	</table>
		   	</td>
		  </tr>
		  
		  <tr>
		    <td align="left" bgcolor="#EEEEEE" style="padding-bottom:1px;">
				<div class="menu">
					<ul>
					  <li><a href="<?php echo site_url('admin/index');?>">&nbsp;Dashboard&nbsp;</a></li>
					  <li><a href="<?php echo site_url('admin/register_manage');?>">&nbsp;User Manager &nbsp;</a></li>
					  <li><a href="<?php echo site_url('items');?>">&nbsp;Items Manager &nbsp;</a></li>
					  <li><a href="<?php echo site_url('cart');?>">&nbsp;Cart Manager &nbsp;</a></li>
					  <li><a href="<?php echo site_url('admin/logout');?>">&nbsp;Logout &nbsp;</a></li>
					</ul>
				</div>
			</td>
		  </tr>
		  
		   <tr>
		    <td height="1" bgcolor="#9E9E9E"></td>
		  </tr>
		</table>