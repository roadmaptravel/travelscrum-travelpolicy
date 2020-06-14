<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Roadmap Travel Manager Tool</title>
    <meta name="description" content="A dashling dashboard for Travel Managers to easily manage their travel policy and to go the extra mile for their travelers.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.3.1" href="assets/styles/shards-dashboards.1.3.1.min.css">
    <link rel="stylesheet" href="assets/styles/extras.1.3.1.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </head>
  <body class="h-100">
    <div class="container-fluid h-100" style="
    background: url('assets/images/bg1.jpg');
    background-size: cover; position: relative;">
      <div class="row h-100">
        <!-- End Main Sidebar -->
        <main class="main-content col">
          <div class="main-content-container container-fluid px-4 my-auto h-100">
            <div class="row no-gutters h-100">
              <div class="col-lg-3 col-md-5 auth-form mx-auto my-auto">
                <div class="card">
                  <div class="card-body">
                    <img class="auth-form__logo d-table mx-auto mb-3" src="assets/images/roadmap.svg" alt="Roadmap Travel Manager Tool">
                    <h5 class="auth-form__title text-center mb-4">Access Your Account</h5>
                    
					<?php
                        if (isset ($loginError) && $loginError === true):
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert" style="margin-bottom: 15px !important;">
			            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			              <span aria-hidden="true">×</span>
			            </button>
			            <i class="fa fa-times mx-2"></i>
						<strong>Error!</strong>
						We were unable to log you in, please try again!
					</div>
                    <?php
                        endif;
                    ?>
                    
                    <form method="post">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="username" value="<?= isset ($_POST['username']) ? $_POST['username'] : 'travelmanager@getroadmap.com' ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" value="NikeTravelManager">
                      </div>
                      <div class="form-group mb-3 d-table mx-auto">
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="customCheck2">
                          <label class="custom-control-label" for="customCheck2">Remember me for 30 days.</label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-pill btn-accent d-table mx-auto">Access Account</button>
                      <input type="hidden" name="action" value="login" />
                    </form>
                    
                <div class="auth-form__meta d-flex mt-4">
                  <a href="forgot-password.html">Forgot your password?</a>
                  <a class="ml-auto" href="register.html">Create new account?</a>
                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
      
      <img class="auth-form__logo d-table mx-auto mb-3" src="assets/images/logo.png" alt="Roadmap Travel Manager Tool" style="position: absolute; right: 50px; bottom: 100px; width: 250px;" />
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.js"></script>
    <script src="assets/scripts/extras.1.3.1.min.js"></script>
    <script src="assets/scripts/shards-dashboards.1.3.1.js"></script>
  </body>
</html>