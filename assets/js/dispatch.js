$(document).ready(function(){
	
	// apply table scroll plugin
	$('#dispatch-left-table').tableScroll({ height:160, width:450});
	$('#dispatch-right-table').tableScroll({ height:160, width:450});
	$('#dispatch-jobs-table').tableScroll({ height:120});
	
	
	// load plotted drivers
	load_plotted_drivers();
	
	// load jobs coming
	load_jobs_coming();
	
	// load drivers onjob
	load_drivers_onjob();
	
	
	// apply thickbox
	$('#plot_driver_button').each(function(){
		var url = $(this).attr('href') + '?TB_iframe=true&height=150&width=400';
		$(this).attr('href', url);
	});
	
	$('.plot_driver_location_button').livequery(function(){
		$(this).each(function(){
			var url = $(this).attr('href') + '?TB_iframe=true&height=130&width=400';
			$(this).attr('href', url);
		});
	});
	
	$('.send_sms_driver_button, .send_sms_driver_button2').livequery(function(){
		$(this).each(function(){
			var url = $(this).attr('href') + '?TB_iframe=true&height=230&width=400';
			$(this).attr('href', url);
		});
	});
	
	$('.send_sms_customer_button').livequery(function(){
		$(this).each(function(){
			var url = $(this).attr('href') + '?TB_iframe=true&height=230&width=400';
			$(this).attr('href', url);
		});
	});
	
	$('.cancel_job_button, .cancel_job_button2, .cancel_job_button3').livequery(function(){
		$(this).each(function(){
			var url = $(this).attr('href') + '?TB_iframe=true&height=230&width=400';
			$(this).attr('href', url);
		});
	});
	
	$('.dispatch_job_button').livequery(function(){
		$(this).each(function(){
			var url = $(this).attr('href') + '?TB_iframe=true&height=250&width=400';
			$(this).attr('href', url);
		});
	});
	
}); 

// Load Plotted Drivers
function load_plotted_drivers(){
	$("#dispatch-right-table tbody").livequery(function(){
		$(this).load($("#base_url").val()+"dashboard/load_drivers_waiting");
		
		// apply thickbox
		tb_init('a.plot_driver_location_button');
		tb_init('a.send_sms_driver_button');
	});
}

// Unplot Driver
function unplot_driver(drivers_plot_id_pk){
	$.ajax({
		url: $("#base_url").val()+"dashboard/unplot_driver/" + drivers_plot_id_pk,
		success: function(){
			load_plotted_drivers();
		}
	});
	return false;
}

// Load jobs coming
function load_jobs_coming(){
	$("#dispatch-jobs-table tbody").livequery(function(){
		$(this).load($("#base_url").val()+"dashboard/load_jobs_coming");
		
		// apply thickbox
		tb_init('a.send_sms_customer_button');
		tb_init('a.cancel_job_button');
		tb_init('a.dispatch_job_button');
		
		//apply tipsy plugin
		$(".a_info").tipsy({gravity: 's'});
	});
}

// Load drivers onjob
function load_drivers_onjob(){
	$("#dispatch-left-table").livequery(function(){
		$(this).load($("#base_url").val()+"dashboard/load_drivers_onjob");
		
		// apply thickbox
		tb_init('a.send_sms_driver_button2');
		tb_init('a.cancel_job_button2');
		tb_init('a.cancel_job_button3');
	});
}


// Recall Job
function recall_job(booking_job_id_pk, driver_id_pk){
	$.ajax({
		url: $("#base_url").val()+"dashboard/recall_job/" + booking_job_id_pk + "/" + driver_id_pk,
		success: function(){
			load_drivers_onjob();
			load_plotted_drivers();
			load_jobs_coming();
		}
	});
	return false;
}


// Set Job Onboard
function onboard_job(booking_job_id_pk, driver_id_pk){
	$.ajax({
		url: $("#base_url").val()+"dashboard/onboard_job/" + booking_job_id_pk + "/" + driver_id_pk,
		success: function(){
			load_drivers_onjob();
		}
	});
	return false;
}


// Set Job Completed
function completed_job(booking_job_id_pk, driver_id_pk){
	$.ajax({
		url: $("#base_url").val()+"dashboard/completed_job/" + booking_job_id_pk + "/" + driver_id_pk,
		success: function(){
			load_drivers_onjob();
			load_plotted_drivers();
			load_jobs_coming();
		}
	});
	return false;
}


$(document).ready(function(){

	$('.actions').livequery(function(){
		$(this).bind('click',function(e){
			var $cmenu = $(this).next();
			$('<div class="overlay"></div>').css({left : '0px', top : '0px',position: 'absolute', width: '100%', height: '100%', zIndex: '90' }).click(function() {
				$(this).remove();
				$cmenu.hide();
			}).bind('click' , function(){return false;}).appendTo(document.body);
			$(this).next().css({ left: e.pageX, top: e.pageY, zIndex: '91' }).show();
			
			return false;
		});
	});
	
	$('.actions_menu').livequery(function(){
		$(this).click(function(){
			$(".vmenu").hide();
		});
	});
});


