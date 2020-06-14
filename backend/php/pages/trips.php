<?php
$json = file_get_contents (baseDir . '/data/travelpolicy.json');

$travelPolicyData = json_decode ($json, true)['result'];

if (!isset ($_GET['search'])) {
    
    $_GET['search'] = '';
    
}

if (!isset ($_GET['action'])) {
    
    $_GET['action'] = '';
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['action']) && $_POST['action'] == 'add') {
    
    $page = new Page;
    
    $page->setPostData ($_POST);
    
    if ($p = $page->save ()) {
        
        header ('HTTP/1.1 301 Moved Permanently');
        header ('Location: ' . baseHref . $_GET['route'] .'.html?action=edit&id='. $p->id .'&state=success');
        exit;
        
    } else {
        
        $_SESSION['error'] = $page->errMsg;
        $_SESSION['formData'] = $_POST;
        
        header ('HTTP/1.1 301 Moved Permanently');
        header ('Location: '. baseHref . $_GET['route'] .'.html?action='. $_GET['action'] .'&state=error');
        exit;
        
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['action']) && $_POST['action'] == 'edit' && isset ($_GET['id'])) {
    
    $outputJson = array ();
    
    $outputJson['policyName'] = $_POST['policyName'];
    
    $cabinClasses = array ();
    foreach ($config['cabinClasses'] as $key => $class) {
	    
	    $cabinClasses[$key] = array (
		    'cabinClass' => $_POST['air']['cabinClasses'][$key]['cabinClass'],
		    'minFlightDuration' => ($_POST['air']['cabinClasses'][$key]['minFlightDuration'] * 60)
	    );
	    
    }
    
    $tripOptions = array ();
    foreach ($config['tripOptions'] as $option) {
	    
	    $tripOptions[$option['id']] = isset ($_POST['tripOptions'][$option['id']]) ? true : false;
	    
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
    $outputJson['tripOptions'] 			= $tripOptions;
    
    $outputJson = array ('result' => $outputJson);
    
    file_put_contents (baseDir . '/data/travelpolicy.json', json_encode ($outputJson));
    
    header ('HTTP/1.1 301 Moved Permanently');
    header ('Location: travelpolicy.html?action=edit&id=1');
    exit;
    
}

if (isset ($_GET['change']) && $_GET['change'] == 'toggle' && isset ($_GET['id'])) 
{
        $page = new Page ($_GET['id']);
        $page->setActive ();
    
        
        header ('HTTP/1.1 301 Moved Permanently');
        header ('Location: ' . baseHref . $_GET['route'] . '.html?action='. $_GET['action'] .'&search='. $_GET['search']);
        exit;
}

if (isset ($_GET['change']) && $_GET['change'] == 'delete' && isset ($_GET['id'])) 
{
        $page = new Page ($_GET['id']);
        $page->delete ();
    
        
        header ('HTTP/1.1 301 Moved Permanently');
        header ('Location: ' . baseHref . $_GET['route'] . '.html?action='. $_GET['action'] .'&search='. $_GET['search']);
        exit;
}

$filter = isset ($_GET['filter']) ? $_GET['filter'] : 'overview';

if ($filter == 'active') 
    $filterText = 'Actief';
else if ($_GET['action'] == 'edit')
    $filterText = 'Bewerken';
else
    $filterText = 'Overzicht';
 
$search = '';   
if (isset ($_GET['search'])) 
{
    
    $search = '&amp;search=' . stripslashes ($_GET['search']);
    
}  
    if ($_GET['action'] == 'edit') {
        
        $Page = new Page ($_GET['id']);
        
        if (!$Page) {
            
            header ('HTTP/1.1 301 Moved Permanently');
            header ('Location: '. baseHref . $_GET['route'] . '.html');
            exit;
            
        }
?>
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Travel Policy</span>
                <h3 class="page-title">Edit Policy</h3>
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
                      
                      <h5>Approval Levels for Air Fares</h5>
                      <!-- PUT THE FORM HERE -->
                     
                     <div class="row" style="margin-bottom: 15px;">
	                     <div class="col-md-3">Min air expense</div>
	                     <div class="col-md-3">Max air expense</div>
	                     <div class="col-md-2">Need approval?</div>
	                     <div class="col-md-4">Approval by</div>
                     </div>
                     
                     <?php
	                     foreach ($travelPolicyData['air']['airFares'] as $key => $data):
	                 ?>
                     <div class="row" style="margin-bottom: 15px;">
	                        <div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="<?= $data['min'] ?>" name="air[airFares][<?= $key ?>][min]">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
	                        
	                        <div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="<?= $data['max'] ?>" name="air[airFares][<?= $key ?>][max]">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
	                        
	                        <div class="input-group col-md-2">
                                <select id="inputState" class="form-control" name="air[airFares][<?= $key ?>][approval]">
									<option value="1" <?= $data['approval'] ? ' selected="selected"' : '' ?>>Yes</option>
									<option value="0" <?= !$data['approval'] ? ' selected="selected"' : '' ?>>No</option>
                                </select>
	                        </div>
	                        
	                        <div class="input-group col-md-4 <?= !$data['approval'] ? 'd-none' : '' ?>">
                                <select id="inputState" class="form-control" name="air[airFares][<?= $key ?>][approvalBy]">
	                                <?php
		                                foreach ($config['jobLevels'] as $level):
		                                
		                                	$selected = ($level == $data['approvalBy']) ? ' selected="selected"' : '';
		                            ?>
									<option value="<?= $level ?>" <?= $selected ?>><?= $level ?></option>
									<?php
										endforeach;
									?>
                                </select>
	                        </div>
                     </div> 
                     <?php
	                     endforeach;
	                 ?>
                      
                      
                      <h5>Travel Time and Travel Class</h5>
                      
					  <div class="row" style="margin-bottom: 15px;">
	                     <div class="col-md-3">Class</div>
	                     <div class="col-md-3">Available after hours of flight</div>
                     </div>
                     
                     <?php
	                     foreach ($config['cabinClasses'] as $key => $class):
	                    ?>
                     <div class="row" style="margin-bottom: 15px;">
	                        <div class="col-md-3"><?= $class['name'] ?></div>
	                        <div class="col-md-3 input-group">
		                        <input type="hidden" name="air[cabinClasses][<?= $key ?>][cabinClass]" value="<?= $class['id'] ?>" />
								<input type="text" class="form-control" placeholder="" name="air[cabinClasses][<?= $key ?>][minFlightDuration]" aria-label="Available after x hours" aria-describedby="basic-addon2" value="<?= $travelPolicyData['air']['cabinClasses'][$key]['minFlightDuration'] / 60 ?>">
		                          <div class="input-group-append">
		                            <span class="input-group-text">hours</span>
		                          </div>
	                        </div>
                     </div>
                     <?php
	                     endforeach;
	                    ?>
                                           
                      <h5>Air options</h5>
                      
                      <?php
	                      foreach ($config['tripOptions'] as $key => $option):
	                  ?>
                      <div class="row" style="margin-bottom: 15px;">
	                      <div class="col-md-4"><?= $option['name'] ?></div>
						  <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                          	<input type="checkbox" id="customToggle<?= $key ?>" name="tripOptions[<?= $option['id'] ?>]" class="custom-control-input" <?= $travelPolicyData['tripOptions'][$option['id']] ? ' checked="checked"' : ''?>>
                          	<label class="custom-control-label" for="customToggle<?= $key ?>"></label>
                          </div>
                      </div>
                      <?php
	                      endforeach;
	                  ?>
                                            
                      <h5>Meal allowance</h5>
                      
                      <h6>Breakfast</h6>
                      
                       <div class="row" style="margin-bottom: 15px;">
	                    
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="">Americas</option>
									<option value="">Non-Americas</option>
                                </select>
	                        </div>
	                    
							<div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="15">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
                      </div>
                       <div class="row" style="margin-bottom: 15px;">
	                    
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="">Non-americas</option>
									<option value="">Americas</option>
                                </select>
	                        </div>
	                    
							<div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="15">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
                      </div>
                      
                                            
                      <h5>Hotel allowance</h5>
                      
                      <div class="row" style="margin-bottom: 15px;">
	                     <div class="col-md-4">Region</div>
	                     <div class="col-md-3">Max per night</div>
                     </div>
                     
                       <div class="row" style="margin-bottom: 15px;">
	                    
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="">Asia</option>
									<option value="">Non-Americas</option>
                                </select>
	                        </div>
	                    
							<div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="250">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
                      </div>
                       <div class="row" style="margin-bottom: 15px;">
	                    
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="">Australia</option>
									<option value="">Americas</option>
                                </select>
	                        </div>
	                    
							<div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="250">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
                      </div>
                       <div class="row" style="margin-bottom: 15px;">
	                    
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="">Europe</option>
									<option value="">Non-Americas</option>
                                </select>
	                        </div>
	                    
							<div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="200">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
                      </div>
                       <div class="row" style="margin-bottom: 15px;">
	                    
					   		<div class="input-group col-md-4">
                                <select id="inputState" class="form-control">
									<option value="">US & Canada</option>
									<option value="">Americas</option>
                                </select>
	                        </div>
	                    
							<div class="input-group col-md-3">
	                          <div class="input-group-prepend">
	                            <span class="input-group-text">$</span>
	                          </div>
	                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="125">
	                          <div class="input-group-append">
	                            <span class="input-group-text">.00</span>
	                          </div>
	                        </div>
                      </div>
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
                        <span class="d-flex mb-2"><i class="material-icons mr-1">flag</i><strong class="mr-1">Status:</strong> Published <a class="ml-auto" href="#">Edit</a></span>
                        <span class="d-flex mb-2"><i class="material-icons mr-1">visibility</i><strong class="mr-1">Visibility:</strong> <strong class="text-success">Public</strong> <a class="ml-auto" href="#">Edit</a></span>
                        <span class="d-flex mb-2"><i class="material-icons mr-1">calendar_today</i><strong class="mr-1">Schedule:</strong> Now <a class="ml-auto" href="#">Edit</a></span>
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
                
    } else if ($_GET['action'] == 'add') {
        
        $Page = new Page ();
        
?>
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
        
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    
                    <h4 class="panel-title"><?= $Module['title'] ?> (<?= $filterText ?>)</h4>
                    
                </div>
                
                <div class="panel-body">
                    
                    
                    <?php
                        
                        App::showError ($_GET, isset ($_SESSION['error']) ? $_SESSION['error'] : false);
                        
                        unset ($_SESSION['error']);
                        
                        App::showSuccess ($_GET);
                    ?>
                    
                    
                    <form class="form-horizontal form-bordered" method="post" data-parsley-validate>
                    
                        <input type="hidden" name="action" value="add" />
                    
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="title">Titel * :</label>
							<div class="col-md-10 col-sm-10">
								<input class="form-control" type="text" id="title" name="title" required placeholder="Page title" value="<?= $Page->title ?>" />
							</div>
						</div>
				
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="subTitle">Sub Title * :</label>
							<div class="col-md-10 col-sm-10">
								<input class="form-control" type="text" id="subTitle" name="subTitle" placeholder="Sub Title" value="<?= $Page->subTitle ?>" />
								
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="title">Pagina type:</label>
							<div class="col-md-10 col-sm-10">
								<select name="pageType" id="pageType" class="form-control">
    								<option>Select a page type</option>
    								<?php
        								$types = Page::types ();
        								
        								foreach ($types as $type) {
            						
            						        echo '<option value="'. $type .'">'. ucfirst ($type) .'</option>';
            								
        								}
                                    ?>
								</select>
							</div>
						</div>
								
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="menuTitle">Menu title * :</label>
							<div class="col-md-10 col-sm-10">
								<input class="form-control" type="text" id="menuTitle" name="menuTitle" required placeholder="Menu Title" value="<?= $Page->menuTitle ?>" />
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="showInMenu">Show in menu :</label>
							<div class="col-md-10 col-sm-10">
			
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="showInMenu" id="showInMenu" value="1" <?= $Page->showInMenu ? ' checked="checked"' : '' ?> />
                                        check to show in menu
                                    </label>
                                </div>
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="isInternalPage">Internal page :</label>
							<div class="col-md-10 col-sm-10">
			
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="isInternalPage" id="isInternalPage" value="1" <?= $Page->isInternalPage ? ' checked="checked"' : '' ?> />
                                        Check als het geen losse pagina is
                                    </label>
                                </div>
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2" for="menuOrder">Menu order * :</label>
							<div class="col-md-2 col-sm-2">
								<input class="form-control" type="text" id="menuOrder" name="menuOrder" required data-parsley-type="number" placeholder="10" value="<?= $Page->menuOrder ?>" />    								
							</div>
						</div>
						
						<div id="pageType_external" <?= $Page->pageType == 'external' ? '' : 'style="display: none;"' ?>>
    						<div class="form-group">
    							<label class="control-label col-md-2 col-sm-2" for="extWebUrl">Web URL * :</label>
    							<div class="col-md-10 col-sm-10">
    								<input class="form-control" type="text" id="extWebUrl" name="extWebUrl" required placeholder="Web URL" value="<?= $Page->webUrl ?>" />
    								
    								<p>Dit is de url naar de externe website</p>
    							</div>
    						</div>
						</div>
    						
						<div id="pageType_content" <?= $Page->pageType == 'content' ? '' : 'style="display: none;"' ?>>
    						<fieldset>
        						<div class="form-group">
        							<label class="control-label col-md-2 col-sm-2" for="webUrl">Web URL * :</label>
        							<div class="col-md-10 col-sm-10">
        								<input class="form-control" type="text" id="webUrl" name="webUrl" required placeholder="Web URL" value="<?= $Page->webUrl ?>" />
        								
        								<p>Dit is de url naar de pagina: <?= rtrim (SITE_URL, '/') ?>/<strong id="web_url">web URL</strong>.html
        							</div>
        						</div>
        						
        						
								<?php
			                        $field = Template::field ('image');
		                            
		                            $field->labelSize = 2;
		                            $field->fieldSize = 10;
		                            
		                            $field->name = 'image';
		                            $field->id   = 'image';
		                            
		                            $field->value = $Page->image;
		                            
		                            $field->required (false);
		                            $field->labelText = 'Image';
		                            
		                            echo $field;
		                        ?>
        						
        						<div class="form-group">
        							<label class="control-label col-md-2 col-sm-2" for="contentField">Content * :</label>
        							<div class="col-md-10 col-sm-10">
        								<textarea name="content" id="contentField" class="form-control" rows="20"><?= $Page->content ?></textarea> 
        							</div>
        						</div>
    				
                            </fieldset>
    						
    						<fieldset>
    						    <legend>Search Engine Optimization (SEO)</legend>
    						    
        						<div class="form-group">
        							<label class="control-label col-md-2 col-sm-2" for="pageTitle">Page title * :</label>
        							<div class="col-md-10 col-sm-10">
        								<input class="form-control" type="text" id="pageTitle" name="pageTitle" required placeholder="Page title" value="<?= $Page->pageTitle ?>" />    								
        							</div>
        						</div>
        						
        						<div class="form-group">
        							<label class="control-label col-md-2 col-sm-2" for="metaKeywords">Key words * :</label>
        							<div class="col-md-10 col-sm-10">
        								<textarea class="form-control" type="text" id="metaKeywords" name="metaKeywords" required placeholder="Page keywords" rows="3"><?= $Page->metaKeywords ?></textarea>    								
        							</div>
        						</div>
        						
        						<div class="form-group">
        							<label class="control-label col-md-2 col-sm-2" for="metaDescription">Page description * :</label>
        							<div class="col-md-10 col-sm-10">
        								<textarea class="form-control" type="text" id="metaDescription" name="metaDescription" required placeholder="Page description" rows="3"><?= $Page->metaDescription ?></textarea>    								
        							</div>
        						</div>
    				
    						    
    						</fieldset>
    						
						</div>
						
						<div class="form-group">
                            <label class="control-label col-md-2 col-sm-2" for="submitBtn">&nbsp;</label>
                            <div class="col-md-10 col-sm-10">
                                <button type="submit" class="btn btn-lg btn-success">Opslaan!</button>
                            </div>
						</div>
						
						
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
    

<?php
        echo App::tinyMCE ('contentField');
                
    } else {
	    
    ?>
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col">
                <span class="text-uppercase page-subtitle">Trips</span>
                <h3 class="page-title">Trip Overview</h3>
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
            
            <style type="text/css">
	            .lo-stats__actions { 
		            width: 300px;
	            }
	            </style>
            <!-- File Manager -->
<!--             <table class="file-manager file-manager-list d-none table-responsive"> -->
                <div class="card card-small h-100">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Upcoming Trips</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body p-0">
                    <div class="container-fluid px-0">
              <table class="table mb-0">
                <thead class="py-2 bg-light text-semibold border-bottom">
                  <tr>
                    <th>Details</th>
                    <th></th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Legs</th>
                    <th class="text-center">Total</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/ib.png">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to Amsterdam</span>

                      <span>22 June 2019 20:32</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-success">Approved</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">2</td>
                    <td class="lo-stats__total text-center text-success">&euro; 256,00</td>
					<td class="lo-stats__actions">
                      <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
	                      <button type="button" class="btn btn-sm btn-white">Manage Booking</button>
                        <button type="button" class="btn btn-sm btn-success">Change Booking</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/ib.png">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to New York</span>

                      <span>22 June 2019 20:32</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-warning">Pending approval</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">4</td>
                    <td class="lo-stats__total text-center text-danger">&euro; 965,00</td>
                    <td class="lo-stats__actions">
<div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
	                      <button type="button" class="btn btn-sm btn-white">Manage Booking</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/kl.png">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to Barcelona</span>

                      <span>22 June 2019 20:32</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-danger">Rejected</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">5</td>
                    <td class="lo-stats__total text-center text-danger">&euro; 1211,00</td>
                    <td class="lo-stats__actions"><div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
	                      <button type="button" class="btn btn-sm btn-danger">Rebook</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/ba.png">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to Paris</span>

                      <span>22 June 2019 20:32</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-success">Approved</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">2</td>
                    <td class="lo-stats__total text-center text-success">&euro; 299,00</td>
                    <td class="lo-stats__actions">
                      <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
	                      <button type="button" class="btn btn-sm btn-white">Manage Booking</button>
                        <button type="button" class="btn btn-sm btn-success">Change Booking</button>
                      </div>
                    </td>
                  </tr>
                </tbody>

<thead class="py-2 bg-light text-semibold border-bottom">
                  <tr>
	                  <th></th>
                    <th>Historical trips</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/trips/frankfurt.jpg">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to Frankfurt</span>

                      <span>13 June 2019 - 17 June 2019</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-success">Completed</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">2</td>
                    <td class="lo-stats__total text-center text-success">&euro; 288,00</td>
                    <td class="lo-stats__actions">
                      <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-white">View details</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/trips/amsterdam.jpg">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to Amsterdam</span>

                      <span>17 May 2019 - 19 May 2019</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-success">Completed</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">4</td>
                    <td class="lo-stats__total text-center text-success">&euro; 196,00</td>
                    <td class="lo-stats__actions">
<div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-white">View details</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/trips/london.jpg">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to London</span>

                      <span>27 April 2019 - 29 April 2019</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-success">Completed</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">5</td>
                    <td class="lo-stats__total text-center text-success">&euro; 192,00</td>
                    <td class="lo-stats__actions"><div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-white">View details</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="lo-stats__image">
                      <img class="border rounded" src="assets/images/trips/copenhagen.jpg">
                    </td>
                    <td class="lo-stats__order-details">
                      <span>Trip to Copenhagen</span>

                      <span>21 March 2019 - 25 March 2019</span>
                    </td>
                    <td class="lo-stats__status">
                      <div class="d-table mx-auto">
                        <span class="badge badge-pill badge-success">Completed</span>
                      </div>
                    </td>
                    <td class="lo-stats__items text-center">2</td>
                    <td class="lo-stats__total text-center text-success">&euro; 291,00</td>
                    <td class="lo-stats__actions">
                      <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-white">View details</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
                    </div>
                  </div>
                </div>



            <!-- End File Manager -->
<?php
    }
    ?>