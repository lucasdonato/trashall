<!DOCTYPE html>
<html lang="pt">
<head>

	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<meta name="description" content="Custom Login Form Styling with CSS3" />
	<meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
	<meta name="author" content="Codrops" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="../bootstrap-css-js/css/style.css" />
	<script src="../bootstrap-css-js/js/modernizr.custom.63321.js"></script>
	<script src="script.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
	
	<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
	<style>
		body {
			background: #e1c192;
			background-image: url(../background.jpg);
			background-repeat: no-repeat;
			background-size: 100%;
		}
	</style>

	<script type="text/javascript">
			$(document).ready(function(){
				$('#formLogin').submit(function(){					
					var data = $("#formLogin").serialize();
					$.ajax({
						type : 'POST',
						url  : 'login.php',
						data : data,
						dataType: 'json',
						success: function( response )
						{
							if(response == '1'){
								let timerInterval
								Swal.fire({
								type: 'success',
								title: 'Login com sucesso',
								html: 'Carregando....<strong></strong> segundos.',
								timer: 2000,
								onBeforeOpen: () => {
									Swal.showLoading()
									timerInterval = setInterval(() => {
									Swal.getContent().querySelector('strong')
										.textContent = Swal.getTimerLeft()
									}, 100)
								},
								onClose: () => {
									clearInterval(timerInterval)
								}
								}).then((result) => {
								if (
									/* Read more about handling dismissals below */
									result.dismiss === Swal.DismissReason.timer
								) {
									window.location.href = "admin/dashboard.php"
								}
								})
							}else{
								Swal.fire({
										type: 'error',
										title: 'Oops...',
										text: 'Usuário ou senha inválidos!',
										
								})
							}
						}
					});
					return false;
				});
			});
	</script>
</head>
<body>
	<div class="container">
		<header>
			<h1>Faça sua <strong>autenticação</strong></h1>
		</header>
		<section class="main">
			<form id="formLogin" action="" method="post" class="form-2">
				<h1><span class="sign-in">Log in</span></h1>
				<p class="float">
					<label for="login"><i class="icon-user"></i>Email</label>
					<input type="text" required id="txtLogin" name="txtLogin" placeholder="Email">
				</p>
				<p class="float">
					<label for="password"><i class="icon-lock"></i>Senha</label>
					<input type="password" id="txtSenha" required name="txtSenha" placeholder="Senha" class="showpassword">
				</p>
				<p class="clearfix">
					<a href="#" class="log-twitter">Solicitar Parceria</a>
					<input type="submit" name="buttonLogar" id="buttonLogin" name="submit" value="Log in">
				</p>
		
				</p>
			</form>​​
		</section>
	</div>
	<!-- jQuery if needed -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(function () {
			$(".showpassword").each(function (index, input) {
				var $input = $(input);
				$("<p class='opt'/>").append(
					$("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function () {
						var change = $(this).is(":checked") ? "text" : "password";
						var rep = $("<input placeholder='Password' type='" + change + "' />")
							.attr("id", $input.attr("id"))
							.attr("name", $input.attr("name"))
							.attr('class', $input.attr('class'))
							.val($input.val())
							.insertBefore($input);
						$input.remove();
						$input = rep;
					})
				).append($("<label for='showPassword'/>").text("Ver senha")).insertAfter($input.parent());
			});

			$('#showPassword').click(function () {
				if ($("#showPassword").is(":checked")) {
					$('.icon-lock').addClass('icon-unlock');
					$('.icon-unlock').removeClass('icon-lock');
				} else {
					$('.icon-unlock').addClass('icon-lock');
					$('.icon-lock').removeClass('icon-unlock');
				}
			});
		});

		
	</script>
</body>
<footer>
	<!-- Copyright -->
	<div class="footer-copyright text-center py-3">© 2019 Copyright:
		<a href="#"> Equipe Trashall</a>
	  </div>
	  <!-- Copyright -->
</footer>
</html>