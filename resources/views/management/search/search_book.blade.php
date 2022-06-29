@extends('admin_dashboard')
@section('admin_content')
<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  input[type="file"],
  .modal-body select,
  textarea {
    background: rgba(255,255,255,0.1);
    border: 1px solid #ced4da;
    font-size: 16px;
    border-radius: 5px;
    width: 100%;
    height: 35px;
    box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    margin-bottom: 5px;
  } 




    .search {
    width: 100%;
    position: relative;
    display: flex;
    }

    .searchTerm {
    width: 100%;
    border: 3px solid #00B4CC;
    border-right: none;
    padding: 5px;
    height: 20px;
    border-radius: 5px 0 0 5px;
    outline: none;
    color: #9DBFAF;
    }

    .searchTerm:focus{
    color: black;
    }

    .searchButton {
    width: 40px;
    height: 36px;
    border: 1px solid #00B4CC;
    background: #00B4CC;
    text-align: center;
    color: #fff;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    font-size: 20px;
    }

    /*Resize the wrap to see the search bar change!*/
    .wrap{
    width: 30%;
    position: absolute;
    top: 20%;
    left: 55%;
    transform: translate(-50%, -50%);
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
<script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

<div class="container-fluid" style="padding-top: 3%;">
    <br />
    <?php
      $message = Session::get('message');
      if ($message)
      {
        ?>
            <div class="alert alert-success" id="divmessage" role="alert">
             <?php echo $message; ?>
             <button type="button" class="close" data-dismiss="alert" id="icon_hide_message" onclick="hidemessage()">×</button> 
            </div>
        <?php
        Session::put('message','');
      }
    ?>
    <!-- Page Heading -->
 
    <div class="wrap">
        <div class="search">
            <input type="text" class="searchTerm" placeholder="Nhập sách cần tìm kiếm" name="search_item" >
            <button type="button" class="searchButton" id="searchItem">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
    <div class="card shadow mb-4 load_book" style="margin-top: 40px;">
    
    </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->

<script>
    $('#searchItem').click(function(){
        var tukhoa = $('.searchTerm').val();
        if(tukhoa == ""){
            alert('Vui lòng nhập thông tin cần tìm kiếm');
        } else {
            $.ajax({
              url:"{{url('/search-book')}}" +'/' + tukhoa,
              method: "GET",
              success: function(data){
                  $('.load_book').html(data);
              }
            });
        }
    });
</script>

    
@endsection
