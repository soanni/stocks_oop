 function round(d) {
	 return Math.round(100 * d) / 100;
 }

console.log('Start logging chart.js..');
 $(document).ready(function () {

 });

$(document).ready(function () {
	$('input[type="submit"]').click(function(e){
        $('#chart > div').remove();
		$('input[type="checkbox"]:checked').each(function(){
			var data = [];
			var companyname = $(this).parent().text().trim();
			//console.log(companyname);
            console.log($(this).val());
			var obj = {companyid: $(this).val(),
					   startdate : '20140101',
					   enddate: '20150430'};
			$.post('http://stocks_oop.ubuntu/charts/get_rates.php',obj,function(d){
				var res = $.parseJSON(d);
                console.log(res);
				for (i = 0; i < res.length; i++){
                    var time = new Date(String(res[i].ratedate).slice(0,4)
                        ,parseInt(String(res[i].ratedate).slice(5,7))-1
                        ,String(res[i].ratedate).slice(8,10)).getTime();
                    console.log(time);
                    console.log(new Date(time));
					data.push(
                        //[res[i].ratedate
                        [time
                        , round(res[i].openrate)
                        , round(res[i].maximum)
                        , round(res[i].minimum)
                        , round(res[i].closerate)] );
				}
				$('<div></div>')
					.css({'width': '1100px',
						'height': '500px',
						'margin': '10px'})
                    .highcharts('StockChart', {
                        chart : {
                            type: 'candlestick'
                        },
                        rangeSelector : {
                            allButtonsEnabled: true,
                            selected: 2
                        },
                        title : {
                            text : companyname
                        },
                        series: [{
                            data: data
                        }]
                    })
					.appendTo('#chart');
			});	
		});
		e.preventDefault();
	});

});
