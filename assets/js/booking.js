var map;
var gdir;
var geocoder = null;
var addressMarker;

// Initialize google map object
function initialize() 
{
	if (GBrowserIsCompatible()) 
	{   
		//initialize map by giving Map Div id   
		map = new GMap2(document.getElementById("map_canvas"),
					{ size: new GSize(340,560) } ); //set the width & height of the Map here

		map.setUIToDefault();
		
		//initialize result container by using its Div id
		gdir = new GDirections(map, document.getElementById("directions"));
		
		//create event to load directions
		GEvent.addListener(gdir, "load", onGDirectionsLoad);
		
		//create event to handle errors
		GEvent.addListener(gdir, "error", handleErrors);
	}
}

// Use this function to set Waypoint
function setDirections() 
{
	//create waypoints array & fill it with all locations entered by user
	var waypoints = new Array();

	var pickup_address="";
	pickup_address+=$("#pickup_street").val() + ", ";
	pickup_address+=$("#pickup_postcode").val();
	waypoints[0] = pickup_address;
	var waypoints_counter=1;
  
	// for multiple directions
	$('input[name="h_destination_full_address[]"]').each(function()
	{
		waypoints[waypoints_counter]=$(this).val();
		waypoints_counter++;
		//alert($(this).val());
	});
	
	//this is the main google API function that generates the directions
	gdir.loadFromWaypoints(waypoints);
}

// Use this function to handle errors occured while processing API request
function handleErrors()
{
	if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
		alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
	else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
		alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
   
	else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
		alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);
	 
	else if (gdir.getStatus().code == G_GEO_BAD_KEY)
		alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);

	else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
		alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
	
	else alert("An unknown error occurred.");
	
	$("#total_miles").val("0"); //empty summary container which will be showing "Loading..." message at this point
	
	//redirect("home");
}

// Use this function to access information about the latest load() results.
function onGDirectionsLoad()
{ 
	//get total distance
	var total_distance=gdir.getDistance().html;
	total_distance=total_distance.replace("mi", ""); //a short trick to display distance as "miles" & not as just "mi"
	total_distance=total_distance.replace("km", ""); //a short trick to display distance as "miles" & not as just "mi"
	total_distance=total_distance.replace("&nbsp;", ""); //a short trick to display distance as "miles" & not as just "mi"
  
	//get total time
	var total_duration=gdir.getDuration().html;
	
	//IMPORTANT : do every calculate here only
	//alert(total_distance);
	$("#total_miles").val(total_distance);
	
	$.ajax({ 
		url: $("#h_base_url").val()+"booking/get_booking_cost",
		data: $("#frmBooking").serialize(),
		dataType: "json",
		type: "POST",
		success: function(data){
			$("#mileage_price").val(data.mileage_price);
			$("#h_pricing_method_applied").val(data.pricing_method_applied);
			$("#h_fixed_pricing_id_fk").val(data.fixed_pricing_id_fk);
			
			var total_miles = $("#total_miles").val();
			$("#h_total_miles").val(total_miles);
			
			// store mileage total price to hidden field
			var total_price = data.total_price;
			$("#h_total_price").val(total_price);
			
			// calculate additional prices if exists
			var final_total_price=calculate_final_total();
			
			$("#total_loading").fadeOut();
			$("#total_price").val(final_total_price);
		}
	});
}

//initialize API onload
$(function(){ initialize();  });

//close API onunload
$(window).unload( function () { GUnload(); } );


// calculate total with additional values given
function calculate_final_total(){
	total_price = Number( $("#h_total_price").val() );
 	wait_cost = $("#wait_cost").val();
	extra_charges = $("#extra_charges").val();
	driver_price = $("#driver_price").val();
	discount = $("#discount").val();
	final_total = 0;
	
	if(total_price!="" && isDecimal(total_price) && !isNaN(total_price)){
		final_total = total_price;
	}
	
	// Wait Cost
	if(isDecimal(wait_cost)==false){
		$("#wait_cost").addClass('red_border');
	}
	else{
		$("#wait_cost").removeClass('red_border');
		wait_cost = Number(wait_cost);
		final_total = final_total + wait_cost;
	}
	
	// Extra Charges
	if(isDecimal(extra_charges)==false){
		$("#extra_charges").addClass('red_border');
	}
	else{
		$("#extra_charges").removeClass('red_border');
		extra_charges = Number(extra_charges);
		final_total = final_total + extra_charges;
	}
	
	// Driver Price
	if(isDecimal(driver_price)==false){
		$("#driver_price").addClass('red_border');
	}
	else{
		$("#driver_price").removeClass('red_border');
		driver_price = Number(driver_price);
		final_total = final_total + driver_price;
	}
	
	// Discount
	if(isDecimal(discount)==false){
		$("#discount").addClass('red_border');
	}
	else{
		$("#discount").removeClass('red_border');
		discount = Number(discount);
		final_total = final_total - discount;
	}
	
	final_total = final_total.toFixed(2);
	
	return final_total;
}

//===================================== CUSTOM METHOD CALLS =====================================*/
$(document).ready(function(){
	
	$('#thetable').tableScroll({ height:95, width:450});

	
	// Destination record move up
	$('.dest_move_down').live('click', function () {
		var rowToMove = $(this).parents('tr.MoveableRow:first');
		var next = rowToMove.next('tr.MoveableRow')
		if (next.length == 1) { next.after(rowToMove); }
		
		get_booking_cost();
		
		return false;
	});
	
	// Destination record move down
	$('.dest_move_up').live('click', function () {
		var rowToMove = $(this).parents('tr.MoveableRow:first');
		var prev = rowToMove.prev('tr.MoveableRow')
		if (prev.length == 1) { prev.before(rowToMove); }
		
		get_booking_cost();
		
		return false;
	});
	
	// Destination record delete
	$('.dest_delete').live('click', function () {
		var rowToMove = $(this).parents('tr.MoveableRow:first');
		rowToMove.remove();
		
		get_booking_cost();
		
		return false;
	});
	
	// fill pickup boxes when "pickup" button clicked
	$("#select_address_pickup").click(function(){
		full_address = $("#search_address").val();
		if($('#search_from').val()=='0' && $("#search_house_no").val()==""){
			//alert("Please enter House No.");
			$("#search_house_no, #search_house_no").addClass('red_border');
		}
		else 
		if(full_address==""){
			//alert("Please enter address");
			$("#search_address, #search_address").addClass('red_border');
		}
		else
		{
			if($('#search_from').val()=='1'){
				$("#flight_details_block").show();
			}
			else{
				$("#flight_details_block").hide();
			}
			
			$("#search_house_no, #search_address").removeClass('red_border');
			
			if(full_address!="") {
				address_array = full_address.match(/^(.*),\s*(.*)$/);
				street = address_array[1];
				post_code = address_array[2];
				house_no = $("#search_house_no").val();
				pickup_type = $('#search_from').val();
				
				$("#pickup_postcode").val(post_code);
				$("#pickup_street").val(street);
				$("#pickup_house_no").val(house_no);
				$("#h_pickup_type").val(pickup_type);
				
				clear_search();
				get_booking_cost();
			}
			else
			{
				clear_pickup();
			}
		}
	});
	
	
	// fill destination table when "dest." button clicked
	$("#select_address_destination").click(function(){
		full_address = $("#search_address").val();
		if(full_address==""){
			//alert("Please enter address");
			$("#search_address").addClass('red_border');
			$("#search_address").focus();
		}
		else
		{
			$("#search_address").removeClass('red_border');
			if(full_address!="") {
				address_array = full_address.match(/^(.*),\s*(.*)$/);
				street = address_array[1];
				post_code = address_array[2];
				house_no = $("#search_house_no").val();
				destination_type = $('#search_from').val();
				
				$("#thetable tbody").append(
					'<tr class="MoveableRow">' +
					  '<td style="width:78px;">' + house_no + '</td>' +
					  '<td style="width:65px;">' + post_code + '</td>' +
					  '<td>' + street + '</td>' +
					  '<td style="width:60px;">' +
						'<a href="" class="dest_move_up" title="Move up"></a>' +
						'<a href="" class="dest_move_down" title="Move down"></a>' +
						'<a href="" class="dest_delete" title="Delete"></a>' +
						'<input type="hidden" name="h_destination_house_no[]" id="h_destination_house_no" value="' + house_no + '" />'+
						'<input type="hidden" name="h_destination_postcode[]" id="h_destination_postcode" value="' + post_code + '" />'+
						'<input type="hidden" name="h_destination_street[]" id="h_destination_street" value="' + street + '" />'+
						'<input type="hidden" name="h_destination_full_address[]" id="h_destination_full_address" value="' + full_address + '" />'+
						'<input type="hidden" name="h_destination_type[]" id="h_destination_type" value="' + destination_type + '" />'+
					  '</td>' +
					'</tr>'
				);
				
				clear_search();
				get_booking_cost();
			}
			else
			{
				clear_pickup();
			}
		}
	});
	
	// Clear Address search boxes when clicked on "Clear" button
	$("#select_address_clear").click(function(){
		clear_search();
	});
	
	// Clear Pickup location when clicked on "Clear" button
	$("#reset_pickup").click(function(){
		clear_pickup();
	});
	
	
	// when typed Wait Cost
	$("#wait_cost, #extra_charges, #driver_price, #discount").keyup(function(){
		var final_total_price = calculate_final_total();
		$("#total_price").val(final_total_price);
	});
	
	//when save or save_repeat button clicked, store clicked button value
	$("#save, #save_repeat").click(function(){
		$("#h_clicked_button").val(this.id);
	});
	
	//load job history if repeated customer arrives
	$("#phone_no").blur(function(){
		$.ajax({ 
			url: $("#h_base_url").val()+"booking/get_job_history",
			data: $("#frmBooking").serialize(),
			dataType: "html",
			type: "POST",
			success: function(data){
				if(data!='0'){
					//popup thickbox
					phone_no = encodeURIComponent($("#phone_no").val());
					tb_open_new("Job Hostory", $("#h_base_url").val() + "booking/select_job_history/" + phone_no + "?TB_iframe=true&height=400&width=700")
				}
			}
		});
	});
});

// clear all textboxes inside search address box
function clear_search(){
	$("#search_house_no, #search_address").val("");
	$("#search_house_no, #search_address").removeClass('red_border');
}

// clear all textboxes inside pickup address box
function clear_pickup(){
	$("#pickup_postcode, #pickup_street, #pickup_house_no, #airline, #flight_no, #pickup_point").val("");
	$("#flight_details_block").hide();
	get_booking_cost();
}



//booking form validation
function check_booking_form(){

	error=0;
	error_msg='';
	
	if($("#customer_name").val()==""){
		error=1;
		error_msg+="- Enter Customer name</br>";
	}
	
	if($("#phone_no").val()==""){
		error=1;
		error_msg+="- Enter Phone No.</br>";
	}
	
	if($("#email").val()!="" && email_check($("#email").val())==false){
		error=1;
		error_msg+="- Enter valid Email</br>";
	}
	
	if($("#booking_time_hh").val()=="" || isInteger($("#booking_time_hh").val())==false){
		error=1;
		error_msg+="- Enter valid Booking time</br>";
	}
	else if($("#booking_time_mm").val()=="" || isInteger($("#booking_time_mm").val())==false){
		error=1;
		error_msg+="- Enter valid Booking time</br>";
	}
	
	if($("#booking_due_time_hh").val()=="" || isInteger($("#booking_due_time_hh").val())==false){
		error=1;
		error_msg+="- Enter valid Due time</br>";
	}
	else if($("#booking_due_time_mm").val()=="" || isInteger($("#booking_due_time_mm").val())==false){
		error=1;
		error_msg+="- Enter valid Due time</br>";
	}
	
	if($("#pickup_postcode").val()==""){
		error=1;
		error_msg+="- Enter Pickup postcode</br>";
	}
	
	if($("#pickup_street").val()==""){
		error=1;
		error_msg+="- Enter Pickup Street name</br>";
	}
	
	//check flight details
	if($("#flight_details_block").css('display')!="none"){
		if($("#airline").val()==""){
			error=1;
			error_msg+="- Enter Airline</br>";
		}
		
		if($("#flight_no").val()==""){
			error=1;
			error_msg+="- Enter Flight no.</br>";
		}
		
		if($("#pickup_point").val()==""){
			error=1;
			error_msg+="- Enter Pickup point</br>";
		}
	}
	
	if($('input[name="h_destination_house_no[]"]').length==0){
		error=1;
		error_msg+="- Provide a Destination</br>";
	}
	
	if($("#vehicle_type_id_fk").val()==""){
		error=1;
		error_msg+="- Select Vehicle Type</br>";
	}
	
	if($("#h_total_miles").val()!="" && isDecimal($("#h_total_miles").val())==false){
		error=1;
		error_msg+="- Enter valid Total miles</br>";
	}
    
	if($("#mileage_price").val()!="" && isDecimal($("#mileage_price").val())==false){
		error=1;
		error_msg+="- Enter valid Mileage price</br>";
	}
	
	if($("#wait_time").val()!="" && isDecimal($("#wait_time").val())==false){
		error=1;
		error_msg+="- Enter valid Wait time(min)</br>";
	}
	
	if($("#wait_cost").val()!="" && isDecimal($("#wait_cost").val())==false){
		error=1;
		error_msg+="- Enter valid Wait Cost</br>";
	}
	
	if($("#extra_charges").val()!="" && isDecimal($("#extra_charges").val())==false){
		error=1;
		error_msg+="- Enter valid Extra charges</br>";
	}
	
	if($("#discount").val()!="" && isDecimal($("#discount").val())==false){
		error=1;
		error_msg+="- Enter valid Discount</br>";
	}
	
	if($("#total_price").val()!="" && isDecimal($("#total_price").val())==false){
		error=1;
		error_msg+="- Enter valid Total price</br>";
	}
	
	if(error==1){
		//alert(error_msg);
		$("#alert_box").html(error_msg);
		$("#alert_box").dialog({
			resizable: false,
			title: 'Please fill details below',
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		return false;
	}
	else{
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Yes": function() {
					$( this ).dialog( "close" );
					
					//============>> call ajax here for storing record <<==============
					$(".loading_box").show();
					
					if($("#h_booking_mode").val()=='Update') {
						var clicked_button = $("#h_clicked_button").val();
						if(clicked_button=='save_repeat'){
							$("#h_booking_mode").val('Update Save Repeat');
						}
						else{
							$("#h_booking_mode").val('Update');
						}
						
					    $.ajax({ 
							url: $("#h_base_url").val()+"booking/update_booking_value",
							data: $("#frmBooking").serialize(),
							dataType: "html",
							type: "POST",
							success: function(data){
								//$("#ajax_response").html(data);
								$("#alert_box").html("Booking has been stored");
								$("#alert_box").dialog({
									title: 'Booking Completed',
									resizable: false,
									modal: true,
									buttons: {
										Ok: function() {
											$(".loading_box").hide();
											// check for save button clicked
											$( this ).dialog( "close" );
										}
									}
								});
							}
						});
					}
					else
					if($("#h_booking_mode").val()=='Update Save Repeat') {
					    var clicked_button = $("#h_clicked_button").val();
						if(clicked_button=='save_repeat'){
							$("#h_booking_mode").val('Update Save Repeat');
						}
						else{
							$("#h_booking_mode").val('Update');
						}
						
						$.ajax({ 
							url: $("#h_base_url").val()+"booking/store_booking_value",
							data: $("#frmBooking").serialize(),
							dataType: "html",
							type: "POST",
							success: function(data){
								//$("#ajax_response").html(data);
								$("#alert_box").html("Booking has been stored");
								$("#alert_box").dialog({
									title: 'Booking Completed',
									resizable: false,
									modal: true,
									buttons: {
										Ok: function() {
											$(".loading_box").hide();
											$("#booking_job_id_pk").val(data);
											// check for save button clicked
											$( this ).dialog( "close" );
										}
									}
								});
							}
						});
					}
					else {
						$.ajax({ 
							url: $("#h_base_url").val()+"booking/store_booking_value",
							data: $("#frmBooking").serialize(),
							dataType: "html",
							type: "POST",
							success: function(data){
								//$("#ajax_response").html(data);
								
								$("#alert_box").html("Booking has been stored");
								$("#alert_box").dialog({
									title: 'Booking Completed',
									resizable: false,
									modal: true,
									buttons: {
										Ok: function() {
											$(".loading_box").hide();
											// check for save button clicked
											if($("#h_clicked_button").val()=='save')
												reset_booking_form();
											$( this ).dialog( "close" );
										}
									}
								});
							}
						});
					}
				},
				"No": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		return false;
	}

}

//get booking cost
function get_booking_cost(){
	if($("#pickup_postcode").val()!="" && $("#pickup_street").val()!="" && $('input[name="h_destination_house_no[]"]').length!=0 && $("#vehicle_type_id_fk").val()!="") {
		$("#total_loading").fadeIn();
		setDirections();
	}
	
	if( 
	( $("#pickup_postcode").val()=="" && $("#pickup_street").val()=="" && $("#h_total_price").val()!="" ) ||
	( $('input[name="h_destination_house_no[]"]').length==0 && $("#h_total_price").val()!="") ){
		$("#h_pricing_method_applied").val("");
		$("#h_fixed_pricing_id_fk").val("");
		$("#h_total_price").val("0.00");
		$("#total_miles").val("0.00");
		$("#h_total_miles").val("0.00");
		$("#mileage_price").val("0.00");
		$("#total_price").val("0.00");
		//calculate_final_total();
	}
}

//booking form validation
function reset_booking_form(){
	document.frmBooking.reset();
	$("#thetable tbody").html("");
	$(".red_border").removeClass("red_border");
	
	$("#h_pricing_method_applied").val("");
	$("#h_fixed_pricing_id_fk").val("");
	$("#h_total_price").val("");
	$("#h_total_miles").val("");
	$("#h_total_pickup_type").val("");

}

function swap_locations(){
	//get destination details
	$("#thetable tbody tr").each(function(){
		pickup_house_no = $(this).find('#h_destination_house_no').val();	
		pickup_postcode = $(this).find('#h_destination_postcode').val();	
		pickup_street = $(this).find('#h_destination_street').val();	
		pickup_full_address = $(this).find('#h_destination_full_address').val();	
		pickup_type = $(this).find('#h_destination_type').val();	
	});

	//get pickup details
	destination_type = $("#h_pickup_type").val();
	destination_house_no = $("#pickup_house_no").val();
	destination_postcode = $("#pickup_postcode").val();
	destination_street = $("#pickup_street").val();
	
	destination_full_address="";
	/*if(destination_house_no!=""){
		destination_full_address+=destination_house_no + ', ';
	}*/
	destination_full_address+=destination_street + ', ' + destination_postcode;
	
	//clear pickup & destination
	$("#thetable tbody tr:last").remove();
	
	$("#h_pickup_type").val("");
	$("#pickup_house_no").val("");
	$("#pickup_postcode").val("");
	$("#pickup_street").val("");

	
	//restore swapped pickup & destination
	$("#h_pickup_type").val(pickup_type);
	$("#pickup_house_no").val(pickup_house_no);
	$("#pickup_postcode").val(pickup_postcode);
	$("#pickup_street").val(pickup_street);
	if(pickup_type==1)
		$("#flight_details_block").show();
	else
		$("#flight_details_block").hide();
	
	$("#thetable tbody").append(
		'<tr class="MoveableRow">' +
		  '<td style="width:78px;">' + destination_house_no + '</td>' +
		  '<td style="width:65px;">' + destination_postcode + '</td>' +
		  '<td>' + destination_street + '</td>' +
		  '<td style="width:60px;">' +
			'<a href="" class="dest_move_up" title="Move up"></a>' +
			'<a href="" class="dest_move_down" title="Move down"></a>' +
			'<a href="" class="dest_delete" title="Delete"></a>' +
			'<input type="hidden" name="h_destination_house_no[]" id="h_destination_house_no" value="' + destination_house_no + '" />'+
			'<input type="hidden" name="h_destination_postcode[]" id="h_destination_postcode" value="' + destination_postcode + '" />'+
			'<input type="hidden" name="h_destination_street[]" id="h_destination_street" value="' + destination_street + '" />'+
			'<input type="hidden" name="h_destination_full_address[]" id="h_destination_full_address" value="' + destination_full_address + '" />'+
			'<input type="hidden" name="h_destination_type[]" id="h_destination_type" value="' + destination_type + '" />'+
		  '</td>' +
		'</tr>'
	);
	
	//generate booking cost
	get_booking_cost();
}

$(document).ready(function(){

	// toggle location search selector on new booking form
	$("#search_from").change(function(){
		selected_val = $(this).val();

		// 0 	Address
		// 1 	Airports
		// 3 	Stations
		// 4 	Hotels
		// 2 	Hospitals
		// 5 	Tubes
		// 6 	University
		// 2	Shopping

		if(selected_val=='0'){
			selector_string = 'Address : ';
			selector_string += '<input type="text" name="search_house_no" id="search_house_no" value="" class="textbox" size="8" title="House No." />&nbsp;';
			selector_string += '<input type="text" name="search_address" id="search_address" value="" class="textbox" size="23" title="Address" />';
			
			$("#search_from_selector").html(selector_string);

			$( "#search_address" ).autocomplete({
				
				source: function(request, response) {
					$.ajax({ 
						url: $("#h_base_url").val()+"booking/get_address",
						data: { 
							keyword: $("#search_address").val() ,
							search_from: $("#search_from").val()
						},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}
					})
				},
				minLength: 3
			});
		}
		else{
			// get locations using ajax
			$("#search_from_selector").html('loading...');	

			$.ajax({ 
				url: $("#h_base_url").val()+"booking/get_special_places",
				data: { 
					search_from: $("#search_from").val()
				},
				dataType: "json",
				type: "POST",
				success: function(data){

					selector_string = 'Select : ';
					selector_string += '<select name="search_address" id="search_address" class="textbox" style="width:250px;">';
					selector_string += '	<option value="" selected="selected">Select one</option>';

					$.each(data, function(index, element) {
						selector_string += '	<option value="' + element + '">' + element + '</option>';
			        });

					//selector_string += data;
					selector_string += '</select>';
					selector_string += '<input type="hidden" name="search_house_no" id="search_house_no" value=""/>';
					$("#search_from_selector").html(selector_string);	
				}
			})

		}

	});

});