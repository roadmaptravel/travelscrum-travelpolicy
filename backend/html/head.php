<?php
	if ($user->id == 1) {
	$Modules = array (
	
	    'analytics' => array (
	        'title'         => 'Overview',
	        'moduleFile'    => 'index.php',
	        'custom'        => false,
	        'icon'          => 'analytics',
	        'javascript'    => 'pages',
	        'submenu'       => false
	    ),
	    'travelpolicy' => array (
	        'title'         => 'Travel Policy',
	        'moduleFile'    => 'travelpolicy.php',
	        'custom'        => false,
	        'icon'          => 'work',
	        'javascript'    => 'policy',
	        'submenu'       => array (
		        'corporate' => 'COVID-19 Policy',
		        'partners' => 'Trusted Partners',
		        'country' => 'Country Specific'
	        )
	    )
	);
} else {
	
	// Traveler
	
	$Modules = array (

	    'profile' => array (
	        'title'         => 'Profile',
	        'moduleFile'    => 'index.php',
	        'custom'        => false,
	        'icon'          => 'person',
	        'javascript'    => 'pages',
	        'submenu'       => array (
		        'view' => 'View profile',
		        'edit' => 'Change profile'
	        )
	    ),
	    'trips' => array (
	        'title'         => 'Trips',
	        'moduleFile'    => 'trips.php',
	        'custom'        => false,
	        'icon'          => 'work',
	        'javascript'    => 'policy',
	        'submenu' => false
	    ),
	    'book' => array (
	        'title'         => 'Book Travel',
	        'moduleFile'    => 'book.php',
	        'custom'        => false,
	        'icon'          => 'next_week',
	        'javascript'    => 'webshop.product',
	        'submenu' => false
	    )    
	);
	
}

?>
<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Travel Manager Tool - Roadmap</title>
    <meta name="description" content="A dashling dashboard for Travel Managers to easily manage their travel policy and to go the extra mile for their travelers.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.3.1" href="assets/styles/shards-dashboards.1.3.1.css">
    <link rel="stylesheet" href="assets/styles/extras.1.3.1.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" />
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <span class="d-none d-md-inline ml-1 text-white"><?= ($user->id == 1) ? 'Travel Manager Tool' : 'Traveler Dashboard' ?></span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
            <div class="input-group input-group-seamless ml-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-search"></i>
                </div>
              </div>
              <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
            </div>
          </form>
          <div class="nav-wrapper">
            <h6 class="main-sidebar__nav-title text-white">Dashboards</h6>
            <ul class="nav nav--no-borders flex-column">
<?php
	foreach ($Modules as $Name => $Module)
	{
	    if (isset ($Module['submenu']) && is_array ($Module['submenu']))
	    {
	?>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle <?= App::current ($Name, 'active', true) ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
			<i class="material-icons"><?= $Module['icon'] ?></i>
			<span><?= $Module['title'] ?></span>
		</a>
		
	    <div class="dropdown-menu dropdown-menu-small show">
	        <?php
	        
	        foreach ($Module['submenu'] as $action => $name) 
	        {
	        
	        ?>
			<a class="dropdown-item <?= App::currentS ($action, 'active', true) ?>" href="<?= $Name ?>.html?action=<?= $action ?>"><?= $name ?></a>
	        <?php
	        
	        }
	        
	        ?>
		</div>
	</li>
	<?php    					    
	    }
	    else
	    {
	?>
	<li class="nav-item">
		<a href="<?= $Name ?>.html" class="nav-link <?= App::current ($Name, 'active', true) ?>">
			<i class="material-icons"><?= $Module['icon'] ?></i>
			<span><?= $Module['title'] ?></span>
		</a>
	</li>
	<?php
	    }
	}
?>
	            
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                <div class="input-group input-group-seamless ml-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                  <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                </div>
              </form>
              <ul class="navbar-nav border-left flex-row ">
	              <?php
		              if ($user->id == 1):
		          ?>
                <li class="nav-item border-right dropdown notifications">
                  <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="nav-link-icon__wrapper">
                      <i class="material-icons">&#xE7F4;</i>
                      <span class="badge badge-pill badge-danger">1</span>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="?approve#approved">
                      <div class="notification__icon-wrapper">
                        <div class="notification__icon">
                          <i class="material-icons">&#xE6E1;</i>
                        </div>
                      </div>
                      <div class="notification__content">
                        <span class="notification__category">New Booking</span>
                        <p>Aurelie Krau has just booked a trip to <span>Amsterdam</span> for 9 July 2019 - 12 July 2019. The booking is <span class="text-success text-semibold">within policy</span>. Tap here to approve the booking.</p>
                      </div>
                    </a>
                    <a class="dropdown-item notification__all text-center" href="#"> View all Notifications </a>
                  </div>
                </li>
                <?php
	                else:
	             ?>
	                             <li class="nav-item border-right dropdown notifications">
                  <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="nav-link-icon__wrapper">
                      <i class="material-icons">&#xE7F4;</i>
                      <span class="badge badge-pill badge-danger">2</span>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">
                      <div class="notification__icon-wrapper">
                        <div class="notification__icon">
                          <i class="material-icons">&#xE6E1;</i>
                        </div>
                      </div>
                      <div class="notification__content">
                        <span class="notification__category">Book your trip</span>
                        <p>You have a meeting planned in Amsterdam on July 10 - July 11, make sure to book your trip as soon as possible. Prices are rising the coming <span class="text-danger text-semibold">3 days</span>.</p>
                      </div>
                    </a>
                    <a class="dropdown-item" href="#">
                      <div class="notification__icon-wrapper">
                        <div class="notification__icon">
                          <i class="material-icons">flight</i>
                        </div>
                      </div>
                      <div class="notification__content">
                        <span class="notification__category">Trip planned</span>
                        <p>Your trip to Athens <span class="text-successs text-semibold">is approved</span> by Nikki Foster. Start preparing for your trip!</p>
                      </div>
                    </a>
                    <a class="dropdown-item notification__all text-center" href="#"> View all Notifications </a>
                  </div>
                </li>
                <?php
	                endif;
	            ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="assets/images/<?= strtolower ($user->firstName) ?>.jpg" alt="User Avatar"> <span class="d-none d-md-inline-block"><?= $user->firstName .' ' . $user->lastName ?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="profile.html"><i class="material-icons">&#xE7FD;</i> Profile</a>
                    <a class="dropdown-item" href="profile.html?action=edit"><i class="material-icons">&#xE8B8;</i> Edit Profile</a>
                    <a class="dropdown-item" href="trips.html"><i class="material-icons">&#xE896;</i> Trips</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="index.html?logout">
                      <i class="material-icons text-danger">&#xE879;</i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-sm-inline d-md-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div> <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->