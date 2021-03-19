<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!-- META SECTION -->
    <title>ZingHR</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- END META SECTION -->
    <!-- CSS INCLUDE -->
    <link rel="stylesheet" href="layout/assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="layout/assets/fonts/zing-icon-font/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="layout/assets/css/zing-theme.css">
    <link rel="stylesheet" href="layout/assets/css/custom-lms.css">

    <link rel="stylesheet" href="layout/assets/css/chart.min.css">
    <style>
        .header-bg{
          background-image: url(../layout/assets/images/vector.svg);
          background-repeat: no-repeat;
          background-position:top center;
          background-attachment: fixed;
        }
        #Body .bg-black{
          background-color: #000000;
        }
    </style>

</head>
<body id="Body" class="header-bg ilearn-home ilearn-dashboard">
<header>
        <nav style="background-color: white;">
            <div class="top-head py-sm-4 py-4">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-5 col-lg-3 col-xl-4">
                            <a class="navbar-brand ml-0 mr-0" href="#" id="brand_logo">
                                <!-- <img src="../my/layout/assets/images/logo.svg" width="220" class="d-inline-block align-top" style="max-width: 180px;width: 100%" alt="Company Logo"> -->
                            </a>
                            <input type="hidden" value="<?php echo $CFG->wwwroot?>" id="cfg_wwwroot"/>
                            <input type="hidden" value="<?php echo $USER->employee_code?>" id="user_employeecode"/>
                            <input type="hidden" value="<?php echo $USER->company_code?>" id="user_companycode"/>
                        </div>
                        <div class="col-7 col-lg-9 col-xl-8 mob-rht-hamburg text-right">
                            <button class="navbar-toggler border-0" type="button">
                                <span class="position-absolute d-block rounded"></span>
                                <span class="position-absolute d-block rounded"></span>
                                <span class="position-absolute d-block rounded"></span>
                            </button>
                            <ul class="rht-side-iconbox mb-0">
                                <!-- <li class="d-inline-block pr-3 align-middle">
                                    <a href="#" class="col-black">
                                        <i class="icon icon-home"></i>
                                    </a>
                                </li>
                                <li class="d-inline-block pr-3 align-middle">
                                    <a class="nav-link dropdown-toggle change-language p-0 pl-2 col-black" href="#" id="changeLanguage" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="../my/layout/assets/images/icon-english.svg" alt="" style="width: 26px;">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm language-dropdown" aria-labelledby="changeLanguage">
                                        <a class="dropdown-item" href="#">Language 1</a>
                                        <a class="dropdown-item" href="#">Language 2</a>
                                    </div>
                                </li> -->
                                 <?php
                                if(is_siteadmin())
                                {?>
                                    <li class="d-inline-block pr-3 align-middle">
                                    <a href="<?php echo $CFG->wwwroot.'/admin/search.php'?>" class="col-black">
                                        <i class="icon icon-setting"></i>
                                    </a>
                                    </li>
                                <?php
                                }
                                ?>
                                
                                <!-- <li class="d-inline-block pr-3 align-middle">
                                    <a href="#" class="col-black">
                                        <i class="icon icon-notification"></i>
                                    </a>
                                </li> -->
                                <li class="d-inline-block align-middle">
                                    <a class="nav-link dropdown-toggle my-profile p-0 pl-2 col-black" href="#" id="myProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php 
                                                global $USER,$PAGE; 
                                                $user_picture=new user_picture($USER);
                                                $src=$user_picture->get_url($PAGE);
                                             //  echo $src;die;
                                                
                                        ?>
                                        <img src="<?php echo $src; ?>" alt="avtar" class="mr-1 avtar"><span class="align-middle"><?php echo  $USER->firstname." ".$USER->lastname ?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="myProfile">
                                        <a class="dropdown-item" href="<?php echo $CFG->wwwroot."/user/profile.php?id=" ?><?php echo $USER->id; ?>">Profile</a>
                                        <a class="dropdown-item" href="<?php echo $CFG->wwwroot.'/login/logout.php'?>">Logout</a>
                                        <div class="dropdown-divider"></div>
                                        <?php
                                        if(is_siteadmin())
                                        {?>
                                            <a class="dropdown-item" href="<?php echo $CFG->wwwroot."/course/switchrole.php?id=1&switchrole=-1&returnurl=%2Fmessage%2Foutput%2Fpopup%2Fnotifications.php%3Fid%3D0" ?>">Switch role to...</a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bott-head bg-black">
                <div class="container">
                    <div class="row">
                        <ul class="col-md-12 mb-0">
                            <li class="nav-item d-lg-inline-block">
                                <a class="nav-link text-white p-lg-3 p-2 pl-lg-0 position-relative active" href="#">MY DASHBOARD</a>
                            </li>
                            <li class="nav-item d-lg-inline-block">
                                <a class="nav-link text-white p-lg-3 p-2 position-relative " href="<?php echo $CFG->wwwroot.'/calendar/view.php?view=month'?>">CALENDAR</a>
                            </li>
                            <li class="nav-item d-lg-inline-block">
                                <a class="nav-link text-white p-lg-3 p-2 position-relative " href="<?php echo $CFG->wwwroot.'/user/files.php'?>">PRIVATE FILES</a>
                            </li>
                            <!-- <li class="nav-item d-lg-inline-block">
                                <a class="nav-link text-white p-lg-3 p-2  position-relative" href="<?php echo $CFG->wwwroot.'/my'?>">MY COURSES</a>
                            </li> -->
                             <?php
                            if(is_siteadmin())
                            {?>
                                <li class="nav-item d-lg-inline-block">
                                <a class="nav-link text-white p-lg-3 p-2  position-relative" href="<?php echo $CFG->wwwroot;?>/customconfig/cohort/attribute/v1/dynamic_cohort.php">DYNAMIC COHORT</a>
                                </li>
                                <li class="nav-item d-lg-inline-block">
                                    <a class="nav-link text-white p-lg-3 p-2  position-relative" href="<?php echo $CFG->wwwroot;?>/mod/zingilt/resourcemgmt/index.php">RESOURCE MANAGEMENT</a>
                                </li>
                                <li class="nav-item d-lg-inline-block position-relative ">
                                <a class="nav-link text-white p-lg-3 p-2" href="<?php echo $CFG->wwwroot.'/admin/search.php'?>">SITE ADMINISTRATION</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <div class="col-md-12 mob-shownav text-center py-3" style="display: none;">
                            <div class="row">
                                <ul class="col-md-12 px-0 mob-shownav text-center">
                                    <li class="d-inline-block pr-3 align-middle">
                                        <a href="#" class="text-white">
                                            <i class="icon icon-home"></i>
                                        </a>
                                    </li>
                                    <li class="d-inline-block pr-3 align-middle">
                                        <a class="nav-link dropdown-toggle change-language p-0 pl-2 text-white" href="#" id="changeLanguage" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="../my/layout/assets/images/icon-english-white.svg" alt="" style="width: 26px;">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right language-dropdown" aria-labelledby="changeLanguage ">
                                            <a class="dropdown-item" href="#">Language 1</a>
                                            <a class="dropdown-item" href="#">Language 2</a>
                                        </div>
                                    </li>
                                    <li class="d-inline-block pr-3 align-middle">
                                        <a href="#" class="text-white">
                                            <i class="icon icon-setting"></i>
                                        </a>
                                    </li>
                                    <li class="d-inline-block pr-3 align-middle">
                                        <a href="#" class="text-white">
                                            <i class="icon icon-notification"></i>
                                        </a>
                                    </li>
                                    <li class="d-inline-block align-middle">
                                        <a class="nav-link dropdown-toggle my-profile p-0 pl-2 text-white" href="#" id="myProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="../my/layout/assets/images/user9.png" alt="avtar" class="mr-1 avtar"><span class="align-middle">Steve Rogers</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="myProfile">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
</header>