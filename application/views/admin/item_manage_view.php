<div id="content_title">Items Manager</div>
<p><?php echo $this->session->flashdata('item_create');?></p>
<p><?php echo $this->session->flashdata('item_edit');?></p>
<p><?php echo $this->session->flashdata('item_delete');?></p>
<div id="data">
	
<div id="data_table">
	<?	$total_records=count($user_records);

		if(!empty($total_records))
		{?>
		<div class="content_header">
			<div class="content_header_left">
				<a href="#" class="content_delete" onclick="javascript:return delete_checked();">Delete Selected</a>
				<a href="<?=site_url("items/create");?>" class="content_add">Add new</a>
			</div><!-- /content_header_left -->
		</div><!-- /content_header -->
			<form id="form_data" name="form_data" action="<?=site_url('items/delete'); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" id="h_total_records" name="h_total_records" value="<?=$all_total_records;?>">
				<table class="data_table">
					<thead>
						<tr>
							<th width="20" align="center"><input type="checkbox" name="check_all" id="check_all" value="1" onclick="javascript:toggle_check();" /></th>
							<th width="300" align="left"><a class="orderby_link <?=$orderby_css;?>" href="<?=site_url("items/index/item_name/$orderby_opt_next");?>">Item Name</a></th>
							<th align="left"><a class="orderby_link <?=$orderby_css;?>" href="<?=site_url().'/items/index/item_name/'.$orderby_opt_next;?>">Item Code</a></th>
							<th width="60" align="center">Actions</th>
						</tr>
					</thead>
					
					<tbody>
					<?	foreach($user_records as $row) {?>
						<tr>
							<td width="20" align="center"><input type="checkbox" name="check_id[]" id="check_id" value="<?=$row['id'];?>" /></td>
							<td><?=$row['item_name'];?></td>
							<td><?=$row['item_code'];?></td>
							<td align="center">
								<a href="<?=site_url("items/edit/$row[id]");?>" title="Edit" class="a_edit"></a>
								<a href="<?=site_url("items/delete/$row[id]");?>" title="Delete" class="a_delete" onclick="return delete_single();"></a>
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
			echo '<div class="clean-yellow" style="text-align:center;">No Records Found</div>';?>
			<div class="content_header">
				<div class="content_header_left">
					
					<a href="<?=site_url("items/create");?>" class="content_add" style="float:right;">Add new</a>
				</div><!-- /content_header_left -->
			</div><!-- /content_header -->
			
		<?}
	?>
	
	</div><!-- /data_table -->
</div>	