$(document).ready(function(){
	$('#navigation').accordion({header: 'h3'});
	$('#navigation').accordion('activate', 0);
	
	var $window = $(window),$navigation = $('nav');
	$window.scroll(function() {
		if (!$navigation.hasClass("fixed") && ($window.scrollTop() > $navigation.offset().top)) {
			$navigation.addClass("fixed").data("top", $navigation.offset().top);
		}
		else if ($navigation.hasClass("fixed") && ($window.scrollTop() < $navigation.data("top"))) {
			$navigation.removeClass("fixed");
		}
	}); 
	$('nav li').hover(
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
	////////////////////// Top of page animation	
	$('li.topofpage > a[href=#]').click(function(e){
		$.scrollTo(0,'slow');
		e.preventDefault();
	});
	
	$('#exchanges').tabs();
	
	//////////////////////////////////////////	LOGIN
	//$('#login form').hide();
	//$('#login a').toggle(function() {
	//$(this)
	//  .addClass('active')
	//  .next('form')
	//  .animate({'height':'show'}, {
	//	duration: 'slow',
	//	easing: 'easeOutBounce'
	//  });
	//}, function() {
	//$(this)
	//  .removeClass('active')
	//  .next('form')
	//  .slideUp();
	//});
	//$('#login form :submit').click(function() {
	//$(this)
	//  .parent()
	//  .prev('a')
	//  .click();
	//});
	
	//overlay
	$('<div></div>')
		.attr('id', 'overlay')
		.css('opacity', 0.65)
		.hover(
			function(){
				$(this).addClass('active');
			}, 
			function(){
				$(this).removeClass('active');
				setTimeout(function(){
					$('#overlay:not(.active)').slideUp(function(){
						$('a.imglogin-hover').removeClass('imglogin-hover');
						});
					}, 800);
			})
		.appendTo('body');
		
	$('.imglogin a').mouseover(
		function(){
			$(this).addClass('imglogin-hover');
			$('#overlay:not(:animated)')
			.addClass('active')
			.html('<h1>Please log in</h1><a href="login.html.php">Login</a>&nbsp')
			.slideDown();      
		}
	);

    // Rates DataTable plugin
    $("#rates").DataTable();
    // Rates table header
    //TABLE.fixHeader("#rates");
	
	// $('#menu li ul').css({
		// display: "none",
		// left: "auto"
	// });
	// $('#menu li').hover(function() {
		// $(this)
			// .find('ul')
			// .stop(true, true)
			// .slideDown('fast');
		// }, function() {
			// $(this)
			// .find('ul')
			// .stop(true,true)
			// .fadeOut('fast');
	// });
	// $('#menu > li > ul')
		// .hide()
		// .click(function(event){
			// event.stopPropagation();
			// }
		// );
	// $('#menu > li').toggle(function(){
			// $(this)
				// .css('background-position', 'right -20px')
				// .find('ul')
				// .slideDown();
		// },
		// function()
		// {
			// $(this)
				// .css('background-position', 'right top')
				// .find('ul')
				// .slideUp();
		// }
	// );
});

var TABLE = {};

TABLE.fixHeader = function(table) {
    $(table).each(function() {
        var $table = $(this);
        var $thead = $table.find('thead');
        var $ths = $thead.find('th');
        var timer = false;
        $table.data('top', $thead.offset().top);
        $table.data('left', $thead.offset().left);
        $table.data('bottom', $table.data('top') + $table.height() - $thead.height());

        var $list = $('<ul class="faux-head"></ul>');
        $ths.each(function(i) {
            _th = $(this);
            $list.append($("<li></li>")
                    .addClass(_th.attr("class"))
                    .html(_th.html())
                    .width(_th.width())
                    .click(function(){
                        _th.click()
                    })
            ).hide().css({left: $table.data('left'), top: $table.data('top')});
        });
        $('body').append($list);

        $(window).scroll(function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                if ($table.data('top') < $(document).scrollTop() && $(document).scrollTop() < $table.data('bottom')) {
                    $list
                        .show()
                        .stop()
                        .animate({
                            top: $(document).scrollTop(),
                            opacity: 1
                        });
                } else {
                    $list.fadeOut(function() {
                        $(this).css({top: $table.data('top')});
                    });
                }
            }, 100);
        });
    });
}


