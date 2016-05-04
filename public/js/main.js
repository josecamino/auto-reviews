$(document).ready(function(){
	// Home page tabs
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });

    // Rankings page category selection
    $('#rankings-form .cat').click(function(){

    	if( $(this).hasClass('active') ) {
    		$(this).removeClass('active');
    	}
    	else {
    		var type = $(this).attr('type');
    		$('#rankings-form .cat[type="'+type+'"]').removeClass('active');
    		$(this).addClass('active');
    	}
    });

    // Rankings page submit
    $('#rankings-form #btn-continue').click(function(){

    	var url = $('#rankings-form #view-all').attr('href');
    	var categories = $('#rankings-form .cat.active');
    	var index = 1;

    	categories.each(function(){

    		if (index == 1) {
    			if ( $(this).attr('type') == 'body' ) {
    				url += "?body=" + $(this).text().toLowerCase().trim() + "&cat=";
    			}
    			else {
    				if (index == categories.length) {
    					url += "?cat=" + $(this).text().toLowerCase().trim();
    				}
    				else {
    					url += "?cat=" + $(this).text().toLowerCase().trim() + ",";
    				}
    			}
    		}
    		else {
    			if (index == categories.length) {
    				url += $(this).text().toLowerCase().trim();
    			}
    			else {
    				url += $(this).text().toLowerCase().trim() + ",";
    			}
    		}

    		index++;
    	});

    	window.location.href = url;
    });

});