<!doctype html>
<html lang="fr">
    <?php
    session_start();
    if(!empty($_SESSION['Role'])){
        switch ($_SESSION['Role']){
            case 'Admin':

                header('location:Admin/dashboard.php');
                break;
            case 'Chauffeur':
                header('location:Chauffeur/dashboard.php'); //mettre lien vesr chauffeur
                break;
            case 'Client':
                header('location:client/selectionCourse.php'); //mettre lien vesr client
                break;
            default:
                echo 'deconnection';
                header('location:deconnection.php'); //mettre lien vesr chauffeur
                break;

        }
    }

    include_once 'classes/personne.php'; //ajoute personne

    if(!empty($_POST)){ //verifie que a recu message

        $pers = new Personne(); //crée objet personne
        if(!empty($_POST['login-submit'])){ // pour quand
            if(!empty($_POST['Email']) && !empty($_POST['Mdp'])) {
                if ($pers->connection($_POST['Email'], $_POST['Mdp']) == array('succes' => '1')){
                    header('location: index.php'); //renvoie vers header si tout a bien été
                    echo 'ok';
                }
                else{
                    header('location: index.php?error=1');
                }
            }
            else{
                header('location: index.php?error=1');
            }
        }
        if(!empty($_POST['register-submit'])){
            if(!empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['Email']) && !empty($_POST['Mdp']) && !empty($_POST['MdpConfirm']) && !empty($_POST['Telephone'])) { //vérifier que on a bien mis toutes les infos)
                $pers->Nom = strtolower($_POST['Nom']);
                $pers->Prenom = strtolower($_POST['Prenom']);
                $pers->Email = strtolower($_POST['Email']);
                $pers->NumTel = $_POST['Telephone'];
                $pers->Mdp = $_POST['Mdp'];
                $retour = $pers->creation($_POST['MdpConfirm']);
                if(!empty($retour['error'])){
                    switch ($retour['error']){
                        case 'existe deja':
                            header("location: index.php?erreur=3");
                            break;
                        case 'mdp different':
                            header("location: index.php?erreur=2");
                            break;
                    }
                }
                else{
                    header('location: index.php');
                }
            }
            else{
                header("location: index.php?erreur=1");
            }
        }
    }


    ?>
  <head>
    <meta charset="utf-8">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    

    <!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
	.cent{
		pading-top:10%;
		pading-bottom: 50%;
	}
    body {
    padding-top: 0px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}

.bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
<script>
$(function() {

$('#login-form-link').click(function(e) {
    $("#login-form").delay(100).fadeIn(100);
     $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
});
$('#register-form-link').click(function(e) {
    $("#register-form").delay(100).fadeIn(100);
     $("#login-form").fadeOut(100);
    $('#login-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
});

});

</script>
    
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
  <header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="Index.php" class="navbar-brand d-flex align-items-center">
      <img src="img/bag.png" width="20" height="20"/>
         
        <strong style="font-size: 20px;"> Taxeasy</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>  


<main class="form-signin">
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" <?php if(!isset($_GET['erreur'])){
									echo "class='active'";
								} ?> id="login-form-link">Se connecter</a>
							</div>
							<div class="col-xs-6">
								<a href="#" 
								<?php if(isset($_GET['erreur'])){
									echo "class='active'";
								} ?>
								id="register-form-link">S'enregistrer</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" method="post" action="" role="form"
								<?php if(!isset($_GET['erreur'])){
									echo "style='display: block;'";
								}
								else{
									echo "style='display: none;'";
								} ?> 
								>
									<div class="form-group">
										<input type="Email" name="Email" id="username" tabindex="1" class="form-control" placeholder="Email" value="">
									</div>
									<div class="form-group">
										<input type="password" name="Mdp" id="password" tabindex="2" class="form-control" placeholder="Mot de passe">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Se connecter">

											</div>
											<?php
												if(isset($_GET['error'])){
													echo "<br><br><h4 class='alert alert-danger' role='alert'>Mots de passe et/ou Email invalide</h4>";
												}
											?>
										</div>
									</div>
								</form>
								<form id="register-form" action="" method="post" role="form"
								<?php if(isset($_GET['erreur'])){
									echo "style='display: block;'";
								}else{
									echo "style='display: none;'";
								} ?> 
								>
									<div class="form-group">
										<input type="text" name="Nom" id="username" tabindex="1" class="form-control" placeholder="Nom" value="">
									</div>
                                    <div class="form-group">
										<input type="text" name="Prenom" id="username" tabindex="1" class="form-control" placeholder="Prenom" value="">
									</div>
                                    <div class="form-group">
										<input type="text" name="Telephone" id="tel" tabindex="1" class="form-control" placeholder="N° telephone" value="">
									</div>
									<div class="form-group">
										<input type="email" name="Email" id="email" tabindex="1" class="form-control" placeholder="Adresse Email" value="">
									</div>
									<div class="form-group">
										<input type="password" name="Mdp" id="password" tabindex="2" class="form-control" placeholder="Mot de passe">
									</div>
									<div class="form-group">
										<input type="password" name="MdpConfirm" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirmez votre mots de passe">
									</div>
									<div class="">
										<h4>En vous inscrivant, vous acceptez <a href="Eula.php">les conditions d'utilisation </a> ainsi que les cookies</h4> <br>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="S'enregistrer">
												
											</div>
										</div>
									</div>
                                    
                                            <?php
													if(isset($_GET['erreur'])){
														$err=$_GET['erreur'];

														if($err == 1){
															echo  '<div class="row align-item-center">
                                                            <div class="col"> 
                                                            <h4 class="alert alert-danger" role="alert">Des informations ne sont pas correcte ou ne sont pas completé
                                                            </h4> </div> </div>';
														}
														if($err == 2){
															echo "<div class='row align-item-center'>
                                                            <div class='col'>  <h4 class='alert alert-danger' role='alert'>Les mots de passe ne sont pas identique</h4></div> </div>";
														}
														if($err == 3){
															echo "<div class='row align-item-center'>
                                                            <div class='col'>  <h4 class='alert alert-danger' role='alert'>Cet email est déjà utilisé</h4></div> </div>";
														}
													}
												?>
                                    
								</form>
                                
                                

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<!--
 à faire : restauration de mots de passe

    -->
<?php
//include 'footer.php';
?>
    
  </body>

</html>
