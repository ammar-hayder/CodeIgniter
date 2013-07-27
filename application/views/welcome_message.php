<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/codeigniter.css')?>"/>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>
	<p><?php echo $this->session->flashdata('item');?></p>
	<div id="body">
		<p><a href="<?php echo site_url('registration'); ?>">Click for registration</a>.</p>

		<p><a href="<?php echo site_url('login'); ?>">Administrator Login</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>