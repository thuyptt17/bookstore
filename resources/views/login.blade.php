<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login to your account</title>
	<link rel="stylesheet" href="{{asset('resources/css/loginstyle.css')}}">
</head>
<body>
	
	<div class="login-wrapper">
		<?php
            $message = Session::get('ErrorMessage');
            if ($message)
            {
                 ?>
                    <p class="errMessage">Tên đăng nhập hoặc mật khẩu không đúng, kiểm tra lại</p>
                <?php
                 Session::put('ErrorMessage','');
            }
        ?>
		<div class="login-img">
			<img src="{{URL::to('resources/img/login.png')}}" alt="">
		</div>
		<div class="login-form">
			<h2>Sign up</h2>

			<form action="{{URL::to('/check-login')}}" method="POST">
			{{ csrf_field() }}
				<div class="form-group">
					<label for="">Email</label>
					<input type="email" placeholder="Nhập email" name="email">
				</div>

				<div class="form-group">
					<label for="">Mật khẩu</label>
					<input type="password" name="password" id="" placeholder="*********">
				</div>

				<div class="form-group button-holder">
					<div>
						<button type="submit">Đăng nhập</button>
					</div>
					<a href="#">Bạn chưa có tài khoản? Đăng kí</a>
				</div>
			</form>
		</div>
	</div>

</body>
</html>