<?php	
	
	$covidControls = new CovidControls ('getroadmap');
	$covidControls->debug = true;
	$covidControls->debugFile = baseDir . '/assets/covidcontrols.json';
	
	$allCountries = $covidControls->getAll ();	
	
?>
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col">
                <span class="text-uppercase page-subtitle">Travel Policy</span>
                <h3 class="page-title">Countries</h3>
              </div>
            </div>
            <!-- End Page Header -->
            
              <div class="col-lg-12 mb-4">
                <div class="card card-small lo-stats">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">All counties</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body p-0">
				  <table class="table mb-0" id="countryTable">
                      <thead class="py-2 bg-light text-semibold border-bottom">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Country</th>
                          <th scope="col" class="border-0">COVID Trend</th>
                          <th scope="col" class="border-0">COVID Sick</th>
                          <th scope="col" class="border-0">COVID Deaths</th>
                          <th scope="col" class="border-0">Lockdown</th>
                          <th scope="col" class="border-0">Restaurants</th>
                          <th scope="col" class="border-0">Advice</th>
                          <th scope="col" class="border-0 text-right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
	                      <?php
		                      $i = 0;
		                      foreach ($allCountries as $flag => $country):
		                      
		                      		if (isset ($country['lockdownInfo']['lockdown']) && $country['lockdownInfo']['lockdown'] == 'Partial') {
			                      		
			                      		$travelAdvice = '<span class="badge badge-pill badge-warning">Discouraged</span>';
			                      		
		                      		} else if (isset ($country['lockdownInfo']['lockdown']) && $country['lockdownInfo']['lockdown'] == 'No') {
			                      		
			                      		$travelAdvice = '<span class="badge badge-pill badge-success">Open</span>';
			                      		
			                      	} else if (isset ($country['lockdownInfo']['lockdown']) && $country['lockdownInfo']['lockdown'] == 'Yes') {
				                      	
				                      	$travelAdvice = '<span class="badge badge-pill badge-danger">Not allowed</span>';
				                      	
				                    } else {
					                    
					                    $travelAdvice = '<span class="badge badge-pill badge-secondary">Unknown</span>';
					                    
				                    }
		                      
		                      	$i++;
		                      	
		                      	$icon = 'assets/images/flags/'. strtolower (str_replace (' ', '-', $country['name'])) .'.svg';
		                      	
		                      	if (!file_exists (baseDir . '/' . $icon))
		                      		continue;
		                  ?>
                        <tr>
                          <td><img class="country-flag mr-1" src="assets/images/flags/<?= strtolower (str_replace (' ', '-', $country['name'])) ?>.svg" alt="<?= $country['name'] ?>" style="max-width: 40px;"></td></td>
                          <td><?= $country['name'] ?></td>
                          <td><?= $country['condition'] ?></td>
                          <td><?= number_format ($country['sick']) ?></td>
                          <td><?= number_format ($country['dead']) ?></td>
                          <td><?= isset ($country['lockdownInfo']['lockdown']) ? '<a href="#" title="'. $country['lockdownInfo']['details'] .'" data-toggle="tooltip">'.$country['lockdownInfo']['lockdown'].'</a>' : 'Unknown'; ?> </td>
                          <td><?= isset ($country['lockdownInfo']['restaurantsAndBars']) ? $country['lockdownInfo']['restaurantsAndBars'] : 'Unknown' ?></td>
                          <td><?= $travelAdvice ?></td>
                          <td>
	                          <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
		                          <button type="button" class="btn btn-sm btn-success">Allow</button>
		                          <button type="button" class="btn btn-sm btn-warning">Discourage</button>
		                          <button type="button" class="btn btn-sm btn-danger">Disallow</button>
                              </div>
                            </td>
                        </tr>
                        <?php
	                        endforeach;
	                    ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              
            </div>