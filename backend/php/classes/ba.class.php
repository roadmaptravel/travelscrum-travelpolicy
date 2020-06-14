<?php
	
	class NDC_BA {
		
		private $url = 'https://test.api.ba.com/selling-distribution/%s/17.2/V1';
		
		public function __construct ($apiKey, $iataNumber) {
			
			$this->apiKey = $apiKey;
			$this->iataNumber = $iataNumber;
			
		}
		
		public function retrievePnr ($pnr) {

			$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Header/>
   <soapenv:Body>
      <OrderRetrieveRQ Version="17.2" PrimaryLangID="EN" AltLangID="EN" xmlns="http://www.iata.org/IATA/EDIST/2017.2">
         <Document>
            <Name>BA</Name>
         </Document>
         <Party>
            <Sender>
               <TravelAgencySender>
                  <IATA_Number>'. $this->iataNumber .'</IATA_Number>
                  <AgencyID>Roadmap</AgencyID>
               </TravelAgencySender>
            </Sender>
         </Party>
         <Query>
            <Filters>
               <OrderID Owner="BA">'. $pnr .'</OrderID>
            </Filters>
         </Query>
      </OrderRetrieveRQ>
   </soapenv:Body>
</soapenv:Envelope>';

			return $this->_call ($xml, 'OrderRetrieve');
			
		}
		
		private function _call ($xml, $operation) {
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => sprintf ($this->url, $operation),
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $xml,
			  CURLOPT_HTTPHEADER => array(
			    "Accept: */*",
			    "Accept-Language: en",
			    "Cache-Control: no-cache",
			    "Client-Key: ". $this->apiKey,
			    "Connection: keep-alive",
			    "Content-Type: application/xml",
			    "Host: test.api.ba.com",
			    "SOAPACTION: ". $operation ."17_2_V1"
			  ),
			));
			
			$response = curl_exec($curl);

			$plainXML = $this->mungXML($response);
			$arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
			

			return $arrayResult['soap_Body']['OrderViewRS']['Response'];
			
		}
		
		private function mungXML($xml)
		{
		    $obj = SimpleXML_Load_String($xml);
		    if ($obj === FALSE) return $xml;
		
		    // GET NAMESPACES, IF ANY
		    $nss = $obj->getNamespaces(TRUE);
		    if (empty($nss)) return $xml;
		
		    // CHANGE ns: INTO ns_
		    $nsm = array_keys($nss);
		    foreach ($nsm as $key)
		    {
		        // A REGULAR EXPRESSION TO MUNG THE XML
		        $rgx
		        = '#'               // REGEX DELIMITER
		        . '('               // GROUP PATTERN 1
		        . '\<'              // LOCATE A LEFT WICKET
		        . '/?'              // MAYBE FOLLOWED BY A SLASH
		        . preg_quote($key)  // THE NAMESPACE
		        . ')'               // END GROUP PATTERN
		        . '('               // GROUP PATTERN 2
		        . ':{1}'            // A COLON (EXACTLY ONE)
		        . ')'               // END GROUP PATTERN
		        . '#'               // REGEX DELIMITER
		        ;
		        // INSERT THE UNDERSCORE INTO THE TAG NAME
		        $rep
		        = '$1'          // BACKREFERENCE TO GROUP 1
		        . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
		        ;
		        // PERFORM THE REPLACEMENT
		        $xml =  preg_replace($rgx, $rep, $xml);
		    }
		    return $xml;
		}
		
	}