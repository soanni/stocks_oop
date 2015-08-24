$(document).ready(function(){
    $('#addorder').validate(
        {
            rules: {
                ordate: {required: true},
                ortype: {required: true},
                exchange: {required: true},
                company: {required: true},
                quote: {required: true},
                amount: {required: true, min:1},
                amountlot: {required: true, min:1},
                currency: {required: true},
                price: {required: true,min: 0.00001},
                stoploss: {required: false},
                stopprice: {required: false},
                takeprofit: {required: false},
                takeprice: {required: false},
                sumtotal: {required: true,min: 0.00001},
                brokerrevenue: {required: true,min: 0.00001}
            },
            success: function(label){
                label.text('OK').addClass('valid');
            }
        }
    );
    $('select[name="quote"]').change(function(){
        var obj = {quoteid: $(this).val()};
        $.post('../rates/ajax.php',obj,function(data){
            //console.log(data);
            var result = $.parseJSON(data);
            var step = 1;
            $('input[name="company"]').val(result[0].companyname);
            //$('input[name="exchange"]').val(result[0].companyname);
            //$('input[name="country"]').val(result[0].countryname);
            //console.log(result[0].step);
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
            $('input[name="price"]').attr("step",step);
            $('input[name="stopprice"]').attr("step",step);
            $('input[name="takeprice"]').attr("step",step);
        });
    });

    $('select[name="company"]').change(function(){
        console.log($(this).val());
        var obj = {ajax_companyid: $(this).val(),
            ajax_exchid: $('select[name="exchange"]').val()};
        console.log(obj);
        $.post('ajax_quotes.php',obj,function(data){
            console.log(data);
            if(data == 'Error 402'){
                $('select[name="quote"]').empty();
                $('select[name="quote"]').parent().append('<label class="error">No such quote</label>');
            }else{
                var result = $.parseJSON(data);
                var quote = $('select[name="quote"]');
                quote.empty();
                quote.append('<option value="">Select one</option>');
                for (var i = 0; i < result.length; i++){
                    quote.append('<option value="' + result[i].qid + '">' + result[i].quoteName + '</option>');
                }
            }
        });
    });

    $('input[name="amount"]').change(function(){
        var price = $('input[name="price"]').val();
        if(price > 0){
            var sum = $(this).val() * price;
            $('input[name="sumtotal"]').val(sum);
            $('input[name="brokerrevenue"]').val(sum * 0.057 / 100);
        }
    });

    $('input[name="price"]').change(function(){
        var amount = $('input[name="amount"]').val();
        if(amount > 0){
            var sum = $(this).val() * amount;
            $('input[name="sumtotal"]').val(sum);
            $('input[name="brokerrevenue"]').val(sum * 0.057 / 100);
        }
    });

    // bind datepicker
    $('input[name="ordate"]').datepicker({dateFormat: 'yy-mm-dd'});

});
