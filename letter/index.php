<?php
	$data = file_get_contents ('./../data/travelpolicy.json');
	$response = json_decode ($data, true);
	
	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

	<title>Roadmap Trave/Scrum Hackathon</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="//cdn.rawgit.com/eternicode/bootstrap-datepicker/1.3.0/css/datepicker3.css" />
	<link rel='stylesheet' href='https://www.getroadmap.com/static/assets/fonts/helvetica.css' type='text/css' media='all' />
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<link rel="stylesheet" href="/css/style.css" />
	
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link href="/images/launchscreen.png" sizes="2048x2732" rel="apple-touch-startup-image" />
	<link href="/images/launchscreen.png" sizes="1668x2224" rel="apple-touch-startup-image" />
	<link href="/images/launchscreen.png" sizes="1536x2048" rel="apple-touch-startup-image" />
	<link href="/images/launchscreen.png" sizes="1125x2436" rel="apple-touch-startup-image" />
	<link href="/images/launchscreen.png" sizes="1242x2208" rel="apple-touch-startup-image" />
	<link href="/images/launchscreen.png" sizes="750x1334" rel="apple-touch-startup-image" />
	<link href="/images/launchscreen.png" sizes="640x1136" rel="apple-touch-startup-image" />

</head>

<body>
	
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-12">
				<?php
					$policy = nl2br ($response['result']['policyText']);
				
					$policy = str_replace ('[[automaticsignature]]', '<img src="https://qph.fs.quoracdn.net/main-qimg-0e284cfe1cc3f3b23d8038bf5e5b9c76" style="display: block; margin: 25px 0; max-width: 100px;" />', $policy);
					$policy = str_replace ('[[employee_name]]', 'Aurelie Krau', $policy);
				
					echo $policy;	
				?>
			</div>
		</div>
		
	</div>
	
</body>
</html>