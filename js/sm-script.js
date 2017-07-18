smjQuery.noConflict();
smjQuery(document).ready(function() {
    var itemId;
    
    smjQuery('#itemDetails').dialog({
        autoOpen: false,
        width: 500,
        closeOnEscape: true,
        resizable: false,
        draggable: false,
        zIndex: 3999,
        title: 'Item Information',
        modal: true,
        buttons: {
            "Ok": function() { 
                smjQuery(this).dialog("close");
                smjQuery('#item_' +itemId).hide();
            }
        }
    });
	
	smjQuery('#GoogleMap').dialog({
        autoOpen: false,
        width: 300,
        height: 400,
        closeOnEscape: true,
        resizable: false,
        draggable: true,
        zIndex: 3999,
        title: 'Map',
        modal: true,
        buttons: {
            "Ok": function() { 
                smjQuery(this).dialog("close");
                smjQuery('#GoogleMap').hide();
            }
        }
    });
    
    function showItemInfo() {
        itemId = smjQuery("#sm_booking_form_itemId").val();
        if (itemId > 0) {
            smjQuery('#item_' +itemId).show();
            smjQuery('#itemDetails').dialog("open");
        }
        return false;
    }
	
	function showGoogleMap() {
		smjQuery('#GoogleMap').show();
        smjQuery('#GoogleMap').dialog("open");
        return false;
    }
    
    smjQuery("#ItemInfo").click(function() {
        showItemInfo();
    });
	smjQuery("#btnMap").click(function() {
        showGoogleMap();
    }); 
    smjQuery("#sm_booking_form_startdate").datepicker();
    smjQuery("#sm_booking_form_enddate").datepicker();
    //smjQuery("#table_bookings").tablesorter({widthFixed: true})
    smjQuery("#table_bookings th img").fadeIn('slow');
	
	//Item Type validation
	smjQuery('#sm_booking_itemtype_form').submit(function() {
		var errorCount = 0;
		if (smjQuery("#txtItemType").val() == "" ){
			smjQuery("#txtItemType").addClass('sm_required_fields');
			smjQuery("#val_txtItemType").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#txtItemType").removeClass('sm_required_fields');
			smjQuery("#val_txtItemType").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		
		if (errorCount>0) {
			return false;
		} else {
			return true;
		}
	});
	
	//New Item validation
	smjQuery('#sm_booking_item_form').submit(function() {
		var errorCount = 0;
		if (smjQuery("#txtTitle").val() == "" ){
			smjQuery("#txtTitle").addClass('sm_required_fields');
			smjQuery("#val_txtTitle").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#txtTitle").removeClass('sm_required_fields');
			smjQuery("#val_txtTitle").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		if (smjQuery("#txtDescription").val() == "" ){
			smjQuery("#txtDescription").addClass('sm_required_fields');
			smjQuery("#val_txtDescription").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#txtDescription").removeClass('sm_required_fields');
			smjQuery("#val_txtDescription").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		if (smjQuery("#txtAddressLn1").val() == "" ){
			smjQuery("#txtAddressLn1").addClass('sm_required_fields');
			smjQuery("#val_txtAddressLn1").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#txtAddressLn1").removeClass('sm_required_fields');
			smjQuery("#val_txtAddressLn1").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		if (smjQuery("#txtPostalCode").val() == "" ){
			smjQuery("#txtPostalCode").addClass('sm_required_fields');
			smjQuery("#val_txtPostalCode").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#txtPostalCode").removeClass('sm_required_fields');
			smjQuery("#val_txtPostalCode").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		if (smjQuery("#ddlType").val() == "" ){
			smjQuery("#ddlType").addClass('sm_required_fields');
			smjQuery("#val_ddlType").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#ddlType").removeClass('sm_required_fields');
			smjQuery("#val_ddlType").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		
		if (errorCount>0) {
			smjQuery('#sm_error_count').text(errorCount + ' form fields to check.');
			return false;
		} else {
			smjQuery('#sm_error_count').text('');
			return true;
		}
	});
	
	//Booking form validation.
	smjQuery('#sm_booking_form_form').submit(function() {
		var errorCount = 0;
		if (smjQuery("#sm_booking_form_itemId").val() == "" ){
			smjQuery("#sm_booking_form_itemId").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_itemId").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#sm_booking_form_itemId").removeClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_itemId").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
		}
		if (smjQuery("#sm_booking_form_fname").val() == "") {
			smjQuery("#sm_booking_form_fname").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_fname").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_fname").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_fname").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_surname").val() == "") {
			smjQuery("#sm_booking_form_surname").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_surname").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_surname").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_surname").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_phonenumber").val() == "") {
			smjQuery("#sm_booking_form_phonenumber").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_phonenumber").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_phonenumber").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_phonenumber").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_addln1").val() == "") {
			smjQuery("#sm_booking_form_addln1").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_addln1").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_addln1").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_addln1").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_countystate").val() == "") {
			smjQuery("#sm_booking_form_countystate").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_countystate").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_countystate").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_countystate").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_country").val() == "") {
			smjQuery("#sm_booking_form_country").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_country").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_country").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_country").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_postalcode").val() == "") {
			smjQuery("#sm_booking_form_postalcode").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_postalcode").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_postalcode").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_postalcode").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_startdate").val() == "") {
			smjQuery("#sm_booking_form_startdate").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_startdate").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_startdate").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_startdate").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_enddate").val() == "") {
			smjQuery("#sm_booking_form_enddate").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_enddate").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_enddate").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_enddate").removeClass('sm_required_fields');
		}
		if (smjQuery("#sm_booking_form_noadults").val() == "") {
			smjQuery("#sm_booking_form_noadults").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_noadults").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_noadults").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_noadults").removeClass('sm_required_fields')
		}
		email = smjQuery('#sm_booking_form_email').val();
		
		if (smjQuery("#sm_booking_form_email").val() == "") {
			smjQuery("#sm_booking_form_email").addClass('sm_required_fields');
			smjQuery("#val_sm_booking_form_email").text("* Required").removeClass('sm_form_notify_default').addClass('sm_form_notify');;
			errorCount++;
		} else {
			smjQuery("#val_sm_booking_form_email").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
			smjQuery("#sm_booking_form_email").removeClass('sm_required_fields')
		}
		
		if (email != "") {
			if(!isValidEmailAddress(email))
			{
				smjQuery("#sm_booking_form_email").addClass('sm_required_fields');
				smjQuery("#val_sm_booking_form_email").text("* Email Invalid").show().addClass('sm_form_notify');;
				errorCount++;
			} else {
				smjQuery("#val_sm_booking_form_email").text("*").removeClass('sm_form_notify').addClass('sm_form_notify_default');
				smjQuery("#sm_booking_form_email").removeClass('sm_required_fields')
			}
		}
		
		if (errorCount>0) {
			smjQuery('#sm_error_count').text(errorCount + ' form fields to check.');
			return false;
		} else {
			smjQuery('#sm_error_count').text('');
			return true;
		}
	});
});

function isValidEmailAddress(emailAddress) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (regex.test(email)) return true;
    else return false;
}

smjQuery(function () {
	smjQuery('.date_has_event').each(function () {
		// options
		var distance = 10;
		var time = 250;
		var hideDelay = 500;

		var hideDelayTimer = null;

		// tracker
		var beingShown = false;
		var shown = false;

		var trigger = smjQuery(this);
		var popup = smjQuery('.events ul', this).css('opacity', 0);

		// set the mouseover and mouseout on both element
		smjQuery([trigger.get(0), popup.get(0)]).mouseover(function () {
			// stops the hide event if we move from the trigger to the popup element
			if (hideDelayTimer) clearTimeout(hideDelayTimer);

			// don't trigger the animation again if we're being shown, or already visible
			if (beingShown || shown) {
				return;
			} else {
				beingShown = true;

				// reset position of popup box
				popup.css({
					top: 20,
					left: -76,
					display: 'block' // brings the popup back in to view
				})

				// (we're using chaining on the popup) now animate it's opacity and position
				.animate({
					bottom: '+=' + distance + 'px',
					opacity: 1
				}, time, 'swing', function() {
					// once the animation is complete, set the tracker variables
					beingShown = false;
					shown = true;
				});
			}
		}).mouseout(function () {
			// reset the timer if we get fired again - avoids double animations
			if (hideDelayTimer) clearTimeout(hideDelayTimer);

			// store the timer so that it can be cleared in the mouseover if required
			hideDelayTimer = setTimeout(function () {
				hideDelayTimer = null;
				popup.animate({
					bottom: '-=' + distance + 'px',
					opacity: 0
				}, time, 'swing', function () {
					// once the animate is complete, set the tracker variables
					shown = false;
					// hide the popup entirely after the effect (opacity alone doesn't do the job)
					popup.css('display', 'none');
				});
			}, hideDelay);
		});
	});
});

smjQuery(document).ready(function() {
	smjQuery('#sm_accordian').accordion();
	smjQuery('#sm_accordian .head').click(function() {
		$(this).next().toggle('slow');
		return false;
	}).next().hide();
});