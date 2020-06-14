<?php
	
	$response = array (
		'result' => array (
			'air' => array (
				'loyaltyCards' => array (
					0 => array (
						'name' => 'Flying Blue',
						'number' => '2398029883'
					),
					1 => array (
						'name' => 'Iberia Plus',
						'number' => '1234567890'
					)
				),
				'meal' => 'vegetarian',
				'extraLegSpace' => true,
				'fastTrack' => true,
				'luggage' => array (
					'enabled' => true,
					'afterDays' => 4,
					'bags' => 1
				),
				'preferedAirlines' => array (
					0 => array (
						'id' => 'kl',
						'name' => 'KLM',
						'prefered' => true
					),
					1 => array (
						'id' => 'ib',
						'name' => 'Iberia',
						'prefered' => false
					)
				)
			), 
			'bleisure' => array (
				'enabled' => true,
				'extraDays' => 2
			)
		)
	);
	
	$data = file_get_contents ('./../../data/preferences.json');
	$response = json_decode ($data, true);
	
	
	if (isset ($_GET['debug'])) {
		
		echo '<pre>';
		var_dump ($response);
		exit;
		
	}
	
	header('Content-Type: application/json');

	echo json_encode ($response);