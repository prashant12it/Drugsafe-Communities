
<!DOCTYPE html>
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8">
          <title><?php echo ($szMetaTagTitle != '' ? "$szMetaTagTitle" : "Drug Safe");?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        
       <!-- BEGIN PAGE LEVEL PLUGINS -->
<!--        <link href="--><?php //echo __BASE_ASSETS_URL__; ?><!--/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<!--        <link href="--><?php //echo __BASE_ASSETS_URL__; ?><!--/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?php /*echo __BASE_ASSETS_URL__; */?>/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?php /*echo __BASE_ASSETS_URL__; */?>/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php /*echo __BASE_ASSETS_URL__; */?>/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />-->
<!--        <link href="--><?php //echo __BASE_ASSETS_URL__; ?><!--/pages/css/profile.min.css" rel="stylesheet" type="text/css" />-->
        <!-- END PAGE LEVEL PLUGINS -->
        
<!-- BEGIN THEME GLOBAL STYLES -->
            <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
            <link href="<?php echo __BASE_ASSETS_URL__; ?>/global/css/plugins.css" rel="stylesheet" type="text/css" />
<!--            <link href="--><?php //echo __BASE_ASSETS_URL__; ?><!--/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />-->
<!-- END THEME GLOBAL STYLES -->
        
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>   
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/layouts/layout4/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo __BASE_ASSETS_URL__; ?>/layouts/layout4/css/custom.css" rel="stylesheet" type="text/css" />
        <link href='<?php echo __BASE_ASSETS_URL__; ?>/customselect/src/jquery-customselect.css' rel='stylesheet' />
        <!-- END THEME LAYOUT STYLES -->
        
        <link rel="shortcut icon" href="favicon.ico" />
        <!-- END HEAD -->
        
        <!--BEGIN CUSTOM FILES-->
        <link href="<?php echo __BASE_CSS_URL__; ?>/drugsafe_custom_style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo __BASE_CSS_URL__; ?>/prashant.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo __BASE_JS_URL__; ?>/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo __BASE_ASSETS_URL__; ?>/jquery.min.js"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script type="text/javascript">
            var __BASE_URL__ = '<?php echo __BASE_URL__;?>';
            var AUTO_SAVE = false;
        </script> 
          
    </head>
    <!-- END HEAD -->
    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
        <!-- BEGIN HEADER -->
        <div id="loader"></div>
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                     <a href="<?php echo __BASE_URL__;?>/admin/" class="nav-link nav-toggle">
<!--                        <h1 alt="logo" class="logo-default" >Drug Safe</h1> </a>-->
                         <img class="admin-logo" src="<?php echo __BASE_URL__;?>/images/logo.png" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN PAGE ACTIONS -->
                <!-- DOC: Remove "hide" class to enable the page header actions -->
               
                <!-- END PAGE ACTIONS -->
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <div class="top-menu">
                         <?php 
                            if((int)$_SESSION['drugsafe_user']['id'] >0)
                            {
                                
                                $szImage = __BASE_IMAGES_URL__."/default_profile_image.jpg";
                                 
                            }
                         ?>
                        <ul class="nav navbar-nav pull-right">
                            <li class="separator hide"> </li>
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            
                           
                            <li class="separator hide"> </li>
                            
                            
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                  <span class="username username-hide-on-mobile">Hi! <?php echo $_SESSION['drugsafe_user']['szName'];?></span>
                                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                    <img alt="" class="img-circle" src="<?php echo $szImage;?>" /> </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    
                                    <li>
                                        <a href="<?php echo __BASE_URL__;?>/admin/changePassword">
                                            <i class="icon-key"></i>Change Password </a>
                                    </li>
                                   
                                    <li>
                                        <a href="<?php echo __BASE_URL__;?>/admin/logout">
                                            <i class="fa fa-power-off"></i> Log Out </a>
                                    </li>
                                    
                                    
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                           
                        </ul>
                         
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <div class="clearfix"></div>
        <div class="page-container">
        <?php $this->view('layout/admin_leftmenu.php'); ?>