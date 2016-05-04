
$( document ).ready(function() {

	// Delete year
	$('.delete-year').click(function(){
		if (confirm("Are you sure you want to completely delete this year?")){
			var year = $(this).parent().find('.number');
			deleteYear(year[0].innerText);
		}
	});

	// Delete make
	$('.delete-make').click(function(){
		if (confirm("Are you sure you want to completely delete this make?")){
			var make = $(this).parent().find('.make');
			deleteMake(make[0].innerText);
		}
	});

	// Delete model
	$('.delete-model').click(function(){
		if (confirm("Are you sure you want to completely delete this model?")){
			var modelID = $(this).attr('data');
			deleteModel(modelID);
		}
	});

	// Delete model review
	$('.delete-model-review').click(function(){
		if (confirm("Are you sure you want to delete this review?")){
			var reviewID = $(this).attr('data');
			deleteModelReview(reviewID);
		}
	});

});

function deleteYear(year) {
	$.ajax({
	    url: "deleteyear",
	    type: "POST",
	    beforeSend: function (xhr) {
	        var token = $('meta[name="csrf_token"]').attr('content');
	        if (token) {
	              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	        }
	    },
	    data: { year : year },
	    success:function(data){
	        location.reload();
	    },error:function(){ 
	        location.reload();
	    }
	}); //end of ajax
};

function deleteMake(make) {
	$.ajax({
	    url: "deletemake",
	    type: "POST",
	    beforeSend: function (xhr) {
	        var token = $('meta[name="csrf_token"]').attr('content');
	        if (token) {
	              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	        }
	    },
	    data: { make : make },
	    success:function(data){
	        location.reload();
	    },error:function(){ 
	        location.reload();
	    }
	}); //end of ajax
};

function deleteModel(model) {

	var modelsURL = window.location.href;
	modelsURL = modelsURL.substr(0, modelsURL.lastIndexOf("/"));

	$.ajax({
	    url: "../deletemodel",
	    type: "POST",
	    beforeSend: function (xhr) {
	        var token = $('meta[name="csrf_token"]').attr('content');
	        if (token) {
	              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	        }
	    },
	    data: { model : model },
	    success:function(data){
	    	window.location.replace(modelsURL);

	    },error:function(){ 
	    	window.location.replace(modelsURL);
	    }
	}); //end of ajax
};

function deleteModelReview(review) {

	console.log(review);

	$.ajax({
	    url: "deletereview/"+review,
	    type: "POST",
	    beforeSend: function (xhr) {
	        var token = $('meta[name="csrf_token"]').attr('content');
	        if (token) {
	              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	        }
	    },
	    data: { review : review },
	    success:function(data){
	        location.reload();
	    },error:function(){ 
	        location.reload();
	    }
	}); //end of ajax
};