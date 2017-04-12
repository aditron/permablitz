jQuery(document).ready(function($){

	$(".owl-carousel").owlCarousel({
	    
	    loop:true,
	    margin:10,
	    autoWidth:true,
	    nav:true,
	    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:2
        }
    }
	});

	var totalItems = $('#pictures .item').length;
	// var currentIndex = $('#pictures .active').index() + 1;
	if (totalItems) {
		$('.pic-num').html('Explore the '+totalItems+' images above!');
	}
	changeVolunteerStatus();
	sendVolunteerEmails()
});

jQuery(window).load(function() {
  jQuery('.bookings .record').matchHeight();
  jQuery('.row .grid').matchHeight();
	changeStats();
});

function changeStats() {
if ( jQuery('.stats').length ) {

var yes_sum = 0;
jQuery('.yes .num').each(function(){
    yes_sum += parseFloat(jQuery(this).text());  // Or this.innerHTML, this.innerText
});
jQuery('.show-attending').html(yes_sum);

var no_sum = 0;
jQuery('.no .num').each(function(){
    no_sum += parseFloat(jQuery(this).text());  // Or this.innerHTML, this.innerText
});
jQuery('.show-notattending').html(no_sum);

var unassigned_sum = 0;
jQuery('.unassigned .num').each(function(){
    unassigned_sum += parseFloat(jQuery(this).text());  // Or this.innerHTML, this.innerText
});
jQuery('.show-unassigned').html(unassigned_sum);

var waiting_sum = 0;
jQuery('.waiting-list .num').each(function(){
    waiting_sum += parseFloat(jQuery(this).text());  // Or this.innerHTML, this.innerText
});
jQuery('.show-waitinglist').html(waiting_sum);

}
}

function sendVolunteerEmails() {

	if ( jQuery('.send-container a').length ){

		// jQuery('.send-container a').on('click', function(event) {
		jQuery(".send-container a").click(function(event){
			event.preventDefault();
			jQuery(this).closest('.send-container').empty().html('<i class="fa fa-spinner fa-spin fa-fw"></i>');

			    jQuery.post('/wp-admin/admin-ajax.php', {
					form_id: jQuery(this).attr("data-id"),
					action: 'pbz_handleSendToVols'
			    },
			    function(data) {
				if (data.success) {
					jQuery(this).closest('.send-container').empty().html('<strong>Sent</strong>');
				}
				else {
					jQuery(this).closest('.send-container').empty().html('<strong class=error">Send Failed</strong>');
			}
		    }, 'json');

		});

	}
}

function changeVolunteerStatus() {

if ( jQuery('.bookings .record').length ) {

	jQuery('.bookings .record select').on('change', function() {
	   var mySelect = jQuery(this);
	    jQuery.post('/wp-admin/admin-ajax.php', {
			field_id: mySelect.attr("data-field"),
			form_id: mySelect.attr("data-form"),
			member_id: mySelect.attr("data-member"),
			status: mySelect.val(),
			action: 'pbz_changeVolStatus'
	    },
	    function(data) {
		if (data.success) {
			mySelect.closest('.grid').removeClass('yes');
			mySelect.closest('.grid').removeClass('waiting-list');
			mySelect.closest('.grid').removeClass('no');
			mySelect.closest('.grid').addClass(data.class);
			changeStats();

		    // if (jQuery('form#newsletter-submit')) {
		    // 	jQuery('#newsletter-submit').slideUp('slow', function(){
		    // 		jQuery('#enews_thanks').slideDown('slow');
		    // 	});
		    // }
		}
		else {
		    /* fail */
		}
	    }, 'json');

	});

    }
}


jQuery(window).resize(function(){
  jQuery('.bookings .record').matchHeight();
});
