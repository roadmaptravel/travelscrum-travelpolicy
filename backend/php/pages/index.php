<?php
if ($user->id == 1) {
?>	
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                <span class="text-uppercase page-subtitle">Dashboards</span>
                <h3 class="page-title">Nike Booking Overview</h3>
              </div>
              <div class="col-12 col-sm-4 d-flex align-items-center">
                <div id="sales-overview-date-range" class="input-daterange input-group input-group-sm ml-auto">
                  <input type="text" class="input-sm form-control" name="start" placeholder="Start Date" id="analytics-overview-date-range-1">
                  <input type="text" class="input-sm form-control" name="end" placeholder="End Date" id="analytics-overview-date-range-2">
                  <span class="input-group-append">
                    <span class="input-group-text">
                      <i class="material-icons">&#xE916;</i>
                    </span>
                  </span>
                </div>
              </div>
            </div>
            <!-- End Page Header -->

            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="card card-small country-stats">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Where are my travelers?</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body p-0">
                    <div id="users-by-country-map" style="width: 100%; height: 300px;"></div>
                    <table class="table m-0">
                      <tbody>
                        <tr>
                          <td>
                            <img class="country-flag mr-1" src="assets/images/flags/flag-es.svg" alt="Espana"> Spain</td>
                            <td><span class="badge badge-pill badge-success">approved country</span></td>
                          <td class="text-right">12,219</td>
                          <td class="text-right">32.4%</td>
                        </tr>
                        <tr>
                          <td>
                            <img class="country-flag mr-1" src="assets/images/flags/flag-uk.png" alt="United Kingdom"> United Kingdom</td>
                            <td><span class="badge badge-pill badge-success">approved country</span></td>
                          <td class="text-right">11,192</td>
                          <td class="text-right">18.8%</td>
                        </tr>
                        <tr>
                          <td>
                            <img class="country-flag mr-1" src="assets/images/flags/flag-us.png" alt="Australia"> United States</td>
                            <td><span class="badge badge-pill badge-warning">approval needed</span></td>
                          <td class="text-right">9,291</td>
                          <td class="text-right">12.3%</td>
                        </tr>
                        <tr>
                          <td>
                            <img class="country-flag mr-1" src="assets/images/flags/flag-jp.png" alt="Japan"> Japan</td>
                            <td><span class="badge badge-pill badge-danger">not aproved</span></td>
                          <td class="text-right">2,291</td>
                          <td class="text-right">8.14%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer border-top">
                    <div class="row">
                      <div class="col text-right view-report">
                        <a href="#">View full report &rarr;</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-12 mb-4">
                <div class="card card-small lo-stats h-100">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Travelers about to go to risk countries</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body p-0">
                    <div class="container-fluid px-0">
                      <table class="table mb-0 travel-bookings">
                        <thead class="py-2 bg-light text-semibold border-bottom">
                          <tr>
                            <th>Details</th>
                            <th></th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Infection risk score</th>
                            <th class="text-center">Carbon footprint</th>
                            <th class="text-center">Applied Policy</th>
                            <th class="text-center">Completed checklist</th>
                            <th class="text-right">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="assets/images/ib.png">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>Trip to China</span>
                              <span>Traveler: Aurelie Krau</span>
                              <span>15 June - 22 June 2020</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
	                              <span class="badge badge-pill badge-danger">Rejected</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center text-danger">88/100</td>
                            <td class="lo-stats__items text-center"><span class="text-warning">9.23 tonnes</span><br /><small>Reason: long flight</small></td>
                            <td class="lo-stats__items text-center">2</td>
                            <td class="lo-stats__items text-center"><i class="material-icons text-danger">warning</i></td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">view checklist</button>
                              </div>
                            </td>
                          </tr>
                          <?php
	                          if (isset ($_GET['approve'])):
	                       ?>
                          <tr class="alert-success">
                            <td class="lo-stats__image">
	                            <a name="approved"></a>
                              <img class="border rounded" src="assets/images/ib.png">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>Trip to New York</span>
                              <span>Traveler: Micha van Eijk</span>
                              <span style="color: #fff;">16 June - 22 June 2020</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-success">Approved</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center text-warning">54/100</td>
                            <td class="lo-stats__items text-center text-green">0.81 tonnes</td>
                            <td class="lo-stats__items text-center">4</td>
                            <td class="lo-stats__items text-center"><i class="material-icons text-success">check</i></td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">view checklist</button>
                              </div>
                            </td>
                          </tr>
                          <?php
	                          else:
	                      ?>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="assets/images/ib.png">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>Trip to New York</span>
                              <span>Traveler: Micha van Eijk</span>
                              <span>16 June - 22 June 2020</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-warning">Pending approval</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center text-warning">54/100</td>
                            <td class="lo-stats__items text-center text-success">0.81 tonnes</td>
                            <td class="lo-stats__items text-center">4</td>
                            <td class="lo-stats__items text-center"><i class="material-icons text-success">check</i></td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <a href="?approve#approved" class="btn btn-sm btn-success">Approve</a>
                                <a href="?reject#approved" class="btn btn-sm btn-danger">Reject</a>
                              </div>
                            </td>
                          </tr>
                          <?php
	                          endif;
	                      ?>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="assets/images/ba.png">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>Trip to London</span>
                              <span>Traveler: Gaby Verwegen</span>
                              <span>22 June 2020 20:32</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-success">Approved</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center text-success">26/100</td>
                            <td class="lo-stats__items text-center text-success">0.09 tonnes</td>
                            <td class="lo-stats__items text-center">2</td>
                            <td class="lo-stats__items text-center"><i class="material-icons text-success">check</i></td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">view checklist</button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="assets/images/kl.png">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>Trip to Sydney</span>
                              <span>Traveler: Rogier Verkaik</span>
                              <span>22 June - 29 June 2020</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-success">Approved</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center text-success">33/100</td>
                            <td class="lo-stats__items text-center"><span class="text-danger">9.23 tonnes</span><br /><small>Reason: first class</small></td>
                            <td class="lo-stats__items text-center">5</td>
                            <td class="lo-stats__items text-center"><i class="material-icons text-success">check</i></td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">view checklist</button>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer border-top">
                    <div class="row">
                      <div class="col">
                        <select class="custom-select custom-select-sm" style="max-width: 130px;">
                          <option selected>Last Week</option>
                          <option value="1">Today</option>
                          <option value="2">Last Month</option>
                          <option value="3">Last Year</option>
                        </select>
                      </div>
                      <div class="col text-right view-report">
                        <a href="#">View full report &rarr;</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<?php
}
