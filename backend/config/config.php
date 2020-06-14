 <?php
 
require_once baseDir . 'backend/config/database.php';
require_once baseDir . 'backend/php/include/settings.php';
 
 define ('THEME_DIR', 'default');
 define ('CMS_NAME',	'Roadmap Policy Tool');
 define ('SITE_NAME',	'Roadmap Policy Tool');
 define ('SITE_URL', 	'https://tool.getroadmap.com/');
 define ('websiteHref', 	'https://tool.getroadmap.com/');
 define ('baseHref', 	'https://tool.getroadmap.com/');
 define ('pathToWebsite', '');
 
$config = array ();


$config['jobLevels'] = array (
	'Associate',
	'Intermediate',
	'Senior',
	'Manager',
	'Senior Manager',
	'Line Manager',
	'Director',
	'Senior Director',
	'Executive',
	'Senior Executive',
	'Vice President',
	'President'
);

$config['cabinClasses'] = array (
	0 => array (
		'id' => 'economy',
		'name' => 'Economy Class'
	),
	1 => array (
		'id' => 'premium_economy',
		'name' => 'Premium Economy'
	),
	2 => array (
		'id' => 'business',
		'name' => 'Business Class'
	),
	3 => array (
		'id' => 'first',
		'name' => 'First Class'
	)
);

$config['transportOptions'] = array (
	0 => array (
		'id' => 'allowPrivateCar',
		'name' => 'Allow private car services'
	),
	1 => array (
		'id' => 'allowTaxi',
		'name' => 'Allow the use of taxis'
	),
	2 => array (
		'id' => 'allowCarRental',
		'name' => 'Allow rental cars as method of transport'
	),
	3 => array (
		'id' => 'allowPublicTransport',
		'name' => 'Allow public transport'
	),
	4 => array (
		'id' => 'allowRideSharing',
		'name' => 'Allow ride sharing, like Uber & Lyft'
	)
);

$config['loyaltyPrograms']  = array (
	0 => array (
		'id' => 'flyingBlue',
		'name' => 'Flying Blue'
	),
	1 => array (
		'id' => 'iberiaPlus',
		'name' => 'Iberia Plus'
	)
);

$config['preferenceOptions'] = array (
	'extraLegSpace',
	'fastTrack'
);

$config['mealOptions'] = array (
	'Lacto-ovo-vegetarian',
	'Vegan vegetarian',
	'Asian/Hindu vegetarian',
	'Muslim',
	'Kosher',
	'Child meal',
	'Diabetic',
	'Gluten intolerant',
	'Low fat',
	'Low salt',
	'Low lactose'
);

$config['airlines'] = array (
	0 => array (
		'id' => 'kl',
		'name' => 'KLM'
	),
	1 => array (
		'id' => 'ib',
		'name' => 'Iberia'
	),
	2 => array (
		'id' => 'ba',
		'name' => 'British Airways'
	),
	3 => array (
		'id' => 'aa',
		'name' => 'American Airlines'
	),
	4 => array (
		'id' => 'af',
		'name' => 'Air France'
	),
	5 => array (
		'id' => 'dl',
		'name' => 'Delta Airlines'
	),
	6 => array (
		'id' => 'lh',
		'name' => 'Lufthansa'
	),
	7 => array (
		'id' => 'vy',
		'name' => 'Vueling'
	),
	8 => array (
		'id' => 'i2',
		'name' => 'Iberia Express'
	),
);