<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Administrator</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/codeigniter_admin.css');?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/magnific-popup.css');?>"/>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.1.10.1.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/all.js')?>"></script>
	
	<script src="<?=base_url('assets/js/jquery.magnific-popup.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery-ui1.10.js')?>"></script>
	<script type="text/javascript">
	$(document).ready(function() {
    $( ".items ul li, .cart_items ul li" ).draggable({
     	
      	helper: "clone"
    });
    $( ".cart_items ul" ).droppable({
      accept: ".items ul li",
      activeClass: "ui-state-hover",
      hoverClass: "ui-state-active",

      drop: function( event, ui ) {
        $( this ).find( ".placeholder" ).remove();
        item_id= ui.draggable.attr("id");
        var cart= <?=$cart;?>;
        $.ajax({
				type: "POST",
				url: "<?=site_url('cart/edit');?>",
				data: {item_id: item_id, cart_no: cart},
				success: function(result){
					if (result == 1)
					{	
						$( ".placeholder" ).remove();
						item_value=$("#"+item_id).html();
        				$("<li id=cart_"+item_id+">"+item_value+"("+result+")</li>").appendTo(".cart_items ul" );
					}
					else
					{
						item_value=$("#"+item_id).html();
        				str="<li id=cart_"+item_id+">"+item_value+"("+result+")</li>";
        				$(str).replaceAll("#cart_"+item_id);
					}
				},
				error: function(){
					console.log('error');
				},
				complete: function(){
					$( ".cart_items ul li" ).draggable({
     	
			      	helper: "clone"
				    });
				
				}
			});
       
      	}
    });
    
    	
		 $( ".items ul" ).droppable({
	      accept: ".cart_items ul li",
	      activeClass: "ui-state-hover",
	      hoverClass: "ui-state-active",

	      drop: function( event, ui ) {
	        cart_item_id= ui.draggable.attr("id");
	        only_item_id=cart_item_id.substring(5);
	        // alert(only_item_id);
	        var cart= <?=$cart;?>;
	        $.ajax({
					type: "POST",
					url: "<?=site_url('cart/delete');?>",
					data: {item_id: only_item_id, cart_no: cart},
					success: function(result){
						if(result!=0 && result != 'no item')
						{
							item_value=$("#"+only_item_id).html();
							// alert(item_value);
							str="<li id="+cart_item_id+">"+item_value+"("+result+")</li>";
		        			$(str).replaceAll("#"+cart_item_id);
		        		}
		        		if (result=='no item')
		        		{
		        			
							// alert(item_value);
							str1="<li class=\"placeholder\">Add Your Items here</li>";
		        			$(str1).replaceAll("#"+cart_item_id);
		        		}
		        		if (result == '0')
		        		{
		        			$("#"+cart_item_id).remove();
		        		}
					},
					error: function(){
						console.log('error');
					},
					complete: function(){
						$( ".cart_items ul li" ).draggable({
     	
					      	helper: "clone"
						    });
					}
				});
	       
	      	}
	    });
    
	
  });
  </script>
	
</head>
<body bgcolor="white">
	<div id="admin_container">
		<div id="data_table">

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  	<tr>
				<td style="padding:15px; font-size:16px;color:black; font-weight:bold;" >Available Items</td>
				<td style="padding:15px; font-size:16px;color:black;font-weight:bold;">Cart Items <?php echo $cart;?></td>
			</tr>
			<tr>
				<td align="left">
					<div class="items">
						<ul>
							<? if(count($items)>0)
								{
									foreach($items as $item) 
									{
										echo "<li id=\"$item[id]\">$item[item_code]</li>";
									}
								}
								else
								{
									echo "<li class=\"placeholder\">Add your items here</li>";
								}
							?>	
						</ul>
					</div>
				</td>
				<td>
					<div class="cart_items">
						<ul>
						  <? if(count($cart_items)>0)
								{ 
									// print_r($cart_items);
									foreach($cart_items as $row) 
									{	
										if($row['item_quantity'] != 0)
										echo "<li id=\"cart_$row[id]\">$row[item_code]($row[item_quantity])</li>";
									}
								}
								else
								{
									echo "<li class=\"placeholder\">Add your items here</li>";
								}
							?>	
						</ul>
					</div>
				</td>
			</tr>
		  	
		</table>
		</div>
		</body>
</html>