<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login </title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background: url('experience.jpg') no-repeat center center fixed;
    background-size: cover;
}
.btn-primary {
    background-color: #28a745 !important;  /* Vert bootstrap */
    border-color: #28a745 !important;
    color: white;
}


	main#main {
    display: flex;
    justify-content: center;
    align-items: center;
   height: 100vh;
}

.card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}
#login-center {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}



select.custom-select:focus {
    border-color: #28a745; /* Green border */
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); /* Green shadow */
    outline: none;
}

select.custom-select option:checked {
    background-color: #28a745; /* Green background when selected */
    color: white;
}
.my-select {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    color: #495057;
}

.my-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    outline: none;
}

.my-select option:checked {
    background-color: #28a745;
    color: white;
}
select.custom-select:focus {
    border-color: #28a745 !important;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5) !important;
    outline: none !important;
    background-color: #e6f4ea !important; /* vert clair au focus */
}

select.custom-select option:checked {
    background-color: #28a745 !important;
    color: white !important;
}


</style>

<body>


  <main id="main" >
  	
  		<div class="align-self-center w-100">
		<h4 class="text-white text-center"><b>Système de Gestion des Sinistres Mamda | MCMA</b></h4>
  		<div id="login-center">
  			<div class="card col-md-4">
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label text-dark">	Identifiant</label>
  							<input type="text" id="username" name="username" class="form-control form-control-sm">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label text-dark">Mot de Pass</label>
  							<input type="password" id="password" name="password" class="form-control form-control-sm">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label text-dark">Type</label>
  							<select class="form-control-sm my-select" name="type">

  								<option value="3">Client</option>
  								<option value="2">Agent</option>
  								<option value="1">Admin</option>
  								
  							</select>
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">	Se connecter</button></center>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Nom d utilisateur ou mot de passe incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
	$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    })
</script>
</html>