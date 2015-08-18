$(document).ready(function(){
	$('#addrate').validate(
		{
			rules: {
				quote:{required: true},
				openrate:{required: true, min: 0.00001},
				closerate:{required: true, min: 0.00001},
				ratedate:{required: true},
				dayminimum:{required: true, min: 0.00001},
				daymaximum:{required: true, min: 0.00001}
			},
			success: function(label){
				label.text('OK').addClass('valid');
			}		
		}
	);
	$('select[name="quote"]').change(function(){
		var obj = {quoteid: $(this).val()};
		$.post('ajax.php',obj,function(data){
			//console.log(data);
			var result = $.parseJSON(data);
			var step = 1;
			$('input[name="company"]').val(result[0].companyname);
			$('input[name="country"]').val(result[0].countryname);
			console.log(result[0].step);
			switch(result[0].step){
				case '1': step = 1; break;
				case '10': step = 10; break;
				case '100': step = 100; break;
				case '1000': step = 1000; break;
				case '10000': step = 10000; break;
				case '01': step = 0.1; break;
				case '001': step = 0.01; break;
				case '0001': step = 0.001; break;
				case '00001': step = 0.0001; break;
				case '000001': step = 0.00001; break;
				case '0000001': step = 0.000001; break;
			}
			$('input[name="openrate"]').attr("step",step);
			$('input[name="closerate"]').attr("step",step);
			$('input[name="dayminimum"]').attr("step",step);
			$('input[name="daymaximum"]').attr("step",step);
		});
	});	
	
	// bind datepicker
	$('input[name="ratedate"]').datepicker({dateFormat: 'yy-mm-dd'});
	
	// autofill open rate
	$('input[name="ratedate"]').change(function(){
		var qid = $('select[name="quote"]').val();
		//console.log(qid);
		var ratedateDOM = $('input[name="ratedate"]');
		var current = new Date(ratedateDOM.val());
		var prev = current.add(-1).day();
		console.log(prev);
		var dateStr = prev.toString('yyyyMMdd');
		var newdiv = $('<span  id="prevdate"></span>');
		newdiv.text(prev.toString('d-MMM-yyyy') );
		$('input[name="openrate"]').parent().append(newdiv);
		var obj = {qid: qid,
		 		   ratedate: dateStr};
		$.post('ajax_get_rate.php',obj,function(data){
			var result = $.parseJSON(data);
			$('input[name="openrate"]').val(result);
		});	
	});

});

function padStr(i) {
    return (i < 10) ? "0" + i : "" + i;
}