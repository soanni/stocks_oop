 function round(d) {
	 return Math.round(100 * d) / 100;
 }

console.log('Start logging chart.js..');

$(document).ready(function () {
	$('input[type="submit"]').click(function(e){
		$('div.ui-jqchart').remove();
		$('input[type="checkbox"]:checked').each(function(){
			//var companyName = $(this).prev().text();
			var data = [];
			var companyname = $(this).parent().text().trim();
			//console.log(companyname);
			var obj = {companyid: $(this).val(),
					   startdate : '20150215',
					   enddate: '20150430'};
			$.post('http://localhost/stock/charts/get_rates.php',obj,function(d){
				var res = $.parseJSON(d);
				for (i = 0; i < res.length; i++){
					data.push( [res[i].ratedate, round(res[i].maximum), round(res[i].minimum), round(res[i].openrate), round(res[i].closerate)] );
				}
				$('<div></div>')
					.css({'width': '1100px',
						'height': '250px',
						'margin': '10px'})
					.jqChart({
						title: { text: companyname},
						legend: { visible: false },
						animation: { duration: 1 },
						shadows: {
							enabled: true
						},
						series: [
							{
								title: 'Price Index',
								type: 'candlestick',
								data: data,
								priceUpFillStyle: 'white',
								priceDownFillStyle: 'black',
								strokeStyle: 'black'
							}
						]
					})
					.appendTo('#chart');
			});	
		});
		e.preventDefault();
	});
	

	$('.jqChart').bind('tooltipFormat', function (e, data) {

		var tooltip = '<div style="color:' + data.series.fillStyle + '">' + data.series.title + '</div>';

		var date = data.chart.stringFormat(data.x, "mmm d, yyyy");

		tooltip += "Date: <b>" + date + "</b><br />" +
				   "Open: <b>" + data.open + "</b><br />" +
				   "High: <b>" + data.high + "</b><br />" +
				   "Low: <b>" + data.low + "</b><br />" +
				   "Close: <b>" + data.close + "</b>";


		return tooltip;
	});
});

// function fillData(r){
	// var obj = {companyid: 1,
			   // startdate : '20150216',
			   // enddate: '20150220'};
	// $.post('http://localhost/stock/get_rates.php',obj,function(data){
		// var res = $.parseJSON(data);
		// for (i = 0; i < res.length; i++){
			// r.push([res[i].ratedate, res[i].maximum, res[i].minimum, res[i].openrate, res[i].closerate]);
		// }
		// console.log(r);
	// });

// }