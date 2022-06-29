@extends('admin_dashboard')
@section('admin_content')
<style>

.button {
  background-color: #c2fbd7;
  border-radius: 100px;
  box-shadow: rgba(44, 187, 99, .2) 0 -25px 18px -14px inset,rgba(44, 187, 99, .15) 0 1px 2px,rgba(44, 187, 99, .15) 0 2px 4px,rgba(44, 187, 99, .15) 0 4px 8px,rgba(44, 187, 99, .15) 0 8px 16px,rgba(44, 187, 99, .15) 0 16px 32px;
  color: green;
  cursor: pointer;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 7px 20px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 16px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button:hover {
  box-shadow: rgba(44,187,99,.35) 0 -25px 18px -14px inset,rgba(44,187,99,.25) 0 1px 2px,rgba(44,187,99,.25) 0 2px 4px,rgba(44,187,99,.25) 0 4px 8px,rgba(44,187,99,.25) 0 8px 16px,rgba(44,187,99,.25) 0 16px 32px;
  transform: scale(1.05) rotate(-1deg);
}
</style>

<h4 style="color: #5a5c69;">BÁO CÁO CÔNG NỢ</h4>
<div>
    <p style="display: inline;
    font-size: 20px;
    color: black;
    padding-left: 30%;">Chọn thời gian báo cáo</p>
    <input type="month" id="input_date"/>
    <button class="button" role="button" id="view">Xem</button>
    <a id="print-debt" target='_blank'>
      <button class="button" role="button" id="print">In</button>
    </a>
   

</div>
<div class="card shadow mb-4 load_report" style="margin-top: 40px;">
    
</div>

<script>
    $('#view').click(function(){
        var date = new Date($('#input_date').val());
        var month = date.getMonth() + 1;
        var year = date.getFullYear();  
        var _token = $('input[name="_token"]').val();
        var current_date = new Date();
        var current_month = current_date.getMonth() + 1;
        var current_day = current_date.getDate();
        if(!isNaN(month)){ 
          if(month < current_month || (month == current_month &&current_day >=30)) {      
            $.ajax({
              url:"{{url('/show-report-debt-by-month-year')}}",
              method: "POST",
              headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data:{month:month,year:year},
              success: function(data){
                  $('.load_report').html(data);
              }
            });
          } else {
            alert('Tháng chưa kết thúc nên không thể lập báo cáo');
          }
        } else {
          alert('Vui lòng nhập ngày báo cáo.');
        }
    });

    $('#print').click(function(){
        var date = new Date($('#input_date').val());
        var month = date.getMonth() + 1;
        var year = date.getFullYear(); 
        var current_date = new Date();
        var current_month = current_date.getMonth() + 1;
        var current_day = current_date.getDate();
        if(!isNaN(month)){   
          if(month < current_month || (month == current_month &&current_day >=30)) { 
            var a = document.getElementById('print-debt');
            a.href = "{{url('/print-report-debt/')}}" + '/' + month + '/' + year;  
          } else {
            alert('Tháng chưa kết thúc nên không thể lập báo cáo');
          } 
        } else {
          alert('Vui lòng nhập ngày báo cáo.');
        }
    });
</script>
    
@endsection