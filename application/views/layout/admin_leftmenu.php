<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200">
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"></div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>


            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
            <li class="nav-item start <?php if (trim($pageName) == 'Operation_Manager_List') { ?>active open<?php } ?>">
                    <a href="<?php echo __BASE_URL__; ?>/admin/operationManagerList" class="nav-link nav-toggle">
                        <i class="fa fa-male" aria-hidden="true"></i>
                        <span class="title">Operation Manager</span>
                        <span class="selected"></span>
                    </a>
            </li>
            <li class="nav-item start <?php if (trim($pageName) == 'Region_Manager_List') { ?>active open<?php } ?>">
                    <a href="<?php echo __BASE_URL__; ?>/admin/regionManagerList" class="nav-link nav-toggle">
                        <i class="fa fa-flag" aria-hidden="true"></i>
                        <span class="title">Region List</span>
                        <span class="selected"></span>
                    </a>
                </li>
            <li class="nav-item start <?php if (trim($pageName) == 'Franchisee_List') { ?>active open<?php } ?>">
                    <a href="<?php echo __BASE_URL__; ?>/admin/franchiseeList" class="nav-link nav-toggle">
                        <i class="fa fa-bank" aria-hidden="true"></i>
                        <span class="title">Franchisees</span>
                        <span class="selected"></span>
                    </a>
                </li>
            <?php } ?>
             <?php if ($_SESSION['drugsafe_user']['iRole'] == 5) { ?>    
               <li class="nav-item start <?php if (trim($pageName) == 'Franchisee_List') { ?>active open<?php } ?>">
                    <a href="<?php echo __BASE_URL__; ?>/admin/franchiseeList" class="nav-link nav-toggle">
                        <i class="fa fa-bank" aria-hidden="true"></i>
                        <span class="title">Franchisees</span>
                        <span class="selected"></span>
                    </a>
                </li>
              <?php } ?>   
            <li class="nav-item start <?php if (trim($pageName) == 'Client_Record') { ?>active open<?php } ?>">
               <?php  if ($_SESSION['drugsafe_user']['iRole'] == '1' ||$_SESSION['drugsafe_user']['iRole'] == '5') { ?>
                 <a href="<?php echo __BASE_URL__; ?>/franchisee/franchiseeClientRecord" class="nav-link nav-toggle">
                     <i class="fa fa-users" aria-hidden="true"></i>
                    <span class="title">Client Record</span>
                    <span class="selected"></span>
                </a>
               <?php } elseif ($_SESSION['drugsafe_user']['iRole'] == 2) { ?>    
                     <a href="<?php echo __BASE_URL__; ?>/franchisee/clientRecord" class="nav-link nav-toggle">
                         <i class="fa fa-users" aria-hidden="true"></i>
                    <span class="title">Client Record</span>
                    <span class="selected"></span>
                </a>
                      <?php   } else { ?>
                 <a href="<?php echo __BASE_URL__; ?>/formManagement/view_form_for_client" class="nav-link nav-toggle">
                         <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title">SOS-COC Form</span>
                    <span class="selected"></span>
                </a>
                      <?php   }?>       
            </li>
           <?php
            if ($_SESSION['drugsafe_user']['iRole'] == 2 ) { ?>
                <li class="nav-item start <?php if (trim($pageName) == 'Agent_Record') { ?>active open<?php } ?>">
                <a href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord" class="nav-link nav-toggle">
                     <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span class="title">Agent Record</span>
                    <span class="selected"></span>
                </a>
            </li>
          
                
                
              
            <?php }  if ($_SESSION['drugsafe_user']['iRole'] == 1 ) { ?>
             <li class="nav-item start <?php if (trim($pageName) == 'Agent_Record') { ?>active open<?php } ?>">
                <a href="<?php echo __BASE_URL__; ?>/franchisee/viewAgentEmpByfranchisee" class="nav-link nav-toggle">
                     <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span class="title">Agent Record</span>
                    <span class="selected"></span>
                </a>
            </li>
             <?php }  ?>
           
               <?php   if ($_SESSION['drugsafe_user']['iRole'] == '2') {?>
                  <li class="nav-item start <?php if (trim($pageName) == 'Prospect_Record') { ?>active open<?php } ?>">
                      <a href="<?php echo __BASE_URL__; ?>/prospect/prospectRecord" class="nav-link nav-toggle">
                     <i class="fa fa-files-o" aria-hidden="true"></i>
                    <span class="title">Sales CRM</span>
                    <span class="selected"></span>
                </a>

               
            </li>
               <?php   } ?>
        <?php if ($_SESSION['drugsafe_user']['iRole'] == 1 ) { ?>
            <li class="nav-item start <?php if (trim($pageName) == 'Inventory') { ?>active open<?php } ?>">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-cubes" aria-hidden="true"></i>
                    <span class="title">Inventory </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" <?php if ($subpageName == 'Inventory') { ?> style="display: block;" <?php } ?> >
                    <li class="nav-item  <?php if ($subpageName == 'Drug_Test_Kit_List') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/inventory/drugtestkitlist">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Drug Test Kit List</span>
                        </a>
                    </li>

                    <li class="nav-item  <?php if ($subpageName == 'Marketing_Material_List') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/inventory/marketingmateriallist">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Marketing Material List</span>
                        </a>
                    </li>
                    <li class="nav-item  <?php if ($subpageName == 'Consumables_List') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/inventory/consumableslist">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Consumables List</span>
                        </a>
                    </li>


                </ul>

            </li>
           <?php } ?>
            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1 ||$_SESSION['drugsafe_user']['iRole'] == 5  ) { ?>
                <!--<li class="nav-item  <?php /*if ($pageName == 'Stock_Request') { */?> active open <?php /*} */?>">
                    <a class="nav-link " href="<?php /*echo __BASE_URL__; */?>/stock_management/stockreqlist">
                        <i class="fa fa-mail-forward" aria-hidden="true"></i>
                        <span class="title">Stock Request</span>-->
                        <!-- BEGIN NOTIFICATION  -->

                        <!--<span class="badge badge-danger"><?php /*echo $notification; */?></span>

                    </a>-->
                    <!-- END NOTIFICATION  -->


<!--                </li>-->
                <li class="nav-item start <?php if (trim($pageName) == 'Reporting') { ?>active open<?php } ?>">
                    <a href="javascript:void(0);" class="nav-link nav-toggle">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <span class="title">Reporting </span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" <?php if ($subpageName == 'Reporting') { ?> style="display: block;" <?php } ?> >
                        <!--<li class="nav-item  <?php /*if ($subpageName == 'All_Stock_Requests') { */?> active open <?php /*} */?>">
                           <a class="nav-link nav-toggle"  onclick="viewstockreqlistData('1');" href="javascript:void(0);">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">All Stock Requests</span>
                            </a>
                        </li>

                        <li class="nav-item  <?php /*if ($subpageName == 'Stock_Assignments') { */?> active open <?php /*} */?>">
                           <a class="nav-link nav-toggle"  onclick="viewStockAssignList('1');" href="javascript:void(0);">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Stock Assignments</span>
                            </a>
                        </li>-->
                        
            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                        <li class="nav-item  <?php if ($subpageName == 'fr_stock_qty_report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/view_fr_stock_qty_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Franchisee Stock Qty Report</span>
                            </a>
                        </li>
                          <?php } ?>
			<li class="nav-item  <?php if ($subpageName == 'industry_report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/view_industry_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Industry Report</span>
                            </a>
                        </li>
                        <?php  if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                        <li class="nav-item  <?php if ($subpageName == 'Inventory_Report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/inventoryReport">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Inventory Report</span>
                            </a>
                        </li>
                        <?php }  ?>
                         <li class="nav-item  <?php if ($subpageName == 'Client_Comparison_Report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/clientcomparisonReport">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Client Comparison</span>
                            </a>
                        </li>
                        <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                        <li class="nav-item  <?php if ($subpageName == 'Orders_Report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/order/view_order_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Orders Report</span>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item  <?php if ($subpageName == 'revenue_generate') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/view_revenue_generate">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Revenue Generate</span>
                            </a>
                        </li>
                         <li class="nav-item  <?php if ($subpageName == 'revenue_summery') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/view_revenue_summery">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Revenue Summary Franchisee</span>
                            </a>
                        </li>
                    
                        <li class="nav-item  <?php if ($subpageName == 'revenue_summery_client') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/view_revenue_summery_client">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Revenue Summary Client</span>
                            </a>
                        </li>
                  
                        <li class="nav-item  <?php if ($subpageName == 'Sales_CRM_Summary') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/prospect/prospect_summary_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Sales CRM Summary  </span>
                            </a>
                        </li>
                     <li class="nav-item  <?php if ($subpageName == 'Sales_CRM_Detailed') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__;?>/prospect/sales_crm_detailed_report">
                               <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Sales CRM Detailed</span>
                            </a>
                        </li>
                        <li class="nav-item  <?php if ($subpageName == 'SOS_COC_Forms_Reports') { ?> active open <?php } ?>">
                            <a class="nav-link " onclick="viewForm('1');" href="javascript:void(0);">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">SOS-COC Forms Reports</span>
                            </a>
                        </li>
<!--                         <li class="nav-item  <?php if ($subpageName == 'View_Order_Report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/viewOrderReport">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">View Order Report</span>
                            </a>
                        </li>-->
<!--                         <li class="nav-item  <?php if ($subpageName == 'Xero') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/xero">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Xero</span>
                            </a>
                        </li>-->

                    </ul>

                </li>
            <?php }
             if ($_SESSION['drugsafe_user']['iRole'] == 2 ) { ?>
                  <li class="nav-item start <?php if (trim($pageName) == 'Reporting') { ?>active open<?php } ?>">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                    <span class="title">Reporting </span>
                    <span class="arrow"></span>
                </a>
                    
                <ul class="sub-menu" <?php if ($subpageName == 'Reporting') { ?> style="display: block;" <?php } ?> >
                     <li class="nav-item  <?php if ($subpageName == 'Orders_Report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/order/view_order_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Orders Report</span>
                            </a>
                        </li>
                    <li class="nav-item  <?php if ($subpageName == 'revenue_generate') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/franchisee_revenue_generate">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Revenue Generate</span>
                            </a>
                        </li>
                        <li class="nav-item  <?php if ($subpageName == 'revenue_summery_client') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/view_revenue_summery_client">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Revenue Summary Client</span>
                            </a>
                        </li>
                    <li class="nav-item  <?php if ($subpageName == 'Client_Comparison_Report') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/clientcomparisonReport">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Client Comparison</span>
                        </a>
                    </li>
                    <li class="nav-item  <?php if ($subpageName == 'Inventory_Report') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/reporting/frInventoryReport">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Inventory Ordered </span>
                            </a>
                   </li>
                    <li class="nav-item  <?php if ($subpageName == 'Sales_CRM_Summary') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__; ?>/prospect/prospect_summary_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Sales CRM Summary  </span>
                            </a>
                        </li>
                     <li class="nav-item  <?php if ($subpageName == 'Sales_CRM_Detailed') { ?> active open <?php } ?>">
                            <a class="nav-link " href="<?php echo __BASE_URL__;?>/prospect/sales_crm_detailed_report">
                                <i class="fa fa-ge" aria-hidden="true"></i>
                                <span class="title">Sales CRM Detailed</span>
                            </a>
                        </li>
                    <li class="nav-item  <?php if ($subpageName == 'SOS_COC_Forms_Reports') { ?> active open <?php } ?>">
                        <a class="nav-link " onclick="viewForm('1');" href="javascript:void(0);">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">SOS-COC Forms Reports</span>
                        </a>
                    </li>

                </ul>

            </li>
                
                
              
            <?php } ?>
                  <!--<li class="nav-item start <?php /*if (trim($pageName) == 'Form_Management') { */?>active open<?php /*} */?>">
                    <a onclick="viewForm('1');" href="javascript:void(0);" class="nav-link nav-toggle">
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <span class="title">Form Management</span>
                        <span class="selected"></span>
                    </a>
                </li>-->
               
   
             <?php if ($_SESSION['drugsafe_user']['iRole'] == 1 || $_SESSION['drugsafe_user']['iRole'] == 2 || $_SESSION['drugsafe_user']['iRole'] == 5) { ?>

               <li class="nav-item start <?php if (trim($pageName) == 'proforma_invoice') { ?>active open<?php } ?>">
                   <a href="<?php echo __BASE_URL__; ?>/ordering/sitesRecord" class="nav-link nav-toggle">
                       <i class="fa fa-file-text" aria-hidden="true"></i>
                       <span class="title">Proforma Invoice </span>
                       <span class="arrow"></span>
                   </a>
                   <ul class="sub-menu" <?php if ($subpageName == 'proforma_invoice') { ?> style="display: block;" <?php } ?> >
                    <li class="nav-item  <?php if ($subpageName == 'view_proforma_invoice') { ?> active open <?php } ?>">
                        <a href="<?php echo __BASE_URL__; ?>/ordering/sitesRecord" class="nav-link nav-toggle">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">View Proforma Invoice </span>
                        </a>
                    </li>
                            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1 ) { ?>
                            <li class="nav-item  <?php if ($subpageName == 'discount_percentage') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/ordering/discountPercentage">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Discount Percentage</span>
                        </a>
                    </li>
                            <?php } ?>
                    </ul>
                   
               </li>


           <?php } ?>
                <?php if ($_SESSION['drugsafe_user']['iRole'] == 2) { ?>
            <li class="nav-item start <?php if (trim($pageName) == 'Inventory') { ?>active open<?php } ?>">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                    <span class="title">Inventory </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" <?php if ($subpageName == 'Inventory') { ?> style="display: block;" <?php } ?> >
                    <li class="nav-item  <?php if ($subpageName == 'Drug_Test_Kit') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/order/drugtestkit">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Drug Test Kit </span>
                        </a>
                    </li>

                    <li class="nav-item  <?php if ($subpageName == 'Marketing_Material') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/order/marketingmaterial">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Marketing Material </span>
                        </a>
                    </li>
                    <li class="nav-item  <?php if ($subpageName == 'Consumables') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/order/consumables">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">Consumables </span>
                        </a>
                    </li>


                </ul>

            </li>
           <?php } if (($_SESSION['drugsafe_user']['iRole'] == 1)|| ($_SESSION['drugsafe_user']['iRole'] == 2)) { ?>
            <li class="nav-item start <?php if (trim($pageName) == 'Orders') { ?>active open<?php } ?>">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                    <span class="title">Manage Order </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" <?php if ($subpageName == 'Orders') { ?> style="display: block;" <?php } ?> >
                    <li class="nav-item  <?php if ($subpageName == 'View_Order_List') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/order/view_order_list">
                            <i class="fa fa-ge" aria-hidden="true"></i>
                            <span class="title">View Order List</span>
                        </a>
                    </li>

                </ul>

            </li>
           <?php } ?>
                <?php if (($_SESSION['drugsafe_user']['iRole'] == 1 ) || ($_SESSION['drugsafe_user']['iRole'] == 2 ) || ($_SESSION['drugsafe_user']['iRole'] == 5 )) { ?> 
             <li class="nav-item start <?php if (trim($pageName) == 'Forum') { ?>active open<?php } ?>">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    <span class="title">Forum </span>
                    <?php if($commentnotification > '0' && $_SESSION['drugsafe_user']['iRole'] == 1){?><span class="badge badge-danger"><?php echo $commentnotification; ?></span><?php } ?>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" <?php if ($subpageName == 'Forum') { ?> style="display: block;" <?php } ?> >
                   

                      <li class="nav-item  <?php if ($subpageName == 'Categories') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/forum/categoriesList">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            <span class="title">Categories List</span>
                        </a>
                    </li>
                      <?php if ($_SESSION['drugsafe_user']['iRole'] == 1 ) { ?>
                     <li class="nav-item  <?php if ($subpageName == 'Topic Approval') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/forum/approvallist">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                            <span class="title"> Approval</span>
                            <?php if($commentnotification > '0'){?><span class="badge badge-danger"><?php echo $commentnotification; ?></span><?php } ?>
                        </a>
                    </li>
                     <li class="nav-item  <?php if ($subpageName == 'Send Notification') { ?> active open <?php } ?>">
                        <a class="nav-link " href="<?php echo __BASE_URL__; ?>/forum/sendEmail">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                            <span class="title"> Send Notification</span>
                           
                        </a>
                    </li>
                  <?php }?> 
                </ul>

            </li>  
                <?php } ?>
        </ul>
    </div>

</div>
