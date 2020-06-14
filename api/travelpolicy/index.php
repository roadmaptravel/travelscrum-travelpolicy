<?php
	
	$data = file_get_contents ('./../../data/travelpolicy.json');
	$response = json_decode ($data, true);
	
	
/*
	
	
	$response = array (
		'result' => array (
			'policyName' => 'Default Policy',
			'air' => array (
				'airFares' => array (
					0 => array (
						"min" => 0,
						"max" => 300,
						"approval" => false,
						"approvalBy" => null
					),
					1 => array (
						"min" => 300,
						"max" => null,
						"approval" => true,
						"approvalBy" => "Line Manager"
					)
				),
				"cabinClasses" => array (
					0 => array (
						"cabinClass" => "economy",
						"minFlightDuration" => 0,
					),
					1 => array (
						"cabinClass" => "premium_economy",
						"minFlightDuration" => 360,
					),
					2 => array (
						"cabinClass" => "business",
						"minFlightDuration" => 360,
					),
					3 => array (
						"cabinClass" => "first",
						"minFlightDuration" => 720,
					)
				)
			),
			'tripOptions' => array (
				'allowBleisure' => true,
				'allowUpgrades' => false
			)
		)
	);
*/
	
	if (isset ($_GET['debug'])) {
		
		echo '<pre>';
		var_dump ($response);
		exit;
		
	}
	
	header('Content-Type: application/json');
	echo json_encode ($response);
