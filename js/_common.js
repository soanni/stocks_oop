$(document).ready(function(){
	console.log("Start logging..");
	$('table#rates').find('td#closerate').slice(1).each(function(){
		var prev = $(this).prev().text();
		var current = $(this).text()
		if(prev > current){
			$(this).css("border","2px solid red");
		}
	});	
	// $('form').submit(function(event){
		// var error = false;
		// $(this).find('[type=text]').each(function(){
			// if(!$(this).val().length){
				// alert("Textboxes must have a value!");
				// $(this).focus();
				// error = true;
				// return false;
			// }
		// });
		// if(error){
			// event.preventDefault();
		// }
	// });
	
	var $window = $(window),$navigation = $("#navigation");
	$window.scroll(function() {
		if (!$navigation.hasClass("fixed") && ($window.scrollTop() > $navigation.offset().top)) {
			$navigation.addClass("fixed").data("top", $navigation.offset().top);
		}
		else if ($navigation.hasClass("fixed") && ($window.scrollTop() < $navigation.data("top"))) {
			$navigation.removeClass("fixed");
		}
	}); 
	$('#navigation li').hover(
		function(){
			$(this)
			.stop(true)
			.animate(
				{
					height: '120px'
				},
				{
					duration: 500, 
					easing: 'easeOutBounce'
				}
			);
		},
		function(){
			$(this)
			.stop(true)
			.animate(
				{
					height: '20px'
				},
				{
					duration: 500, 
					easing: 'easeOutCirc'
				}
			);
		}
	);		
});
/*
$(document).ready(function(){
	stylesheetToggle();
	
	var $window = $(window),$navigation = $("#navigation");
	
	$window.resize(stylesheetToggle);
	
	$window.scroll(function() {
		if (!$navigation.hasClass("fixed") && ($window.scrollTop() > $navigation.offset().top)) {
			$navigation.addClass("fixed").data("top", $navigation.offset().top);
		}
		else if ($navigation.hasClass("fixed") && ($window.scrollTop() < $navigation.data("top"))) {
			$navigation.removeClass("fixed");
		}
	}); 
	$('#navigation li').hover(
		function(){
			$(this)
			.stop(true)
			.animate(
				{
					height: '120px'
				},
				{
					duration: 500, 
					easing: 'easeOutBounce'
				}
			);
		},
		function(){
			$(this)
			.stop(true)
			.animate(
				{
					height: '20px'
				},
				{
					duration: 500, 
					easing: 'easeOutCirc'
				}
			);
		}
	);
	$('a[href=#]').click(function(){
		$('#quotes').animate({scrollTop: $('#quotes').scrollTop()},'slow');
		return false;
	});
	
	$window.resize(
		function(){
			alert("Resize");
		}
	);
	$('#quotes').jScrollPane({verticalGutter: 20});
	$('h1')
		.effect('shake', {times:3}, 300)
		.effect('highlight', {}, 3000)
		.hide('explode', {}, 1000);
	
	$('<div id="navigation_blob"></div>').css(
		{
			width: 0,
			height: $('.navigation li:first a').height() + 10
		}).appendTo('.navigation');
	$('.navigation a').hover(
		function(){
			$('#navigation_blob').animate(
				{
					width: $(this).width() + 10,
					left: $(this).position().left
				},
				{
				duration:'slow',
				easing: 'easeOutCirc',
				queue: false
				}
			)
		},
		function(){

			$('#navigation_blob').animate(
				{
					width: $(this).width() + 10,
					left: $(this).position().left
				},
				{
					duration:'slow',
					easing: 'easeOutCirc',
					queue: false
				}).animate(
					{
					left: $('.navigation li:first a').position().left
					}, 'fast');
		}
	);
	$('#navigation > div').hide();
	$('#navigation > div:first').show();
	$('#navigation h5').click(
		function(){
			$(this).next().animate({height:'show'},'slow','linear');
		}
	);
	$('h1').animate({'backgroundColor':'#ff9f5f'},2000).slideDown('slow').fadeOut();
	$("li").hover(
		function(){
			$(this).animate({'height': '+=100px'},2000,'easeOutElastic');
		},
		function(){
			$(this).animate({'height': '-=100px'},2000,'easeOutElastic');
		});	
	$("h1").animate({'backgroundColor': '#ff9f5f'},200);

});

function stylesheetToggle(){
	if($('body').width() > 900){
		$('#navigation').css('right': 0);
	}
	else{
		$('#navigation').css('left': 0);
	}
};

$(document).ready(function(){
	$("#contactname").val("Please enter your full name");
	$("#telephone").val("Including your local code");
	$("#eventdate").val("Format DDMMYYYY");
	$("#details").val("Please provide us as much as possible");
	$("input,textarea").focus(function(){
		$(this).select();
	});
	// hiding captions
	$("figcaption").hide();
	$("figure").each(function()
		{
			$(this).hover(
				function(){
					$(this).find("figcaption").slideDown("medium");
				},
				function(){
					$(this).find("figcaption").slideUp("medium");
				}
			);
		}
	);
	//$("table.events tr:even").css({'background-color': '#dddddd','color': '#666666'});
	//$("table.events tr:even").addClass("zebra");
	
	$('<input>',{
		'class': 'butn',
		'type': 'button',
		'id': 'toggleButton',
		'value': 'toggle',
		'click': function(){
			//$('#tagline').toggle('slow');
			$('#tagline').slideToggle('slow',function(){alert("The slide has finished sliding");});
			if($('#tagline').is(":visible")){
				//$('#tagline').fadeOut('slow');
				$(this).val("Hide");
			}
			else{
				//$('#tagline').fadeIn('slow');
				$(this).val("Show");
			}
		}
	}).appendTo("nav ul");
	
	$("#no-script").remove();
	
 	$("table.events").mouseover(function(){
		$(this).addClass("zebraHover");
	});
	
	$("table.events").mouseout(function(){
		$(this).removeClass("zebraHover");
	}); 
	
	$("table.events tr").hover(function(){
			$(this).addClass("zebraHover");
		},
		function(){
			$(this).removeClass("zebraHover");
		});

	$("table.events tr").click(function(){
		$(this).toggleClass("zebraHover");
		//alert("Click!");
	});
	
	
});*/