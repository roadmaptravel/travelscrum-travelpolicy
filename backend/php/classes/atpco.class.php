<?php
	
	class ClassATPCO {
		
		private $url = 'https://us-east-1.hub-api.routehappy.com/legs_searches?include=legs.leg_fares.fare,legs.leg_fares.leg_fare_segments.upas.photo_attachments.photo,legs.leg_fares.leg_fare_segments.upas.video_attachments.video,legs.leg_fares.leg_fare_segments.upas.tour_attachments.tour';
		private $apiKey = false;
		
		public function __construct ($apiKey) {
			
			$this->apiKey = $apiKey;
						
		}
		
		private function callAtpco ($request) {
	
			$headers = array (
				'Auth: '.$this->apiKey,
				'Content-Type: application/vnd.routehappy+json',
				'Accept: application/vnd.routehappy+json',
				'Accept-language: en'
			);
			
			$curl = curl_init ($this->url);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_POST, true);
	
			
			$response = json_decode (curl_exec($curl), true);
			
			return $response;

		}
		
		private function makeRequest ($dep, $arr, $carrier, $flight, $date) {
			
			$request = '{
			"data": {
				"type":"legs_search",
				"attributes": {
					"fare_source": "1S",
					"categories": ["brand", "promotion"],
					"legs":[{
				
						"segments": [{
							"dep": "'. $dep .'",
							"arr": "'. $arr .'",
							"carrier": "'. $carrier .'",
							"flt_no": "'. $flight .'",
							"dep_date": "'. $date .'",
							"cabin_id": 1
						}]
					}]
				}
			}
			}';
			
			return $request;
			
		}
		
		public function getUPAs ($dep, $arr, $carrier, $flight, $date) {
			
			$request = $this->makeRequest ($dep, $arr, $carrier, $flight, $date);

			$response = $this->callAtpco ($request);
			
			$return = array ();
			
			return array_merge ($this->processPhotos ($response), $this->processUPAs ($response));
		}
		
		private function processPhotos ($json) {
			
			$return = array ();
			$allPhotos = array ();
			$attachments = array ();
			
			foreach ($json['included'] as $item) {
	
				if ($item['type'] == 'photo') {
					
					$attachments[$item['id']] = $item['attributes']['url'];
	
				} else if ($item['type'] == 'photo_attachment') {
					
					$allPhotos[] = array (
						'image_link' => $item['relationships']['photo']['data']['id'],
						'title' => '',
						'desc' => $item['attributes']['caption'],
						'link' => '',
					);
					
				}
			}

			foreach ($allPhotos as $photos) {
				
				$thisPhoto = $photos;
				$thisPhoto['image'] = $attachments[$thisPhoto['image_link']];
				
				$return[] = $thisPhoto;
				
			}
			
			return $return;
		}
		
		private function processUPAs ($json) {
			
			$return = array ();
			
			foreach ($json['included'] as $item) {

				if ($item['type'] != 'upa')
					continue;
	
					
				$return[] = array (
					'image' => $item['attributes']['large_icon_url'],
					'title' => $item['attributes']['headline'],
					'desc' => $item['attributes']['description'],
					'link' => $item['attributes']['cta_url'],
				);
			}
			
			return $return;
		}

		

	}