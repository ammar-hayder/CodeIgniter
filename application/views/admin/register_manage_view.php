<div id="content_title">User Manager</div>
<div id="data">
	<div class="content_header">
		<div class="content_header_left">
			<p><?php echo $this->session->flashdata('user_edited');?></p>
			<p><?php echo $this->session->flashdata('user_delete');?></p>
			<a href="#" class="content_delete" onclick="javascript:return delete_checked();">Delete Selected</a>
		</div><!-- /content_header_left -->
	</div><!-- /content_header -->

	<div id="data_table">
							
	<?	$total_records=count($user_records);

		if(!empty($total_records))
		{?>
			<form id="form_data" name="form_data" action="<?=site_url('admin/delete'); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" id="h_total_records" name="h_total_records" value="<?=$all_total_records;?>">
				<table class="data_table">
					<thead>
						<tr>
							<th width="20" align="center"><input type="checkbox" name="check_all" id="check_all" value="1" onclick="javascript:toggle_check();" /></th>
							<th width="300" align="left"><a class="orderby_link <?=$orderby_css;?>" href="<?=site_url("admin/register_manage/username/$orderby_opt_next");?>">User Name</a></th>
							<th align="left"><a class="orderby_link <?=$orderby_css;?>" href="<?=site_url("admin/register_manage/email/$orderby_opt_next");?>">Email</a></th>
							<th align="center"><a class="orderby_link <?=$orderby_css;?>" href="<?=site_url("admin/register_manage/is_admin/$orderby_opt_next");?>">Current Status</a></th>
							<th width="60" align="center">Actions</th>
						</tr>
					</thead>
					
					<tbody>
					<?	foreach($user_records as $row) {?>
						<tr>
							<td width="20" align="center">
								<?php if ($row['username'] != 'admin') {?>
									<input type="checkbox" name="check_id[]" id="check_id" value="<?=$row['id'];?>" /></td>
									<?}?>
							<td><?=$row['username'];?></td>
							<td><?=$row['email'];?></td>
							<td align="center"><?php if ($row['is_admin']==1) echo "<div id=\"a_status\">Active</div>"; else echo "<div id=\"b_status\">Block</div>"; ?></td>
							<td align="center">
								<?php if ($row['username'] != 'admin') {?>
								<a href="<?=site_url("admin/register_edit/$row[id]");?>" title="Edit" class="a_edit"></a>
								
								<a href="<?=site_url("admin/delete/$row[id]");?>" title="Delete" class="a_delete" onclick="return delete_single();"></a>
								<?}?>
							</td>
						</tr>
					<?	}?>
					</tbody>
				</table>
			
				<div class="pagination">
					<span class="record_counts">Showing Records : <?=($page+1);?> to <?=($page+$total_records);?> of <?=$all_total_records;?></span>  
					<?	if(!empty($paging_links)) echo 'Pages : '.$paging_links;?>
				</div><!-- /pagination -->
			</form>
		<?	}
		else
		{
			echo '<div class="clean-yellow">No Records Found</div>';
		}
	?>
	
	</div><!-- /data_table -->
</div>	