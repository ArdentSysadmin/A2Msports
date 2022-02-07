<div class="row mt-5">
                    <div class="col-lg-10 offset-lg-1">
                      <div class="bg-white p-3">
                        <div class="head d-flex justify-content-between align-items-center">
                          <h4 class="gry mb-0">Filter</h4>
                          <div class="input-group w-30 mb-3 sreach_filter">
                              <button class="btn btn-outline-secondary border-orange bg-orange" type="button" id="button-addon1">Sreach</button>
                              <input type="text" class="form-control" placeholder="Search by Name,City,State" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            </div>
                        </div>
                        <div class="middle d-flex justify-content-between align-items-center">
                          <div class="Filter_middle_box d-flex align-items-center justify-content-start">
                            <p class="mb-0">Age Group</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All <img src="<?=base_url();?>assets_new/images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div>
                          <!-- <div class="Filter_middle_box align-items-center  d-flex justify-content-start">
                            <p class="mb-0">Tournament Date</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">This Year <img src="images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div> -->
                          <!-- <div class="Filter_middle_box align-items-center d-flex justify-content-start">
                            <p class="mb-0">Registration Status</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Closed  <img src="images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div> -->
                          <!-- <div class="Filter_middle_box d-flex align-items-center justify-content-start">
                            <p class="mb-0">Tournament Type</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="images/country.png" class="mx-0"> <img src="images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div> -->
                        </div>
                        <div class="table_content relative">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Player Name</th>
                                <th scope="col">City</th>
                                <th scope="col">State</th>
                                <th scope="col">A2M Rating <br>(Singles)</th>
                                <th scope="col">A2M Rating <br>(Doubles)</th>
                                <th scope="col">A2M Rating <br>(Mixed)</th>
                              </tr>
                            </thead>
                            <tbody>
<?php
$k=1;
foreach($loc_query as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID,$sport);
$membership_det = league::get_membership_details($row->Users_ID);
 ?>
                              <tr>
                                <td><p class="mt-3 mb-0"><?php echo $k;?></p></td>
								<td><p class="mt-3 mb-0"><a target="_blank" href="<?php echo base_url();?>
										<?php if($row->Is_coach==1){ echo "coach"; } else{ echo "player"; }?>/<?php echo $row->Users_ID;?>">
										<?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?>
										</a></p></td>
                                <td><p class="mt-3 mb-0"><?php echo $row->City;?></p></td>
                                <td><p class="mt-3 mb-0"><?php echo $row->State;?></p></td>
                                <td><p class="mt-3 mb-0"><?php echo $row->A2M_Singles;?></p></td>
                                <td><p class="mt-3 mb-0"><?php echo $row->A2M_Doubles;?></p></td>
                                <td><p class="mt-3 mb-0"><?php echo $row->A2M_Mixed;?></p></td>
                              </tr>
   <?php 
	$k++;
} ?>                           



                            </tbody>
                          </table>
						  <?php if(!$this->session->userdata('user')) {?>
                          <div class="sing_up_theme">
                            <div class="text-center text_bottom">
                              <h1 class="text-light mb-5">Sign up for Complete Access</h1>
                              <div class="btn_blue text-center">
                                <a href="#" class="white_btn">Sign Up</a>
                              </div>
                            </div>
                          </div>
						<?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>