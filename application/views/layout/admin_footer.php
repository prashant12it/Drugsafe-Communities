</div>
<!--END PAGE CONTAINER-->
<!-- BEGIN COPYRIGHT -->
        <div class="page-footer">
            <div class="page-footer-inner"> <?php echo date('Y');?> &copy; Drug-Safe Communities. All rights reserved. <a href="<?php echo __BASE_URL__?>/Quality-Policy.pdf" target="_blank">Quality Policy</a> | <a href="<?php echo __BASE_URL__?>/Terms-and-Conditions.pdf" target="_blank">Terms & Conditions</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>

    <!-- END COPYRIGHT -->
    
    
    
      <!--CUSTOM JS-->
       
        <script src="<?php echo __BASE_JS_URL__;?>/jquery.form.js" rel="jquery" type="text/javascript"></script>
       <script src="<?php echo __BASE_JS_URL__;?>/drugsafeFunctions.js?<?php echo time(); ?>" rel="jquery" type="text/javascript"></script>
        <script src="<?php echo __BASE_JS_URL__;?>/validate.js?<?php echo time(); ?>" rel="jquery" type="text/javascript"></script>
        
		<script type="text/javascript">

            validate_form_fields();
//            autoSaveHandler();

        </script>
        <!--END CUSTOM JS-->
        
         <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src='<?php echo __BASE_ASSETS_URL__; ?>/customselect/src/jquery-customselect.js'></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__; ?>/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
       
            
           <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo __BASE_ASSETS_URL__;?>/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <!--<script src="<?php echo __BASE_ASSETS_URL__;?>/pages/scripts/dashboard.min.js" type="text/javascript"></script>-->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo __BASE_ASSETS_URL__;?>/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__;?>/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo __BASE_ASSETS_URL__;?>/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>


        <link href="<?php echo __BASE_CSS_URL__; ?>/uploadfilemulti.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo __BASE_JS_URL__; ?>/jquery.fileuploadmulti.min.js"></script>
<script type="text/javascript" src="<?php echo __BASE_JS_URL__; ?>/highcharts.js"></script>
<script type="text/javascript" src="<?php echo __BASE_JS_URL__; ?>/highcharts-3d.js"></script>
<script type="text/javascript" src="<?php echo __BASE_JS_URL__; ?>/exporting.js"></script>
<script src="<?php echo __BASE_ASSETS_URL__;?>/pages/scripts/components-pickers.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <!--<link href="http://hayageek.github.io/jQuery-Upload-File/4.0.10/uploadfile.css" rel="stylesheet">
        <script src="http://hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js"></script>-->
<script type="text/javascript">
    jQuery(document).ready(function(){
        Metronic.init();
            ComponentsPickers.init();
    });
    jQuery('.timepicker').timepicker({
        defaultTime: false,
        minuteStep: 1,
        showSeconds: true,
        secondStep: 1,
        showInputs: false
    });

    var error;
    $('input[type=submit]').on('click', function(){
        error = 0;

        $("input, select, textarea").focus(function() {
            if(error === 0){
                error = 1

                var target = $(this).offset().top;
                var header = $('.page-header').height();

                $(window).scrollTop( target - (header + 10) )
            }
        });
    });
    $('.dropdown').on('click tap', function() {
        $(this).toggleClass("open");
    });
	
</script>
    </body>
</html>