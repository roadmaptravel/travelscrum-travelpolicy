<?php
	class CovidControls {
		
		private $url = 'https://prod.greatescape.co/api/travel/countries/corona/';
		private $apiKey = false;
		public $debug = false;
		public $debugFile = '/assets/covidcontrols.json';
		
		public function __construct ($apiKey) {
			
			$this->apiKey = $apiKey;
						
		}
		
		private function call () {
			
			if ($this->debug && $this->debugFile && file_exists ($this->debugFile)) {
				
				$response = json_decode (file_get_contents($this->debugFile), true);
				
			} else {
				
				exit;
		
				$headers = array (
					'Authorization: Bearer '.$this->apiKey,
					'Accept: application/json',
					'Accept-language: en'
				);
				
				$curl = curl_init ($this->url);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, false);
		
				
				$response = json_decode (curl_exec($curl), true);

			}
			
			ksort($response);
			
			return $response;

		}
		
		public function getAll () {
			
			$data = $this->call ();
			
			return $data;
			
		}
		
	}