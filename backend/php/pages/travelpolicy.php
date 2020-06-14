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
        header ('Location: ' . baseHref . $_GET['route'] .'.html?action=corporate&id='. $p->id .'&state=success');
        exit;
        
    } else {
        
        $_SESSION['error'] = $page->errMsg;
        $_SESSION['formData'] = $_POST;
        
        header ('HTTP/1.1 301 Moved Permanently');
        header ('Location: '. baseHref . $_GET['route'] .'.html?action='. $_GET['action'] .'&state=error');
        exit;
        
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['action']) && $_POST['action'] == 'corporate' && isset ($_GET['id'])) {
    
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
    header ('Location: travelpolicy.html?action=corporate&id=1&success');
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
else if ($_GET['action'] == 'corporate')
    $filterText = 'Bewerken';
else
    $filterText = 'Overzicht';
 
$search = '';   
if (isset ($_GET['search'])) 
{
    
    $search = '&amp;search=' . stripslashes ($_GET['search']);
    
}  
    if ($_GET['action'] == 'corporate') {
	    
		require_once baseDir . 'backend/php/pages/policy/corporate.php';
                
    } else if ($_GET['action'] == 'partners') {
	    
		require_once baseDir . 'backend/php/pages/policy/partners.php';
                
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
							<label class="control-label col-md-2 col-sm-2" for="title">Title * :</label>
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
                    <a href="travelpolicy.html?action=corporate&id=1" class="file-manager__item-title">Default Policy</a>
                    <span class="file-manager__item-meta">Last changed 2 hours ago.</span>
                  </td>
                  <td class="text-left">19,823</td>
                  <td class="text-left">Employees, supervisors</td>
                  <td class="file-manager__item-actions">
                    <div class="btn-group btn-group-sm d-flex justify-content-end" role="group" aria-label="Table row actions">
                      <a href="travelpolicy.html?action=corporate&id=1" class="btn btn-white active-light">
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
                    <a href="#" class="file-manager__item-title">Line Managers</a>
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
                    <a href="#" class="file-manager__item-title">Vice Presidents</a>
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