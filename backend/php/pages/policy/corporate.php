<?php
	 
if (isset ($_GET['edit'])) {

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['action']) && $_POST['action'] == 'edit' && isset ($_GET['edit'])) {
	    
	    $outputJson = array ();
	    
	    $outputJson['policyName'] = $_POST['policyName'];
	    
	    $cabinClasses = array ();
	    foreach ($config['cabinClasses'] as $key => $class) {
		    
		    $cabinClasses[$key] = array (
			    'cabinClass' => $_POST['air']['cabinClasses'][$key]['cabinClass'],
			    'minFlightDuration' => ($_POST['air']['cabinClasses'][$key]['minFlightDuration'] * 60)
		    );
		    
	    }
	    
	    
	    $transportOptions = array ();
	    foreach ($config['transportOptions'] as $option) {
		    
		    $transportOptions[$option['id']] = isset ($_POST['transportOptions'][$option['id']]) ? true : false;
		    
	    }
	    
	    $airFares = array ();
	    foreach ($_POST['air']['airFares'] as $key => $fare) {
		    $max = (int) $fare['max'];
		    
		    $airFares[$key] = array (
			    'min' => (int) $fare['min'],
			    'max' => $max == 0 ? null : $max,
			    'approval' => (bool) $fare['approval'],
			    'approvalBy' => $fare['approvalBy']
		    );
		    
	    }
	    
	    $outputJson['air']['airFares'] 		= $airFares;
	    $outputJson['air']['cabinClasses'] 	= $cabinClasses;
	    $outputJson['transportOptions'] 			= $transportOptions;
	    
	    $outputJson = array ('result' => $outputJson);
	    
	    file_put_contents (baseDir . '/data/travelpolicy.json', json_encode ($outputJson));
	    
	    var_dump ('yolo');
	    exit;
	    header ('HTTP/1.1 301 Moved Permanently');
	    header ('Location: travelpolicy.html?action=corporate&edit=1&success');
	    exit;
	    
	}

        
        $Page = new Page ($_GET['edit']);
        
        if (!$Page) {
            
            header ('HTTP/1.1 301 Moved Permanently');
            header ('Location: '. baseHref . $_GET['route'] . '.html');
            exit;
            
        }
        
        if (isset ($_GET['success'])) {
	        ?>
          <div class="container-fluid px-0">
            <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
              <strong>Ole!</strong> The travel policy has been successfully updated! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
	        <?php
        }
?>
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Travel Policy</span>
                <h3 class="page-title">Corporate Policy</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <form class="add-new-post" method="post">
	            <input type="hidden" name="action" value="edit" />
            <div class="row">
              <div class="col-lg-9 col-md-12">
                <!-- Add New Post Form -->
                <div class="card card-small mb-3">
                  <div class="card-body">
                      <input class="form-control form-control-lg mb-3" type="text" name="policyName" value="<?= $travelPolicyData['policyName'] ?>">
                      
                      <hr /> 
                      
                      <h5>COVID-19 Measures</h5>
                      <!-- PUT THE FORM HERE -->
                      
                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">Reasons for travel</div>
	                    	
					   		<div class="input-group col-md-4">
								<fieldset>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Exhibitions &amp; fairs</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxChecked" checked>
										<label class="custom-control-label" for="formsCheckboxChecked">Customer meetings</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Internal meetings</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Conferences</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Corporate events</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Recruitment</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Consultancy</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Sales</label>
									</div>
									<div class="custom-control custom-checkbox mb-1">
										<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
										<label class="custom-control-label" for="formsCheckboxDefault">Maintenance/engineering</label>
									</div>
								</fieldset>
	                        </div>
                      </div>
                      
                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">Providing of health kit</div>
	                    	
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="office">Yes, pick up at office</option>
									<option value="airpport">Yes, pick up at airport</option>
									<option value="delivered" selected>Yes, delivered to home address</option>
									<option value="no">No</option>
									<option value="other">Other:</option>
                                </select>
	                        </div>
                      </div>
                     
                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">Essential Employee Authorization Letter</div>
	                    	
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="office">Provide automatically</option>
									<option value="airpport">E-mail to HR for letter</option>
									<option value="other">Other: </option>
                                </select>
	                        </div>
	                        
	                        <div class="col-md-5">
		                        <textarea class="form-control" rows="10">To whom it may concern:

This letter is provided as evidence that the carrier of this letter, [[employee_name]], is a Nike employee and, as such, an employee of an essential business. The employee is providing essential work to support Nike's delivery of critical supplies directly to the doorsteps of people who need them. As such, this employee is exempt from mobility restrictions when reporting to or returning from work, or while performing their job duties.

Please direct all questions to Nike HR at hr@nike.com or +1 (123) 456 789.

Sincerely,

[[automaticsignature]]</textarea>
	                        </div>
                      </div>
                      
                      
                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">Additional insurance provided</div>
	                    	
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="yes">Yes, Nike provides extra insurance</option>
									<option value="yes">Yes, covered within current insurance</option>
									<option value="no">No, traveler has to get insurance themselves</option>
									<option value="other">Other:</option>
                                </select>
	                        </div>
                      </div>
                     
                      
                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">Traveler needs to check box to travel:</div>
	                    	
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="yes">Yes</option>
									<option value="no">No</option>
                                </select>
	                        </div>
					   		<div class="input-group col-md-5">
                                <input type="text" class="form-control" value="Yes I understand I am traveling to a risky destination and I have the necessary resources to keep me safe" />
	                        </div>
                      </div>
                      
                      <hr />
                      
                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">No approval required:<br />
		                    	<small>Do not require approval if all those criteria are met:</small>
	                    	</div>
	                    	
	                    	<div class="col-md-8">
		                    	<div class="row form-group">
			                    	<div class="col-md-2">Max infection risk score:</div>
									<div class="input-group col-md-4">
										<input type="number" class="form-control" value="11" />
										<div class="input-group-append">
				                            <span class="input-group-text">/100</span>
				                          </div>
									</div>
									<div class="col-md-6"><small>The risk score is from 0-100 with 100 being the highest "risk". The main factor that goes into this score is how flat the curve has been.</small></div>
		                    	</div>
		                    	
		                    	<div class="row form-group">
			                    	<div class="col-md-2">Entry restrictions:</div>
									<div class="input-group col-md-4">
										<select id="inputState" class="form-control">
											<option value="yes">No restrictions</option>
											<option value="no" selected>Business essential travel</option>
											<option value="no">Closed borders</option>
		                                </select>
									</div>
		                    	</div>
		                    	
		                    	
		                    	<div class="row form-group">
			                    	<div class="col-md-2">Quarantine level:</div>
									<div class="input-group col-md-4">
										<select id="inputState" class="form-control">
											<option value="yes">No quarantine needed</option>
											<option value="no">Quarantine recommended</option>
											<option value="no">Quarantine required</option>
		                                </select>
									</div>
		                    	</div>
	                        </div>
                      </div>
                     

                      <div class="row" style="margin-bottom: 15px;">
	                    	<div class="col-md-3">Reject booking requests:<br />
		                    	<small>Automatically reject a booking request when one of the criteria is met.</small>
	                    	</div>
	                    	
	                    	<div class="col-md-8">
		                    	<div class="row form-group">
			                    	<div class="col-md-2">Infection risk score higher than:</div>
									<div class="input-group col-md-4">
										<input type="number" class="form-control" value="11" />
										<div class="input-group-append">
				                            <span class="input-group-text">/100</span>
				                          </div>
									</div>
									<div class="col-md-6"><small>The risk score is from 0-100 with 100 being the highest "risk". The main factor that goes into this score is how flat the curve has been.</small></div>
		                    	</div>
		                    	
		                    	<div class="row form-group">
			                    	<div class="col-md-2">Entry restrictions:</div>
									<div class="input-group col-md-4">
										<select id="inputState" class="form-control">
											<option value="yes">Borders are closed</option>
											<option value="no" selected>Borders closed for non-essential travel</option>
		                                </select>
									</div>
		                    	</div>
		                    	
		                    	<div class="row form-group">
			                    	<div class="col-md-2">Quarantine level:</div>
									<div class="input-group col-md-4">
										<select id="inputState" class="form-control">
											<option value="no">Quarantine recommended</option>
											<option value="no">Quarantine required</option>
		                                </select>
									</div>
		                    	</div>
		                    	
		                    	<div class="row form-group">
			                    	<div class="col-md-2">When traveler:</div>
									<div class="input-group col-md-4">

										<div class="custom-control custom-checkbox mb-1">
											<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
											<label class="custom-control-label" for="formsCheckboxDefault">Has COVID-19 symptoms</label>
										</div>
										<div class="custom-control custom-checkbox mb-1">
											<input type="checkbox" class="custom-control-input" id="formsCheckboxDefault">
											<label class="custom-control-label" for="formsCheckboxDefault">Is not fit for travel</label>
										</div>
									</div>
		                    	</div>
	                        </div>
                      </div>
                     
                      
                      <hr />
                                                                 
                      <h5>Transport options</h5>
                      
                      <?php
	                      foreach ($config['transportOptions'] as $key => $option):
	                  ?>
                      <div class="row" style="margin-bottom: 15px;">
	                      <div class="col-md-4"><?= $option['name'] ?></div>
						  <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                          	<input type="checkbox" id="customToggle<?= $key ?>" name="transportOptions[<?= $option['id'] ?>]" class="custom-control-input" <?= $travelPolicyData['transportOptions'][$option['id']] ? ' checked="checked"' : ''?>>
                          	<label class="custom-control-label" for="customToggle<?= $key ?>"></label>
                          </div>
                      </div>
                      <?php
	                      endforeach;
	                  ?>
                  </div>
                </div>
                
                <div class="file-manager file-manager-cards">
					<div class="row">
						<div class="col">
							<span class="file-manager__group-title text-uppercase text-light">Documents</span>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-6 col-lg-3">
							<div class="file-manager__item card card-small mb-3">
								<div class="file-manager__item-preview card-body px-0 pb-0 pt-4">
									<img src="assets/images/file-manager/document-preview-1.jpg" alt="File Manager - Item Preview">
								</div>
					
								<div class="card-footer border-top">
									<span class="file-manager__item-icon">
										<i class="material-icons">&#xE24D;</i>
									</span>
					
									<h6 class="file-manager__item-title">Travel Policy</h6>
									<span class="file-manager__item-size ml-auto">12kb</span>
								</div>
							</div>
						</div>
					</div>
                </div>

                <!-- / Add New Post Form -->
              </div>
              <div class="col-lg-3 col-md-12">
                <!-- Post Overview -->
                <div class='card card-small mb-3'>
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Actions</h6>
                  </div>
                  <div class='card-body p-0'>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item p-3">
                        <span class="d-flex mb-2"><i class="material-icons mr-1">flag</i><strong class="mr-1">Status:</strong> Published <a class="ml-auto" href="javascript:alert('This is not working yet');">Edit</a></span>
                        <span class="d-flex mb-2"><i class="material-icons mr-1">visibility</i><strong class="mr-1">Visibility:</strong> <strong class="text-success">Public</strong> <a class="ml-auto" href="javascript:alert('This is not working yet');">Edit</a></span>
                        <span class="d-flex mb-2"><i class="material-icons mr-1">calendar_today</i><strong class="mr-1">Schedule:</strong> Now <a class="ml-auto" href="javascript:alert('This is not working yet');">Edit</a></span>
                        <span class="d-flex"><i class="material-icons mr-1">score</i><strong class="mr-1">Readability:</strong> <strong class="text-warning">Ok</strong></span>
                      </li>
                      <li class="list-group-item d-flex px-3">
                        <button class="btn btn-sm btn-outline-accent"><i class="material-icons">save</i> Save Draft</button>
                        <button class="btn btn-sm btn-accent ml-auto" type="submit"><i class="material-icons">file_copy</i> Publish</button>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- / Post Overview -->
                <!-- Post Overview -->
                <div class='card card-small mb-3'>
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Job levels</h6>
                  </div>
                  <div class='card-body p-0'>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item px-3 pb-2">
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category1" checked>
                          <label class="custom-control-label" for="category1">Associate</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category2" checked>
                          <label class="custom-control-label" for="category2">Intermediate</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category3">
                          <label class="custom-control-label" for="category3">Senior</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category4">
                          <label class="custom-control-label" for="category4">Manager</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Senior Manager</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Line Manager</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Director</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Senior Director</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Executive</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Senior Executive</label>
                        </div>
                        
                        
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">Vice President</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="category5">
                          <label class="custom-control-label" for="category5">President</label>
                        </div>
                      </li>
                      <li class="list-group-item d-flex px-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="New category" aria-label="Add new job level" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-white px-2" type="button"><i class="material-icons">add</i></button>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- / Post Overview -->
              </div>
            </div>
            </form>
<?php
        echo App::tinyMCE ('contentField');
        
} else {
?>
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col">
                <span class="text-uppercase page-subtitle">Travel Policy</span>
                <h3 class="page-title">Policy Overview</h3>
              </div>
              <div class="col d-flex">
                <div class="btn-group btn-group-sm d-inline-flex ml-auto my-auto" role="group" aria-label="Table row actions">
                  <a href="file-manager-list.html" class="btn btn-white active">
                    <i class="material-icons">&#xE8EF;</i>
                  </a>
                  <a href="file-manager-cards.html" class="btn btn-white">
                    <i class="material-icons">&#xE8F0;</i>
                  </a>
                </div>
              </div>
            </div>
            <!-- End Page Header -->
            
            <!-- File Manager -->
            <table class="file-manager file-manager-list d-none table-responsive">
              <thead>
                <tr>
                  <th colspan="5" class="text-left bg-white">
                    <form action="/file-upload" class="dropzone"></form>
                  </th>
                </tr>
                <tr>
                  <th style="width: 10px;" class="hide-sort-icons"></th>
                  <th class="text-left">Name</th>
                  <th class="text-left">Members</th>
                  <th class="text-left">Used by</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="file-manager__item-icon">
                    <div>
                      <i class="material-icons">&#xE2C7;</i>
                    </div>
                  </td>
                  <td class="text-left">
                    <a href="travelpolicy.html?action=corporate&edit=1" class="file-manager__item-title">COVID-19 Default policy</a>
                    <span class="file-manager__item-meta">Last changed 2 hours ago.</span>
                  </td>
                  <td class="text-left">19,823</td>
                  <td class="text-left">Employees, supervisors</td>
                  <td class="file-manager__item-actions">
                    <div class="btn-group btn-group-sm d-flex justify-content-end" role="group" aria-label="Table row actions">
                      <a href="travelpolicy.html?action=corporate&edit=1" class="btn btn-white active-light">
                        <i class="material-icons">&#xE254;</i>
                      </a>
                      <a href="" class="btn btn-danger">
                        <i class="material-icons">&#xE872;</i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="file-manager__item-icon">
                    <div>
                      <i class="material-icons">&#xE2C7;</i>
                    </div>
                  </td>
                  <td class="text-left">
                    <a href="javascript:alert('This is not working yet');" class="file-manager__item-title">COVID-19 Line Managers policy</a>
                    <span class="file-manager__item-meta">Last changed 4 hours ago.</span>
                  </td>
                  <td class="text-left">894</td>
                  <td class="text-left">Line Managers</td>
                  <td class="file-manager__item-actions">
                    <div class="btn-group btn-group-sm d-flex justify-content-end" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white active-light">
                        <i class="material-icons">&#xE254;</i>
                      </button>
                      <button type="button" class="btn btn-danger">
                        <i class="material-icons">&#xE872;</i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="file-manager__item-icon">
                    <div>
                      <i class="material-icons">&#xE2C7;</i>
                    </div>
                  </td>
                  <td class="text-left">
                    <a href="javascript:alert('This is not working yet');" class="file-manager__item-title">COVID-19 Vice Presidents policy</a>
                    <span class="file-manager__item-meta">Last changed 2 days ago.</span>
                  </td>
                  <td class="text-left">309</td>
                  <td class="text-left">Vice Presidents, Presidents</td>
                  <td class="file-manager__item-actions">
                    <div class="btn-group btn-group-sm d-flex justify-content-end" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white active-light">
                        <i class="material-icons">&#xE254;</i>
                      </button>
                      <button type="button" class="btn btn-danger">
                        <i class="material-icons">&#xE872;</i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End File Manager -->
<?php	
}
?>