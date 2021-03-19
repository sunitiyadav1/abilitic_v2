
<?php   
    require_once '../config.php';    
    require_login();

    Global $USER,$CFG,$OUTPUT;
    require_once "layout/include/header.php";
    
    
?>
    
    <div class="container">
        <div class="row mt-3 mt-lg-5">
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 mb-3 mb-lg-0">
                    <h3>Welcome back, <span><?php echo  $USER->firstname." ".$USER->lastname ?></span>!</h3><a href="<?php echo $CFG->wwwroot.'/message/output/popup/notifications.php'?>">
                <span id="totalcount"></span></a>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 float-right">
                <div class="row header-notif-container text-center">
                    <div class="col mb-3">
                    <a href="" id="announcement_href">
                        <div class="media" >
                            <img src="layout/assets/images/icon-announcement.svg" class="banner-notification-icon mr-2"  style="width: 24px; height: 24px;"/>
                            <div class="media-body" >
                              <div class="mb-2">Announcements</div>
                              <div class="align-self-center">
                                  <h3 class="mb-0 d-inline-block align-middle"><span id="announcement_total" Placeholder="0"></span></h3>
                                  <!-- <span class="card-notofication-count align-middle"><span id="announcement_new" Placeholder="0"></span></span> -->
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col mb-3">
                    <a href="" id="badges_href">
                        <div class="media">
                            <img src="layout/assets/images/icon-bagdes.svg" class="banner-notification-icon mr-2"  style="width: 24px; height: 24px;"/>
                            <div class="media-body">
                              <div class="mb-2">Badges</div>
                              <div class="align-self-center">
                                  <h3 class="mb-0 d-inline-block align-middle"><span id="badges_total" Placeholder="0"></span></h3>
                                  <!--<span class="card-notofication-count align-middle">1</span>-->
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col mb-3">
                    <a href="" id="message_href">
                        <div class="media">
                            <img src="layout/assets/images/icon-messages.svg" class="banner-notification-icon mr-2"  style="width: 24px; height: 24px;"/>
                            <div class="media-body">
                              <div class="mb-2">Messages</div>
                              <div class="align-self-center">
                                  <h3 class="mb-0 d-inline-block align-middle"><span id="message_total" Placeholder="0"></span></h3>
                                  <span class="card-notofication-count align-middle" id="message_new"></span>
                            </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col mb-3">
                    <a href="" id="calendar_href">
                        <div class="media">
                            <img src="layout/assets/images/icon-calender.svg" class="banner-notification-icon mr-2" style="width: 24px; height: 24px;" />
                            <div class="media-body">
                              <div class="mb-2">Calendar</div>
                              <div class="align-self-center">
                                  <h3 class="mb-0 d-inline-block align-middle"><span id="calendar_total" Placeholder="0"></span></h3> 
                                  <span class="card-notofication-count align-middle" id="calendar_new"></span>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col mb-3">
                    <a href="" id="files_href">
                        <div class="media">
                            <img src="layout/assets/images/icon-files.svg" class="banner-notification-icon mr-2"  style="width: 24px; height: 24px;"/>
                            <div class="media-body">
                              <div class="mb-2">Files</div>
                              <div class="align-self-center">
                                  <h3 class="mb-0 d-inline-block align-middle"><span id="files_total" Placeholder="0"></span></h3> 
                            </div>
                            </div>
                          </div></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 single-slide">
                <div class="bd-example">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-ride="carousel">
                        <div class="carousel-inner carousel-custom custom-height rounded" id="slider_div">
                            <!-- <div class="carousel-item overflow-hidden active">
                                <img src="layout/assets/images/header-slider-1.jpg" class="d-block img-fluid rounded w-100" alt="Slide One">
                                <div class="carousel-caption p-0 text-left">
                                    <div class="card bg-black border-0">
                                      <div class="card-body py-1 px-2 p-sm-3">
                                          <h4 class="card-title">Resume where you left</h4>
                                          <h3>Business Analytics</h3>
                                            <div class="progressbar-box my-2 w-50">
                                                <div class="progress position-relative">
                                                <div class="progress-bar rounded" role="progressbar" style="width: 30%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    <small class="slider-progress-number">30% Completed</small>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="mt-md-4 pt-3 text-uppercase align-items-center resume-video-link">
                                                <a class="d-inline-block align-middle" href="">RESUME <span class="resume-video-icon align-middle d-inline-block"><img src="layout/assets/images/video-resume.png" alt="" style="width: 26px;"></span></a>
                                            </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item overflow-hidden">
                                <img src="layout/assets/images/header-slider-1.jpg" class="d-block img-fluid rounded w-100" alt="Slide Two">
                                <div class="carousel-caption p-0 text-left">
                                    <div class="card  bg-black border-0">
                                      <div class="card-body py-1 px-2 p-sm-3">
                                        <h5 class="card-title">Resume where you left</h5>
                                        <h3>Business Analytics</h3>
                                        <div class="progressbar-box my-2 w-50">
                                            <div class="progress position-relative">
                                              <div class="progress-bar rounded" role="progressbar" style="width: 30%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                  <small class="slider-progress-number">30% Completed</small>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="mt-md-4 pt-3 text-uppercase align-items-center resume-video-link">
                                            <a class="d-inline-block align-middle" href="">RESUME <span class="resume-video-icon align-middle d-inline-block"><img src="layout/assets/images/video-resume.png" style="width: 26px;"/></span></a>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item overflow-hidden">
                                <img src="layout/assets/images/header-slider-1.jpg" class="d-block img-fluid rounded w-100" alt="Slide Three">
                                <div class="carousel-caption p-0 text-left">
                                    <div class="card  bg-black border-0">
                                      <div class="card-body py-1 px-2 p-sm-3">
                                        <h5 class="card-title">Resume where you left</h5>
                                        <h3>Business Analytics</h3>
                                        <div class="progressbar-box my-2 w-50">
                                            <div class="progress position-relative">
                                              <div class="progress-bar rounded" role="progressbar" style="width: 30%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                  <small class="slider-progress-number">30% Completed</small>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="mt-md-4 pt-3 text-uppercase align-items-center resume-video-link">
                                            <a class="d-inline-block align-middle" href="">RESUME <span class="resume-video-icon align-middle d-inline-block"><img src="layout/assets/images/video-resume.png" style="width: 26px;"/></span></a>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <a class="carousel-control-prev rounded-circle  d-inline-block" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <img src="layout/assets/images/icon-next.svg" style="transform: rotate(180deg);" />
                        </a>
                        <a class="carousel-control-next rounded-circle d-inline-block" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <img src="layout/assets/images/icon-next.svg" />
                        </a>
                    </div>
                </div>
            </div>
           <!---old code-->
            <!-- <div class="col-lg-3 card-group">
				<div class="card rounded">
					<div class="card-body">
						<div class="media">
							<img src="layout/assets/images/icon-due-dates.svg" class="w-25 mr-3" />
							<div class="media-body">
								<div class="text-danger" >DUE IN 2 DAYS</div>
                                <div id="due_in_two_days">
                                </div>
								<div>
									<div class="my-2">Going to Business School</div>
									<div class="text-muted small">5 Dec 2017</div>
								</div>
								<div>
									<div class="my-2">Going to Business School</div>
									<div class="text-muted small">5 Dec 2017</div>
								</div>
                                <div>
									<div class="my-2">Going to Business School</div>
									<div class="text-muted small">5 Dec 2017</div>
								</div>
                                
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 card-group">
				<div class="card border-0">
				  <div class="card-body border rounded mb-4">
					  <div class="media">
						  <div class="w-25 mr-3">
                          <canvas id="myChart" width="350" height="400"></canvas>
							  <div class="circle-wrap">
								  <div class="circle">
									<div class="mask full">
										<div class="fill"></div>
									</div>
									<div class="mask half">
										<div class="fill"></div>
									</div>
									<div class="inside-circle">&nbsp;</div>
								</div>
							</div>
						</div>
						<div class="media-body">
							<h3 class="h3"><span id="learning_path_percent"><span></h3>
							<div>Your Learning Path Achieved</div>
						</div>
					  </div>
				  </div>
				  <div class="card-body border rounded">
					<a href="" id="course_count_href"><div class="media-body">
                        <img src="layout/assets/images/icon-enrolment.svg" class="w-25 mr-3" />
                        <div>
                            <div class="cards-list-name small">My Courses </div><div class="card-list-count"><span id="mycourse_count"></span></div>
                        </div>
                        <div class="my-2">
                            <div class="cards-list-name small">Self Enrolment </div><div class="card-list-count"><span id="selfnomination_count"></span></div>
                        </div>
                        <div>
                            <div class="cards-list-name small">Classroom Sessions </div><div class="card-list-count"><span id="iltsession_total"></span></div>
                        </div>
                    </div></a>
                  </div>
				</div>
			</div> -->
            <!---old code-->

            <div class="col-lg-6">
                <div class="form-row">
                    <div class="col-12 my-cources-wrap">
                        <ul class="nav nav-tabs nav-fill zing-nav border-0" id="myTab" role="tablist">
                            <li class="nav-item mb-0">
                                <a class="nav-link active text-uppercase bg-white text-muted border position-relative py-lg-3 px-lg-4 px-3 rounded-top" 
                                    id="Progress" data-toggle="tab" href="#inProgress" role="tab" aria-controls="in-progress" aria-selected="true">Due Immediately</a>
                            </li>
                            <li class="nav-item mb-0">
                                <a class="nav-link text-uppercase bg-white text-muted border  position-relative py-lg-3 px-lg-4 px-3 rounded-top" 
                                    id="peding-tab" data-toggle="tab" href="#peding" role="tab" aria-controls="pending-tab" aria-selected="false">Due in 7 Days</a>
                            </li>
                            <li class="nav-item mb-0">
                                <a class="nav-link text-uppercase bg-white text-muted  border  position-relative py-lg-3 px-lg-4 px-3 rounded-top" 
                                    id="complted-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="complted-tab" aria-selected="false"> Due  Later this month </a>
                            </li>
                        </ul>
                        <div class="tab-content zing-nav-content p-3 bg-white border" id="myTabContent">
                            <div class="tab-pane fade show active" id="inProgress" role="tabpanel" aria-labelledby="inProgress">
                                <div class="media">
                                    <img src="layout/assets/images/icon-due-dates.svg" class="w-25 mr-3">
                                    <div class="media-body">
                                        <div class="text-danger">DUE IMMEDIATELY</div>
                                        <div id="due_immediately">
                                        </div>
                                        <!-- <div>
                                            <div class="my-2">Going to Business School</div>
                                            <div class="text-muted small">5 Dec 2017</div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="my-2">Going to Business School</div>
                                            <div class="text-muted small">5 Dec 2017</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="peding" role="tabpanel" aria-labelledby="pending-tab">
                                <div class="media">
                                    <img src="layout/assets/images/icon-due-dates.svg" class="w-25 mr-3">
                                    <div class="media-body">
                                        <div class="text-danger">DUE IN 7 DAYS</div>
                                        <div id="due_insome_time">
                                        </div>
                                        <!-- <div>
                                            <div class="my-2">Going to Business School</div>
                                            <div class="text-muted small">5 Dec 2017</div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="my-2">Going to Business School</div>
                                            <div class="text-muted small">5 Dec 2017</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                                <div class="media">
                                    <img src="layout/assets/images/icon-due-dates.svg" class="w-25 mr-3">
                                    <div class="media-body">
                                        <div class="text-danger">DUE LATER THIS MONTH</div>
                                        <div id="due_later">
                                        </div>
                                        <!-- <div>
                                            <div class="my-2">Going to Business School</div>
                                            <div class="text-muted small">5 Dec 2017</div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="my-2">Going to Business School</div>
                                            <div class="text-muted small">5 Dec 2017</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 card-group">
                        <div class="card border-0 mt-3">
                            <div class="card-body border rounded">
                                <div class="row">
                                <div class="col-sm-5">
                                    <h3>Learning Plans</h3>
                                    <div class="media" id="course_count_href">
                                    <div class="media-body" id="learn_path">
                                    
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="media">
                                    <div class="w-25 mr-3"><div class="chartjs-size-monitor"></div>
                                    <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                    </div>
                                    <canvas id="myChart" width="80" height="80" style="display: block; width: 80px; height: 90px;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    <div class="media-body">    
                                        <h3 class="h3">
                                        <span id="learning_path_percent"></span>
                                        </h3>
                                        <div>Your Learning Path Achieved</div>
                                        </div>
                                    </div>
                                </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-6 card-group">
                        <div class="card border-0 mt-3">
                            <div class="card-body border rounded">
                            <h3>Learning Plans</h3>
                                <a href="" id="course_count_href"><div class="media">
                                    <div class="media-body" id="learn_path">
                                    </div>
                                </div></a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>


        </div>
        <div class="row my-4">
            <div class="col-lg-9 col-md-12 col-sm-12 col-12">
               
                <div class="card your-learning-analysis">
                    <div class="card-header p-3 bg-white border-bottom-0">
                        <h3 class="d-inline-block mb-0">Your Learning Analysis</h3>
                        <a href="#" class="card-link d-inline-block float-right align-items-middle text-black">
                            <span class="d-inline-block align-middle"><strong>View Details</strong></span>
                            <span class="arrow-icon-size d-inline-block">
                                <img src="layout/assets/images/icon-next.svg">
                            </span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row pt-2">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                <h4>Compentencies Achivied</h4>
                                <span class="text-muted">In Percentage</span>
                                <div class="row mt-2 align-content-center">
                                    <div class="col-6 align-middle">
                                        <h1 class="d-inline-block display-4 align-middle"><span id="overall_comp"></span></h1><span class="ml-2">%</span>
                                    </div>
                                    <div class="col-6 pl-0">
                                        <img src="layout/assets/images/Path2.svg" alt="Graph Flow" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                                <h4>Your Compentencies Analysis</h4>
                                <div class="mt-3" id="pms_top_level_list">
                                    <!-- <div class="col-anlsis-box position-relative">
                                        <span class="gridcolor1  d-inline-block align-middle mr-2" id="toplevel_one"></span>
                                    </div>
                                    <div class="col-anlsis-box position-relative">
                                        <span class="gridcolor2  d-inline-block align-middle mr-2" id="toplevel_two"></span>
                                    </div>
                                    <div class="col-anlsis-box position-relative">
                                        <span class="bgColora0c  d-inline-block align-middle mr-2" id="toplevel_three"></span>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-12 col-sm-12 col-12 mt-sm-3">
                                <div class="table-responsive">
                                    <table class="table table-sm text-center text-white">
                                        <tbody id = "pms_table">
                                            <!-- <tr>
                                                <td class="gridcolor1">Business Stategy</td>
                                                <td class="gridcolor2">Business Valuation</td>
                                                <td class="gridcolor1">Product Marketing</td>
                                                <td></td>
                                                <td class="gridcolor3">Merchant Banking</td>
                                                <td> </td>
                                            </tr>
                                            <tr>
                                                <td class="gridcolor2">Team Management</td>
                                                <td class="gridcolor1">Business Analytics</td>
                                                <td></td>
                                                <td class="gridcolor2">Project Management</td>
                                                <td class="gridcolor3">Vendor Management</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="gridcolor1">Operations Management</td>
                                                <td class="gridcolor2">Customer Relationship</td>
                                                <td class="gridcolor1">Business Development</td>
                                                <td class="gridcolor3">Leadership</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="gridcolor2">Employee Training</td>
                                                <td class="gridcolor1">Performance Management</td>
                                                <td></td>
                                                <td class="gridcolor3">Team Building</td>
                                                <td class="gridcolor3">Critical Training</td>
                                                <td class="gridcolor3">Stress Analytics</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Basic</th>
                                                <th colspan="2">Advance</th>
                                                <th colspan="2">Critical</th>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <h3 class="mt-4">My Courses</h3>
                


                <div class="row">
                    <div class="col-sm-12">
                        <div id="carousel-example-multi" class="carousel slide carousel-multi-item v-2 pb-4" data-ride="carousel">
                            <!--Controls-->
                            <div class="controls-top">
                                <a class="btn-floating p-0" href="#carousel-example-multi" data-slide="prev" id="bnt_prev"><img src="layout/assets/images/icon-next.svg" class="footer-slider icon-gradient-color mr-2" style="transform: rotate(180deg);"> Prevoius</a>
                                <a class="btn-floating p-0 float-right" href="#carousel-example-multi" data-slide="next" id="btn_next">Next <img src="layout/assets/images/icon-next.svg" class="ml-2"></a>
                            </div>
                            <!--/.Controls-->
                            <div class="row">
                                <div class="carousel-inner v-2" role="listbox" id="divappend">
                                <div class="carousel-item active mb-3">
                                    <div class="col-12 col-lg-4">
                                        <div class="card h-100">
                                    <img class="card-img-top" src="layout/assets/images/my-courses-1.jpg" alt="Card image cap">
                                      <div class="card-body d-flex flex-column">
                                          <h3 class="card-title">Working on a Team</h3>
                                          <p class="card-text">Identify and Increase your team woking skills and help others contribute more on a team Identify and Increase your team woking skills and help others contribute more on a team</p>
                                          <div class="course-completed w-100 mt-auto mb-2">
                                            <div class="progressbar-box mt-1 pb-3 w-50 d-inline-block">
                                                <div class="progress position-relative">
                                                  <div class="progress-bar rounded" role="progressbar" style="width: 20%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    <small class="text-muted slider-progress-number">20% Completed</small>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <span class="arrow-icon-size">
                                                    <img src="layout/assets/images/icon-next.svg">
                                                </span>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                    </div>
                                </div>
                                <div class="carousel-item mb-3">
                                    <div class="col-12 col-lg-4">
                                        <div class="card h-100">
                                    <img class="card-img-top" src="layout/assets/images/my-courses-2.jpg" alt="Card image cap">
                                      <div class="card-body d-flex flex-column">
                                          <h3 class="card-title">Knowing youself and others</h3>
                                            <p class="card-text">Teach you the big five personality traits and their facts Teach you the big five personality traits and their facts</p>
                                          <div class="course-completed w-100 mt-auto mb-2">
                                            <div class="progressbar-box mt-1 pb-3 w-50 d-inline-block">
                                                <div class="progress position-relative">
                                                  <div class="progress-bar rounded" role="progressbar" style="width: 20%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    <small class="text-muted slider-progress-number">20% Completed</small>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <span class="arrow-icon-size">
                                                    <img src="layout/assets/images/icon-next.svg">
                                                </span>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                    </div>
                                    
                                </div>
                                <div class="carousel-item mb-3">
                                    <div class="col-12 col-lg-4">
                                        <div class="card h-100">
                                    <img class="card-img-top" src="layout/assets/images/my-courses-3.jpg" alt="Card image cap">
                                      <div class="card-body d-flex flex-column">
                                          <h3 class="card-title">Working on a Team</h3>
                                        <p class="card-text">Identify and Increase your team woking skills and help others contribute more on a team Identify and Increase your team woking skills and help others contribute more on a team</p>
                                          <div class="course-completed w-100 mt-auto mb-2">
                                            <div class="progressbar-box mt-1 pb-3 w-50 d-inline-block">
                                                <div class="progress position-relative">
                                                  <div class="progress-bar rounded" role="progressbar" style="width: 20%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    <small class="text-muted slider-progress-number">20% Completed</small>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <span class="arrow-icon-size">
                                                    <img src="layout/assets/images/icon-next.svg">
                                                </span>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!--Indicators-->
                            <ol class="carousel-indicators mb-0" id="ol_indicator">
                                <!-- <li data-target="#multi-item-example" data-slide-to="0" class="text-center rounded-circle border active">1</li>
                                <li data-target="#multi-item-example" data-slide-to="1" class="text-center rounded-circle border">2</li>
                                <li data-target="#multi-item-example" data-slide-to="2" class="text-center rounded-circle border">3</li> -->
                            </ol>
                            <!--/.Indicators-->
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-12 mt-xs-3 mt-sm-6 mt-xs-6">
                <div class="card">
                    <div class="card-header p-3 bg-white border-bottom-0">
                        <h3 class="d-inline-block w-50 mb-0">My Training Calendar</h3>
                        <img src="layout/assets/images/icon-training-calendar.svg" class="float-right" />
                    </div>
                    <div class="card-body">
                        <ol class="zing-timeline-primary" id="calendar_event">
                            <li class="feed-item pl-3">
                                <div class="feed-item-list p-2 rounded border">
                                    <div class="media">
                                        <div class="icon-box active mr-2">
                                            <img src="layout/assets/images/icon-calender.svg" />
                                        </div>
                                        <div class="media-body">
                                            <p class="mb-1 small">Business Analytics</p>
                                            <p class="text-muted mt-0 mb-0 small"><i class="icon icon-time mr-1"></i><span>8:00 AM - 8:40 AM</span></p>
                                            <div class="dateTime">
                                                <div class="small">5 Dec</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--<li class="feed-item pl-3">
                                <div class="feed-item-list p-2 rounded border">
                                    <div class="media">
                                        <div class="icon-box mr-2">
                                            <img src="layout/assets/images/icon-calender.svg" />
                                        </div>
                                        <div class="media-body">
                                            <p class="mb-1 small">Knowing Yourself </p>
                                            <p class="text-muted mt-0 mb-0 small"><i class="icon icon-time mr-1"></i><span>9:00 AM - 9:30 AM</span></p>
                                            <div class="dateTime">
                                                <div class="small">7 Dec</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="feed-item pl-3">
                                <div class="feed-item-list p-2 rounded border">
                                    <div class="media">
                                        <div class="icon-box mr-2">
                                            <img src="layout/assets/images/icon-calender.svg" />
                                        </div>
                                        <div class="media-body">
                                            <p class="mb-1 small">Improve Listening</p>
                                            <p class="text-muted mt-0 mb-0 small"><i class="icon icon-time mr-1"></i><span>12:00 PM - 12:40 PM</span></p>
                                            <div class="dateTime">
                                                <div class="small">15 Dec</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="feed-item pl-3 pb-2">
                                <div class="feed-item-list p-2 rounded border">
                                    <div class="media">
                                        <div class="icon-box mr-2">
                                            <img src="images/icon-calender.svg" />
                                        </div>
                                        <div class="media-body">
                                            <p class="mb-1 small">Working On Team</p>
                                            <p class="text-muted mt-0 mb-0 small"><i class="icon icon-time mr-1"></i><span>8:00 AM - 8:40 AM</span></p>
                                            <div class="dateTime">
                                                <div class="small">22 Dec</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                        </ol>
                        
                        <div class="text-right">
                            <a href="<?php echo $CFG->wwwroot.'/calendar/view.php?view=month'?>" class="card-link align-items-middle color2a3 font-weight-bold">
                                <span id="spcal"></span> <span><img src="layout/assets/images/icon-next.svg" class="ml-2" /></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "layout/include/footer.php"; ?>
    <script type="text/javascript" src="layout/include/dashboard.js"></script>
    