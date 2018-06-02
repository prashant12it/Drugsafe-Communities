<div class="page-content-wrapper">
        <div class="page-content">
             <?php
            if(!empty($_SESSION['drugsafe_user_message'])){
                if(trim($_SESSION['drugsafe_user_message']['type']) == "success"){
                    ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                    </div>
                <?php }
                if(trim($_SESSION['drugsafe_user_message']['type']) == "error") {
                    ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                    </div>
                <?php }
                $this->session->unset_userdata('drugsafe_user_message');
            }
            ?>
            
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                              <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        </li>
                        <li>
                            <i class="fa fa-circle"></i>
                            <span class="active">View Form</span>
                        </li>
                       
                    </ul>
     <div class="portlet light bordered about-text" id="user_info">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">
                 
                    <?php 
                       echo "View COC Form Details";
                    ?>
                 
                </span>
            </div>
            <div class="actions">
                <a onclick="ViewSosFormPdf(<?php echo  $idClient;?>,<?php echo $idsite;?>)" href="javascript:void(0);" 
                class=" btn green-meadow">
                 <i class="fa fa-file-pdf-o"></i> View Pdf </a>
             <a href="<?php echo __BASE_URL__; ?>/reporting/excelfr_stockassignlist"
                class=" btn green-meadow">
                 <i class="fa fa-file-excel-o"></i> View Xls </a>
               </div>
        </div>
         
          <?php
//        if(!empty($sosRormDetailsAry))
//        { 
            ?>
        <div class="portlet-body alert">
            <div class="row">
                  
                <div class="col-md-6 ">
                    <div class="font-green-meadow "><b>REQUESTING AUTHORITY</b></div>
                    <hr>
                     <div class="row">
                        <div class="col-sm-6 text-style bold ">
                           <lable>Collection / Screen Date:</lable>
                        </div>
                        <div class="col-sm-6">
                             <p><?php echo $cocFormDetailsAry['cocdate'];?></p>
                        </div>
                    </div>
                  <?php  $SosDetailBySosIdAry = $this->Form_Management_Model->getSosDetailBySosId($idsos);
                       $siteDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $SosDetailBySosIdAry['Clientid']);
                       $ClientDetArr1 = $this->Franchisee_Model->getClientTypeById($SosDetailBySosIdAry['Clientid']);
                       
                      $ClientDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $ClientDetArr1['clientType']);
                    ?>
                    <div class="row">
                         <div class="col-sm-6 text-style bold ">
                            <lable>Nominated Representative:</lable>
                        </div>
                        <div class="col-sm-6">
                            <p><?php echo $SosDetailBySosIdAry['ClientRepresentative'];?></p>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-sm-6 text-style bold ">
                            <lable>Client:</lable>
                        </div>
                        <div class="col-sm-6">
                          <p><?php echo $ClientDetArr['szName'];?></p>
                        </div>
                    </div>
                      <div class="row">
                         <div class="col-sm-6 text-style bold ">
                            <lable>Collection Site:</lable>
                        </div>
                        <div class="col-sm-6">
                          <p><?php echo $siteDetArr['szName'];?></p>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-sm-6 text-style bold ">
                            <lable>Drug to be tested:</lable>
                        </div>
                        <div class="col-sm-6">
                            <p><?php echo $cocFormDetailsAry['drugtest'];?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 bold font-green-meadow ">
                            <lable>Please Note:NATA/RCPA accreditation does not cover the performance of the breath test.</lable>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-md-6">
                      <div class=" ">
                    <div class="font-green-meadow text"><b>DONOR INFORMATION</b></div>
                    <hr>
                    <?php  $donarDetailByCocIdAry = $this->Form_Management_Model->getDonarDetailByCocId($idcoc);
                   
                    ?>
                    <div class="row">
                       <div class="col-sm-6 text-style bold ">
                            <lable>Name:</lable>
                        </div>
                        <div class="col-sm-6">
                            <p><?php echo $donarDetailByCocIdAry['donerName'];?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 text-style bold ">
                           
                        </div>
                        <div class="col-sm-8">
                           
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-sm-6 text-style bold ">
                            <lable>DOB:</lable>
                        </div>
                        <div class="col-sm-6">
                            <p><?php echo $cocFormDetailsAry['dob'];?></p>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-6 text-style bold ">
                            <lable>Employment Type :</lable> 
                        </div>
                        <div class="col-sm-3">
                           <p><?php echo $cocFormDetailsAry['employeetype'];?></p>
                        </div>
                       
                    </div>
                       <div class="row">
                        <div class="col-sm-6 text-style bold ">
                            <lable>Contractor Details:</lable>
                        </div>
                        <div class="col-sm-6">
                            <p><?php echo $cocFormDetailsAry['contractor'];?></p>
                        </div>
                    </div>
                       <div class="row">
                       <div class="col-sm-6 text-style bold ">
                            <lable>Id Type :</lable> 
                        </div>
                        <div class="col-sm-3">
                           <p><?php echo $cocFormDetailsAry['idtype'];?></p>
                        </div>
                       
                    </div>
                     <div class="row">
                       <div class="col-sm-6 text-style bold ">
                            <lable>Id No :</lable> 
                        </div>
                        <div class="col-sm-3">
                           <p><?php echo $cocFormDetailsAry['idnumber'];?></p>
                        </div>
                       
                    </div>
                     <div class="row">
                       <div class="col-sm-6 text-style bold ">
                            <lable>Donor Signature  :</lable> 
                        </div>
                        <div class="col-sm-3">
                           <p><?php echo $cocFormDetailsAry['donorsign'];?></p>
                        </div>
                       
                    </div>
                    
                </div>
              
             </div>
                </div>
                  <hr>
                
                 <div class="font-green-meadow text bold"> <H4>COLLECTION OF SAMPLE /ON-SITE DRUG SCREENING RESULTS </H4>
                 </div>
                 <hr>
                 
                  <div class="row">
                    <div class=" col-md-12 ">
                       <div class="bold col-md-2 ">
                          <lable>Void Time  :</lable>  
                        </div>
                         <div class="col-md-2">
                              
                            <p><?php echo $cocFormDetailsAry['voidtime'];?></p>
                        </div>
                        <div class="col-md-2 bold ">
                          <lable>Sample Temp :</lable>  
                        </div>
                         <div class="col-md-2">
                              
                             <p><?php echo $cocFormDetailsAry['sampletempc'];?></p>
                        </div>
                        <div class="bold col-md-3 ">
                          <lable>Temp Read Time within 4 min :</lable>  
                        </div>
                         <div class="col-md-1">
                              
                            <p><?php echo $cocFormDetailsAry['tempreadtime'];?></p>
                        </div>
                    </div> 
                 </div>
            
             <hr> <div class="row">
                    <div class="  col-md-12 ">
                       <div class="col-md-2 bold">
                          <lable>Intect 7 Lot No   :</lable>  
                        </div>
                         <div class="col-md-2">
                              
                            <p><?php echo $cocFormDetailsAry['intect'];?></p>
                        </div>
                        <div class="bold col-md-2 ">
                          <lable>Expiry :</lable>  
                        </div>
                         <div class="col-md-2">
                              
                            <p><?php echo $cocFormDetailsAry['intectexpiry'];?></p>
                        </div>
                        <div class="col-md-3 bold ">
                          <lable>Visual colour:</lable>  
                        </div>
                         <div class="col-md-1">
                              
                            <p><?php echo $cocFormDetailsAry['visualcolor'];?></p>
                        </div>
                    </div> 
                 </div>
             
                 <div class="row">
                    <div class="col-md-12 ">
                       <div class="bold col-md-2 ">
                          <lable>Creatinine:</lable>  
                        </div>
                         <div class="col-md-2">
                              
                           <p><?php echo $cocFormDetailsAry['creatinine'];?></p>
                        </div>
                        <div class="bold col-md-2 ">
                          <lable>Other Intigrity :</lable>  
                        </div>
                         <div class="col-md-2">
                              
                            <p><?php echo $cocFormDetailsAry['otherintegrity'];?></p>
                        </div>
                        <div class="bold col-md-3 ">
                          <lable>Hydration:</lable>  
                        </div>
                         <div class="col-md-1">
                              
                            <p><?php echo $cocFormDetailsAry['hudration'];?></p>
                        </div>
                    </div> 
                 </div>
            <hr>
            <div class="row">
                    <div class="  col-md-12 ">
                       <div class="  col-md-2 bold">
                          <lable>Device Name:</lable>  
                        </div>
                         <div class="col-md-1">
                              
                          <p><?php echo $cocFormDetailsAry['devicename'];?></p>
                        </div>
                        <div class="col-md-2 bold">
                          <lable>REF# :</lable>  
                        </div>
                       
                         <div class="col-md-1">
                              
                          <p><?php echo $cocFormDetailsAry['hudration'];?></p>
                        </div>
                         <div class="col-md-2 bold">
                          <lable>Lot#:</lable>  
                        </div>
                         <div class="col-md-1">
                              
                           <p><?php echo $cocFormDetailsAry['lotno'];?></p>
                        </div>
                        <div class="col-md-2 bold">
                          <lable>Expiry:</lable>  
                        </div>
                         
                         <div class="col-md-1">
                              
                           <p><?php echo $cocFormDetailsAry['lotexpiry'];?></p>
                        </div>
                    </div> 
                 </div>
            <hr>
              <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class=" text-info bold text" colspan="2"><h4>Drug Class</h4></th>
                                        <th class=" text-info bold" > Cocaine</th>
                                        <th class=" text-info bold" > Amp</th>
                                        <th class=" text-info bold"> mAmp</th>
                                        <th class=" text-info bold" > THC</th>
                                        <th class=" text-info bold" > Opiates</th>
                                        <th class=" text-info bold"> Benzo</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        <tr>
<!--                                            <th class=" text-info bold" style="width:160px"><p>* U = Result Requiring Further Testing N = Negative</p><p>** P = Positive N = Negative</p></th>-->
                                            <td class="bold"> Screenings Result  </td>
                                            
                                            
                                           
                                            <td> <p>N = Negative Result </p> <p>U = Further Testing Required</p></td>
                                            <td> <?php echo $cocFormDetailsAry['cocain'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['amp'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['mamp'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['thc'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['opiates'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['benzo'];?> </td>
                                            
                                              
                                        </tr>
                                        
                                       
                                      
                                </tbody>
                            </table>
                        </div>
                 </div>
            <hr>
                 <div class="font-green-meadow text bold"> <H4>DONOR DECLARATION</H4>
                 </div>
           <hr>
            <div class="row">
                        <div>
                            <p> I certify that the specimen(s) accompanying this inform is my own. Where on-site screening was performed ,such screening was carried out in </p>
                             <p> my presence . In the case of specimen(s) being sent to the laboratory for testing, I certify that the specimen containers were sealed with tamperevident</p>
                              <p> seals in  my presence and the indentifying information on the label is correct. I certify that the information provided on this form to be  correct and I  </p>
                             <p>consent to the release of all test results together with any relevant contained on this form to the nominated representative of the requesting authority. </p>
                        </div>
                        
                    </div>
           <hr>
                 <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-8 text-info bold">
                            <lable>Donor/Guardian Signature:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $cocFormDetailsAry['donorsign'];?></p>
                        </div>
                    </div>
                   
                   
                </div>
                <div class="col-md-6">
                   
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Date:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $cocFormDetailsAry['Refusals'];?></p>
                        </div>
                    </div>
                     </div>
                     </div>
                 <hr>
                 <div class="font-green-meadow text bold"> <H4>COLLECTOR CERTIFICATION</H4>
                 </div>
           <hr>
                    <div class="row">
                        <div>
                            <p> I certify that I witnessed the donor signature and that the  specimen(s) identified  on this form was provided to me by the donor whose consent and   </p>
                             <p> declaration appears above,bears the same donor identification as set forth above,and that the specimen(s) has been collected and if needed divided </p>
                              <p> labelled and sealed in accordance with the relevant Standard .</p>
                        </div>
                        
                    </div>
                  <hr>
                <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 text-info bold">
                            <lable>Collector1 Name/Number:</lable>
                        </div>
                        <div class="col-md-2">
                            <p><?php echo $cocFormDetailsAry['collectorone'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 text-info bold">
                            <lable> Signature:</lable>
                        </div>
                        <div class="col-md-2">
                            <p><?php echo $cocFormDetailsAry['collectorsignone'];?></p>
                        </div>
                    </div>
                   
                   
                </div>
                <div class="col-md-6">
                   
                    <div class="row">
                        <div class="col-md-6 text-info bold">
                            <lable>Collector2 Name/Number:</lable>
                        </div>
                        <div class="col-md-2">
                           <p><?php echo $cocFormDetailsAry['collectortwo'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 text-info bold">
                            <lable> Signature:</lable>
                        </div>
                        <div class="col-md-2">
                            <p><?php echo $cocFormDetailsAry['collectorsigntwo'];?></p>
                        </div>
                    </div>
                     </div>
                     </div>
                  <hr>
             <div class="row">
                        <div class="col-sm-5 text-info bold">
                            <lable>Comments /Observations:</lable>
                        </div>
                        <div class="col-sm-5">
                           <p><?php echo $cocFormDetailsAry['comments'];?></p>
                        </div>
                    </div>
     <hr>
      <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>On-Site Screening Report:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $cocFormDetailsAry['onsitescreeningrepo'];?></p>
                        </div>
                    </div>
     <hr>
     <div class="font-green-meadow text bold"> <H4>CHAIN OF CUSTODY</H4>
                 </div>
      
                      <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th >Received by(prints) </th>
                                        <th >Signature</th>
                                        <th >Date/Time Received</th>
                                        <th >Seat Intact</th>
                                        <th >Labels/Bar code match</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        <tr>
                                       
                                            <td> <?php echo $cocFormDetailsAry['receiverone'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receiveronesign'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receiveronetime'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receiveroneseal'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receiveronelabel'];?> </td>
                                            
                                              
                                        </tr>
                                        <tr>
                                       
                                            <td> <?php echo $cocFormDetailsAry['receivertwo'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receivertwosign'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receivertwotime'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receivertwoseal'];?> </td>
                                            <td> <?php echo $cocFormDetailsAry['receivertwolabel'];?> </td>
                                            
                                              
                                        </tr>
                                        
                                        
                                       
                                      
                                </tbody>
                            </table>
                        </div>
                 </div>
        </div>
          </div>
        </div>
     </div>
     </div>
    </div>
<div id="popup_box"></div>