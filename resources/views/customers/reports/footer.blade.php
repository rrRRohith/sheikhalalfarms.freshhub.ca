<link rel="stylesheet" href="{{asset('js/datepicker/dist/daterangepicker.min.css')}}">
<script type="text/javascript" src="{{asset('js/datepicker/moment.min.js')}}"></script>
<!--<script type="text/javascript" src="jquery.min.js"></script>-->
<script type="text/javascript" src="{{asset('js/datepicker/dist/jquery.daterangepicker.min.js')}}"></script>
<script>
$('#customd').dateRangePicker();
$('#day1').dateRangePicker({
	autoClose: true,
	singleDate : true,
	showShortcuts: false
});
$('#week1').dateRangePicker({
	batchMode: 'week',
	showShortcuts: false
});
    $(document).ready(function(){
        $('.duration').on('click',function(){
            if($(this).val()==1)
                {
                     $('#day').css('display','none');
                     $('#week').css('display','none');
                     $('#custom').css('display','none');
                     $('#all').css('display','block');
                     $('#day1').val('');
                     $('#week1').val('');
                     $('#customd').val('');
                     $("#week1").prop('required',false);
                     $('#day1').prop('required',false);
                     $('#customd').prop('required',false);
                     $('#reporttype option[value="1"]').show();
                     $('#reporttype option[value="2"]').show();
                     $('#reporttype option[value="3"]').show();
                     $('#reporttype option[value="4"]').show();
                }
            else if($(this).val()==2)
                {
                     $('#day').css('display','none');
                     $('#week').css('display','block');
                     $('#custom').css('display','none');
                     $('#all').css('display','none');
                     $('#day1').val('');
                     $('#customd').val('');
                     $("#week1").prop('required',true);
                     $('#day1').prop('required',false);
                     $('#customd').prop('required',false);
                     $('#reporttype option[value="1"]').show();
                     $('#reporttype option[value="2"]').hide();
                     $('#reporttype option[value="3"]').hide();
                     $('#reporttype option[value="4"]').show();
                     
                }
            else if($(this).val()==3)
                {
                     $('#day').css('display','block');
                     $('#week').css('display','none');
                     $('#custom').css('display','none');
                     $('#all').css('display','none');
                     $('#week1').val('');
                     $('#customd').val('');
                     $("#week1").prop('required',false);
                     $('#day1').prop('required',true);
                     $('#customd').prop('required',false);
                     $('#reporttype option[value="1"]').hide();
                     $('#reporttype option[value="2"]').hide();
                     $('#reporttype option[value="3"]').hide();
                     $('#reporttype option[value="4"]').show();
                }
            else
                {
                     $('#day').css('display','none');
                     $('#week').css('display','none');
                     $('#all').css('display','none');
                     $('#custom').css('display','block');
                     $('#day1').val('');
                     $('#week1').val('');
                     $("#week1").prop('required',false);
                     $('#day1').prop('required',false);
                     $('#customd').prop('required',true);
                     $('#reporttype option[value="1"]').show();
                     $('#reporttype option[value="2"]').show();
                     $('#reporttype option[value="3"]').show();
                     $('#reporttype option[value="4"]').show();
                }
        })
    });
</script>