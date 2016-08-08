$(function(){

	// Delete confirmation
	$("a.delete").click(function(e) {
		e.preventDefault();

		if ( confirm("Are you sure you want delete?") ){
			window.location = $(this).attr("href");
		}

	});

	// Delete confirmation AJAX
	$("body").delegate('button.delete', 'click', function(e) {
		e.preventDefault();
	});

	// CTRL + S to save in admin
	$(document).keydown(function(event) {
		if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && event.which !== 19) return true;
		$(".save").trigger("click");
		event.preventDefault();
		return false;
	});

	$('ul.account').click(function(e){
		e.stopPropagation();
		$(this).find('.submenu-down').fadeToggle();
	})

	$('body').click(function(){
		$('ul.account').find('.submenu-down').fadeOut();
	})

	// on change submit sort
	$('.sort-search-wrap .select-style').change(function(){
		$(this).parent().submit();
	})

	// datapicker
	$('.datepicker').datepicker({
    	dateFormat: 'yy-mm-dd', 
    	altField: '#date', 
    	changeYear: true, 
    	yearRange: '1930:'+(new Date).getFullYear()
    });
    

});

$(window).load(function(){

    hideAlert();

    $( ".sortable" ).sortable({
	  	stop: function( event, ui ) {
			var order = [];
			var sortingObject = $(this);
			var link = sortingObject.data('link');

			sortingObject.find('.items-order').each(function(){
				order.push($(this).data('id'));
			});

			if ($(ui.item).next('.no-scrolable').length > 0){
				sortingObject.sortable('cancel');
				
			}

			if( !sortingObject.hasClass("no-ajax") ){
				$.post(link, { order:order}, function(data) {
		  			if(data=='Success'){
		  				$(sortingObject).append("<span class='alert alert-success'>Order saved!</span>")
		  			}else{
		  				$(sortingObject).append("<span class='alert alert-error'>Order saving error!</span>")
		  			}
		  			hideAlert();

		  			
				});
				
			}

	  	},

	  	cancel: ".no-scrolable"
	});

	$('.copy').click(function(){
		$(this).addClass('clicked');

		setTimeout(function(){
			$('.copy.clicked').removeClass('clicked');
		},1000)
	})


});


function codeAddress(address, proposal, resultsMap) {
	geocoder.geocode( { 'address': address}, function(results, status) {
	  	if (status == google.maps.GeocoderStatus.OK) {

            $('#latitude').val(results[0].geometry.location.lat())
            $('#longitude').val(results[0].geometry.location.lng())
			
			if( !empty(resultsMap) ){
				resultsMap.setCenter(results[0].geometry.location);
				deleteMarkers();

				var marker = new google.maps.Marker({
			    	icon: '../images/map-marker-orange.png',
					map: resultsMap,
					position: results[0].geometry.location
				});

				markers.push(marker);

			}

	  	} else {
	    	alert("We couldn't find your address: " + status);
		}

		if( !empty(proposal) ){
			var mapSrc = 'https://maps.googleapis.com/maps/api/staticmap?center='+results[0].geometry.location.lat()+','+results[0].geometry.location.lng()+'&zoom='+resultsMap.getZoom()+'&scale=2&size=640x300&maptype=roadmap&key=AIzaSyCvMo4tix_7-gqUXt4QQuA8buWLcxzLyMw&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xf17201%7Clabel:%7C'+results[0].geometry.location.lat()+','+results[0].geometry.location.lng()

			// $('#staticMapImage').attr('src',mapSrc);
			$('#mapImage').val(mapSrc);

			// $('.static-map-wrap').show();
		}


	});
}


function codeAddressAjax(item_id, address) {
	geocoder.geocode( { 'address': address}, function(results, status) {
	  	if (status == google.maps.GeocoderStatus.OK) {
	  		var data = {
	  			'latitude': results[0].geometry.location.lat(),
  				'longitude': results[0].geometry.location.lng()
	  		}

	  		updateTrackRecordItemLocation(item_id,data);

		}else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            setTimeout('codeAddressAjax('+item_id+',"'+address.replace(/'/g, '')+'")',1000);
	  	} else {
	    	alert("We couldn't find your address: " + status);
		}

	});
}


function updateTrackRecordItemLocation(item_id, data)
{

	$.post("administration/"+item_id+"/ajax/update-track-record-item-location", {data: data} ,function(data) {
		if(data=='Success'){
			$('[data-id='+item_id+']').find('.action').addClass('icon-ok');
		}else{
			// $('tr').append("<span class='alert alert-success'>Removed!</span>");
			// $('tr').append("<span class='alert alert-error'>Removing error!</span>");
		}
		// hideAlert();
		
		
	});
}


function hideAlert(){
	setTimeout(function(){
    	if( !$('.alert').hasClass('no-hide') ) {
        	$('.alert').slideUp();
    	}
    }, 5000);	
}

function ajaxDelete(url, id)
{
	if ( confirm("Are you sure you want delete?")) {
		$.post(url ,function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('table.no-header.main td').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('table.no-header.main td').append("<span class='alert alert-error'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function ajaxAddTrackRecord(url, item)
{
	var id =  item.value;

	$.post(url+"/"+id ,function(data) {
		if(data){
			$('.sortable tr').remove();

			$.each(data,function(key, value){
				if(value.image){
					$('.sortable').append('<tr class="items-order" data-id="'+value.id+'"><td class="image"><img height="40" src="'+value.image+'"></td><td class="title"><h5>'+value.title+'</h5><span>'+value.updated_at+'</span></td><td class="table-action two"><a href="administration/track-record/edit/'+value.id+'" class="button dark icon-pencil">Edit</a><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-track-record/'+value.id+'", '+value.id+')\' class="button light icon-trash-empty delete">Delete</button></td></tr>');
				}
				else{
					$('.sortable').append('<tr class="items-order" data-id="'+value.id+'"><td class="image"><img height="40" src="../images/no-image-x2.png"></td><td class="title"><h5>'+value.title+'</h5><span>'+value.updated_at+'</span></td><td class="table-action two"><a href="administration/track-record/edit/'+value.id+'" class="button dark icon-pencil">Edit</a><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-track-record/'+value.id+'", '+value.id+')\' class="button light icon-trash-empty delete">Delete</button></td></tr>');
				}
				
			})
  			hideAlert();
		}
		
	});
}

function ajaxAddCaseStudy(url, item)
{
	var id =  item.value;

	$.post(url+"/"+id ,function(data) {
		if(data){
			$('.case-study-table tr').remove();
			// $('.sortable').append('<tr class="no-scrolable"><th width="15%">Image</th><th>Title</th><th>Description</th><th width="10%">Price</th><th width="10%">Action</th></tr>');
			$.each(data,function(key, value){
				if(value.image){
					$('.case-study-table').append('<tr class="items-order" data-id="'+value.id+'"><td class="image"><img height="40" src="'+value.image+'"></td><td class="title"><h5>'+value.title+'</h5><span>'+value.updated_at+'</span></td><td class="table-action"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-case-study/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				}
				else{
					$('.case-study-table').append('<tr class="items-order" data-id="'+value.id+'"><td class="image"><img height="40" src="../images/no-image-x2.png"></td><td class="title"><h5>'+value.title+'</h5><span>'+value.updated_at+'</span></td><td class="table-action"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-case-study/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				}
				
			})
  			hideAlert();
		}
		
	});
}

function ajaxAddTeamMember(url, item)
{
	var id =  item.value;

	$.post(url+"/"+id ,function(data) {
		if(data){
			$('.sortable tr').remove();
			// $('.sortable').append('<tr class="no-scrolable"><th width="15%">Image</th><th>Name</th><th>Description</th><th width="10%">Action</th></tr>');
			$.each(data,function(key, value){
				if(value.image){
					$('.sortable').append('<tr class="items-order" data-id="'+value.id+'"><td width="13%"><img height="40" src="'+value.image+'"></td><td width="15%">'+value.name+'</td><td>'+value.role+'</td><td width="10%"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-case-study/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				}
				else{
					$('.sortable').append('<tr class="items-order" data-id="'+value.id+'"><td width="13%"><img height="40" src="../images/no-image-x2.png"></td><td width="15%">'+value.name+'</td><td>'+value.role+'</td><td width="10%"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-team-member/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				}
				
			})
  			hideAlert();
		}
		
	});
}

function ajaxAddBenefit(url, item)
{
	var id =  item.value;

	$.post(url+"/"+id ,function(data) {
		if(data){
			$('.benefit-table tr').remove();
			// $('.sortable').append('<tr class="no-scrolable"><th>Title</th><th width="10%">Action</th></tr>');
			$.each(data,function(key, value){
				$('.benefit-table').append('<tr class="items-order" data-id="'+value.id+'"><td>'+value.description+'</td><td width="10%"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-benefit/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
			})
  			hideAlert();
		}
	});
}

function ajaxDeleteProposalImage(url, id) {

	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.proposal-images li').remove();
				$.each(data,function(key, value){
					$('.proposal-images').append('<li class="items-order" data-id="'+value.id+'"><div class="buttons"><div onclick=\'ajaxDeleteProposalImage(\"administration/proposal/'+value.proposal_id+'/ajax/delete-proposal-image/'+value.id+'", '+value.id+')\' class="button remove-image delete">Delete</div></div><img src="'+value.source+'" /></li>');

				})
				$('.proposal-images').sortable();
				
			}
		});
	}
}

function refreshProposalImage(){
	var proposalId = $('#proposalForm').data('proposal-id');
	$.post('administration/proposal/'+proposalId+'/ajax/get-proposal-images',function(data) {
		if(data){
			$('.proposal-images li').remove();
			$.each(data,function(key, value){
				$('.proposal-images').append('<li class="items-order" data-id="'+value.id+'"><div class="buttons"><div onclick=\'ajaxDeleteProposalImage(\"administration/proposal/'+value.proposal_id+'/ajax/delete-proposal-image/'+value.id+'", '+value.id+')\' class="buton remove-image delete">Delete</div></div><img src="'+value.source+'" /></li>');

			})
			$('.proposal-images').sortable();
			
		}
		
	});

}

function refreshProposalExcel(){
	location.reload();
}


function refreshProposalPricingAnalysis(){
	var proposalId = $('#proposalForm').data('proposal-id');
	$.post('administration/proposal/'+proposalId+'/ajax/get-proposal-pricing-analysis-excel',function(data) {
		if(data){
			$('.proposal-pricing-analysis .items-order').remove();
			$.each(data,function(key, value){
				$('.proposal-pricing-analysis').append('<div class="auto-box items-order" data-id="'+value.id+'"><div class="line"></div><div class="subtitle">'+value.title+'</div><div class="box-content">'+value.rate+'%</div><div class="price-wrap"><div class="price-title">PRICE</div><div class="price">$'+value.price+'</div></div><div class="price-wrap"><div class="price-title">PRICE/SF</div><div class="price">$'+value.price_sf+'</div></div><div onclick=\'ajaxDeleteProposalPricingAnalysis(\"administration/proposal/'+proposalId+'/ajax/delete-proposal-pricing-analysis/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete small no-margin">Delete</div></div>');
				
			})
		}
		
	});

}

function ajaxDeleteProposalPricingAnalysis(url, id) {

	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.proposal-pricing-analysis .items-order').remove();
				$.each(data,function(key, value){
					$('.proposal-pricing-analysis').append('<div class="auto-box items-order" data-id="'+value.id+'"><div class="line"></div><div class="subtitle">'+value.title+'</div><div class="box-content">'+value.rate+'%</div><div class="price-wrap"><div class="price-title">PRICE</div><div class="price">$'+value.price+'</div></div><div class="price-wrap"><div class="price-title">PRICE/SF</div><div class="price">$'+value.price_sf+'</div></div><div onclick=\'ajaxDeleteProposalPricingAnalysis(\"administration/proposal/'+value.proposal_id+'/ajax/delete-proposal-pricing-analysis/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete small no-margin">Delete</div></div>');
					
				})
			}

		});
	}
}

function refreshProposalAnnualizedOperatinData(){
	var proposalId = $('#proposalForm').data('proposal-id');
	$.post('administration/proposal/'+proposalId+'/ajax/get-proposal-operating-data-excel',function(data) {
		if(data){
			$('.annualized-operating-data tr').remove()
			$.each(data,function(key, value){
				$('.annualized-operating-data').append('<tr class="items-order" data-id="'+value.id+'"><td class="left">'+value.title+'</td><td class="center">'+value.value+'</td><td class="right"><button onclick=\'ajaxDeleteProposalOperatingData(\"administration/proposal/'+proposalId+'/ajax/delete-proposal-operating-data/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				
			})
		}
		
	});

}

function ajaxDeleteProposalOperatingData(url, id) {

	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.annualized-operating-data tr').remove()
				$.each(data,function(key, value){
					$('.annualized-operating-data').append('<tr class="items-order" data-id="'+value.id+'"><td class="left">'+value.title+'</td><td class="center">'+value.value+'</td><td class="right"><button onclick=\'ajaxDeleteProposalOperatingData(\"administration/proposal/'+value.proposal_id+'/ajax/delete-proposal-operating-data/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
					
				})
			}
		});
	}
}

function refreshProposalDemographyExcel(){
	var proposalId = $('#proposalForm').data('proposal-id');
	$.post('administration/proposal/'+proposalId+'/ajax/get-proposal-demography-excel',function(data) {
		if(data){
			$('.proposal-demographics tr').remove()
			$.each(data,function(key, value){
				$('.proposal-demographics').append('<tr class="items-order" data-id="'+value.id+'"><td width="35%">'+value.title+'</td><td width="17%">'+Number(value.one_mile).numberFormat(0)+'</td><td width="15%">'+Number(value.three_mile).numberFormat(0)+'</td><td>'+Number(value.five_mile).numberFormat(0)+'</td><td width="15%"><button onclick=\'ajaxDeleteProposalDemography(\"administration/proposal/'+proposalId+'/ajax/delete-proposal-demography/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				
			})
		}
		
	});
}

function ajaxDeleteProposalDemography(url, id){
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.proposal-demographics tr').remove()
				$.each(data,function(key, value){
					$('.proposal-demographics').append('<tr class="items-order" data-id="'+value.id+'"><td width="35%">'+value.title+'</td><td width="17%">'+Number(value.one_mile).numberFormat(0)+'</td><td width="15%">'+Number(value.three_mile).numberFormat(0)+'</td><td>'+Number(value.five_mile).numberFormat(0)+'</td><td width="15%"><button onclick=\'ajaxDeleteProposalDemography(\"administration/proposal/'+value.proposal_id+'/ajax/delete-proposal-demography/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
					
				})
			}
		});
	}
}

function refreshTeamMemberImage(id){
	$.post('administration/'+id+'/ajax/get-team-member-image', function(data) {
		if(data){
			$('.test').remove();
			$.each(data,function(key, value){
				$('.image').append('<div class="test"><ul class="image-list cf" style="display: inline-block"><li><div class="buttons"><button onclick=\'ajaxDeleteTeamMemberImage(\"administration/'+value.id+'/ajax/delete-team-member-image", '+value.id+')\' class="remove-image delete">Delete</button></div><img src="'+value.source+'"</li></ul></div>');
			})
		}
	});
}

function ajaxDeleteTeamMemberImage(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.test').remove();
				$('.image').append('<div class="test"><label>Image for Team member:</label><br><br><iframe class="cf" src="administration/upload/team-member-image/'+data+'"></iframe></div>');					
			}
		});
	}
}

function refreshTrackRecordLogo(id){
	$.post('administration/'+id+'/ajax/get-track-record-logo', function(data) {
		if(data){
			$('.test').remove();
			$.each(data,function(key, value){
				$('.image').append('<div class="test"><ul class="image-list cf" style="display: inline-block"><li><div class="buttons"><button onclick=\'ajaxDeleteTrackRecordLogo(\"administration/'+value.id+'/ajax/delete-track-record-logo", '+value.id+')\' class="remove-image delete">Delete</button></div><img src="'+value.source+'"</li></ul></div>');
			})
		}
	});
}

function ajaxDeleteTrackRecordLogo(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.test').remove();
				$('.image').append('<div class="test"><label>Track record logo:</label><br><br><iframe class="cf" src="administration/upload/track-record-logo/'+data+'"></iframe></div>');					
			}
		});
	}
}

function refreshSalesComparableImage(id){
	$.post('administration/'+id+'/ajax/get-sales-comparable-image', function(data) {
		if(data){
			$('.test').remove();
			$.each(data,function(key, value){
				$('.image').append('<div class="test"><ul class="image-list cf" style="display: inline-block"><li><div class="buttons"><div onclick=\'ajaxDeleteSalesComparableImage(\"administration/'+value.id+'/ajax/delete-sales-comparable-image", '+value.id+')\' class="button remove-image delete">Delete</div></div><img src="'+value.source+'"</li></ul></div>');
			})
		}
	});
}

function ajaxDeleteSalesComparableImage(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.test').remove();
				$('.image').append('<div class="test"><label>Sales comparable image:</label><br><br><iframe class="cf" src="administration/upload/sales-comparable-image/'+data+'"></iframe></div>');					
			}
		});
	}
}

function refreshCaseStudyImage(id){
	$.post('administration/'+id+'/ajax/get-case-study-image', function(data) {
		if(data){
			$('.test').remove();
			$.each(data,function(key, value){
				$('.image').append('<div class="test"><ul class="image-list cf" style="display: inline-block"><li><div class="buttons"><button onclick=\'ajaxDeleteCaseStudyImage(\"administration/'+value.id+'/ajax/delete-case-study-image", '+value.id+')\' class="remove-image delete">Delete</button></div><img src="'+value.source+'"</li></ul></div>');
			})
		}
	});
}

function ajaxDeleteCaseStudyImage(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.test').remove();
				$('.image').append('<div class="test"><label>Case study image:</label><br><br><iframe class="cf" src="administration/upload/case-study-image/'+data+'"></iframe></div>');					
			}
		});
	}
}

function ajaxDeleteTeamMember(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('.sort-search-wrap').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('.sort-search-wrap').append("<span class='alert alert-error no-top'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function ajaxDeleteBenefit(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('.sort-search-wrap').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('.sort-search-wrap').append("<span class='alert alert-error no-top'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function ajaxDeleteTrackRecord(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('.sort-search-wrap').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('.sort-search-wrap').append("<span class='alert alert-error no-top'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function ajaxDeleteSalesComparable(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('.sort-search-wrap').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('.sort-search-wrap').append("<span class='alert alert-error no-top'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function ajaxDeleteCaseStudy(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('.sort-search-wrap').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('.sort-search-wrap').append("<span class='alert alert-error no-top'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function refreshCaseStudyExcel(){
	
	window.location = "administration/case-study";

}

function refreshSalesComparableExcel(){
	
	window.location = "administration/sales-comparable";

}

function refreshTrackRecordExcel(){
	
	window.location = "administration/track-record";

}

function refreshTrackRecordItemExcel(id){
	$.post('administration/'+id+'/ajax/get-track-record-item-excel', function(data) {
		if (data) {
			$('.track-table').slideDown();
			$('.sortable tr').remove();
			$('.sortable').append('<tr class="no-scrolable"><th>Name</th><th>Location</th><th>State</th><th>Price</th><th>Square Feet</th><th width="30%" align="center"></th></tr>');
			$.each(data,function(key, value){
				var tr = $('<tr class="items-order" data-id="'+value.id+'"><td>'+value.name+'</td><td>'+value.location+'</td><td>'+value.state+'</td><td>'+value.price+'</td><td>'+value.square_feet+'</td><td class="table-action two action"><a href="administration/track-record/edit-track-record-item/'+value.id+'" class="button dark icon-pencil">Edit</a><button onclick=\'ajaxDeleteTrackRecordItem(\"administration/'+value.id+'/ajax/delete-track-record-item\", '+value.id+')\' class="button light icon-trash-empty delete">Delete</button></td></tr>');

				$('.sortable').append(tr);

				if( empty(value.latitude) ){
					var address = value.location+','+value.state;
					setTimeout("codeAddressAjax("+value.id+", '"+address.replace(/'/g, '')+"')", 200*key)	
				}else{
					tr.find('.action').addClass('icon-ok');
				}
			})
  			hideAlert();
		}
	});
}

function ajaxDeleteTrackRecordItem(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.items-order[data-id='+ id +']').remove();
  				$('tr').append("<span class='alert alert-success'>Removed!</span>");

	  			hideAlert();
			}
			else{	  				
				$('tr').append("<span class='alert alert-error'>Removing error!</span>");
			}
		});
	}
}


function refreshTmpImage() {
	$.post('administration/0/ajax/get-tmp-image-create', function(data) {
		if (data) {
			$('.test').hide();
			$.each(data,function(key, value) {
				$('.image').append('<ul class="image-list cf" style="display: inline-block"><li><div class="buttons"><button onclick="deleteTmpImage()" class="remove-image delete">Delete</button></div><img src="'+value.source+'"</li><input type="hidden" name="source" value="'+value.source+'"><input type="hidden" name="thumb_source" value="'+value.thumb_source+'"><input type="hidden" name="mobile_source" value="'+value.mobile_source+'"><input type="hidden" name="path_source" value="'+value.path_source+'"></ul>');
			})
		}
	});
}

function deleteTmpImage() {
	
	if ( confirm("Are you sure you want delete?")) {
		$.post("administration/0/ajax/delete-tmp-image", function(data) {
			$('.test').show();
			$('.image-list').remove();					
		});
	}
}

function deleteTmpImageWithoutConfirm() {
	
	$.post("administration/0/ajax/delete-tmp-image", function(data) {
		$('.test').show();
		$('.image-list').remove();					
	});
}

function refreshProposalDocument(){
	var proposalId = $('#proposalForm').data('proposal-id');
	$.post('administration/proposal/'+proposalId+'/ajax/get-proposal-document',function(data) {
		if(data){
			$.each(data,function(key, value){
				$('.proposal-document').append('<div class="document-'+value.id+'"><h4>Document</h4><a href="'+value.document+'" download>Download document</a><br><br><div onclick="ajaxDeleteDocument(\'administration/proposal/'+value.proposal_id+'/ajax/delete-proposal-document/'+value.id+'\', '+value.id+')" class="button dark icon-trash-empty delete small no-margin">Delete</div></div>');
			})
		}
	$('.navigation li a').eq(0).click();
	});
}

function ajaxDeleteDocument(url, id){

	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if (data){
				$('.document-'+ id +'').remove();
  				$('proposal-document').append("<span class='alert alert-success'>Removed!</span>");

	  			hideAlert();
			}
			else {	  				
				$('proposal-document').append("<span class='alert alert-error'>Removing error!</span>");
			}
		});
	}
}

function ajaxDeleteClient(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
	  			if(data=='Success'){
					$('.items-order[data-id='+ id +']').remove();
	  				$('.sort-search-wrap').append("<span class='alert alert-success no-top'>Removed!</span>")
	  			}else{
	  				$('.sort-search-wrap').append("<span class='alert alert-error no-top'>Removing error!</span>")
	  			}
	  			hideAlert();
			}			
		});
	}
}

function refreshClientImage(id){
	$.post('administration/'+id+'/ajax/get-client-image', function(data) {
		if(data){
			$('.test').remove();
			$.each(data,function(key, value){
				$('.image').append('<div class="test"><ul class="image-list cf" style="display: inline-block"><li><div class="buttons"><button onclick=\'ajaxDeleteClientImage(\"administration/'+value.id+'/ajax/delete-client-image", '+value.id+')\' class="remove-image delete">Delete</button></div><img src="'+value.source+'"</li><input type="hidden" name="source" value="'+value.source+'"><input type="hidden" name="thumb_source" value="'+value.thumb_source+'"><input type="hidden" name="mobile_source" value="'+value.mobile_source+'"><input type="hidden" name="path_source" value="'+value.path_source+'"></ul></div>');
			})
		}
	});
}

function ajaxDeleteClientImage(url, id){
	
	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('.test').remove();
				$('.image').append('<div class="test"><label>Case study image:</label><br><br><iframe class="cf" src="administration/upload/client-image/'+data+'"></iframe></div>');					
			}
		});
	}
}

function ajaxAddClient(url, item)
{
	var id =  item.value;

	$.post(url+"/"+id ,function(data) {
		if(data){
			$('.no-sortable tr').remove();
			$.each(data,function(key, value){
				if(value.image){
					$('.no-sortable').append('<tr class="items-order" data-id="'+value.id+'"><td width="13%"><img height="40" src="'+value.image+'"></td><td width="15%">'+value.name+'</td><td>'+value.company+'</td><td width="10%"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-client/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				}
				else{
					$('.no-sortable').append('<tr class="items-order" data-id="'+value.id+'"><td width="13%"><img height="40" src="../images/no-image-x2.png"></td><td width="15%">'+value.name+'</td><td>'+value.company+'</td><td width="10%"><button onclick=\'ajaxDelete(\"administration/proposal/'+value.proposal_id+'/ajax/delete-client/'+value.id+'", '+value.id+')\' class="button dark icon-trash-empty delete">Delete</button></td></tr>');
				}
				
			})
  			hideAlert();
		}
		
	});
}