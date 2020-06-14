<?php
	
	define ('RH_API_CALL_AIRLINES', 'airlines');
	
	class RouteHappy {
		
		private $apiKey;
		
		private $apiUrl = 'https://eu-west-1.hub-api.routehappy.com';
		
		private $headers = array (
			'Accept-Language' => 'en',
			'Content-Type' => 'application/vnd.routehappy+json',
			'Accept' => 'application/vnd.routehappy+json'
		);
		
		private $response = array ();
		
		private $availableApis = array (
			'airlines' => '/airlines'
		);
		
		public function __construct ($apiKey) {
			
			$this->apiKey = $apiKey;
			
		}
		
		
		
		private function call () {
			
			if (!isset ($this->apiCall))
				throw new Exception ("Missing call url");
				
			if (!isset ($this->apiKey))
				throw new Exception ("Missing API Key");
			
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiUrl . $this->availableApis[RH_API_CALL_AIRLINES],
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "Accept: application/vnd.routehappy+json",
			    "Accept-Language: en",
			    "Auth: ".$this->apiKey,
			    "Cache-Control: no-cache",
			    "Connection: keep-alive",
			    "Content-Type: application/vnd.routehappy+json",
			    "Host: eu-west-1.hub-api.routehappy.com",
			    "Postman-Token: 6bea178a-d1ac-40a8-a02c-9415b8fa382e,cba1c1c1-8389-466d-94c5-f706d08066c9",
			    "User-Agent: PostmanRuntime/7.15.0",
			    "accept-encoding: gzip, deflate",
			    "cache-control: no-cache"
			  ),
			));
			
			$response = curl_exec ($curl);
			curl_close($curl);

			
			return $this->parse ($response, $this->apiCall);
			
		}
		
		private function parse ($response) {
			
			
			$response = json_decode ($response, true);
			
			foreach ($response['airlines'] as $airline) {
				
				$data = array (
					'ancillaries' => array (),
					'fares' => array ()
				);

				foreach ($airline['upa_categories'] as $ancillary) { 
					
					$data['ancillaries'][$ancillary['id']] = $ancillary['name'];
					
				}
				
				foreach ($airline['fare_types'] as $fare_types) { 
					
					$data['fares'][$fare_types['id']] = $fare_types['name'];
					
				}
				
				$this->response['airlines'][$airline['id']] = $data;
				
				
			}
			
		}
		
		public function getAmenitiesPerAirline ($airline) {
			
			if (!isset ($this->response['airlines'])) {
				
				$this->apiCall = RH_API_CALL_AIRLINES;
				$this->call ();
				
			}
			
			if (isset ($this->response['airlines'][$airline])) {
				
				return $this->response['airlines'][$airline];
				
			}
			
			return false;
			
		}
		
		public function getAllAmenities () {
			
			if (!isset ($this->response['airlines'])) {
				
				$this->apiCall = RH_API_CALL_AIRLINES;
				$this->call ();
				
			}
			
			$data = array ();
			
			foreach ($this->response['airlines'] as $airlineKey => $airline) {
				
				foreach ($airline['ancillaries'] as $key => $ancillary) {
				
					if (!isset ($data[$key])) {
						
						$data[$key] = array ('name' => $ancillary, 'usedBy' => array ());
						
					}
					
					$data[$key]['usedBy'][] = $airlineKey;
					
				}
				
			}
			
			return $data;
			
		}
		
	}