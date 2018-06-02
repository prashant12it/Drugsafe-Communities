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
                       echo "View SOS Form Details";
                    ?>
                 
                </span>
            </div>
            <div class="actions">
                <a onclick="ViewDonorDetails(<?php echo $idsite;?>)" href="javascript:void(0);" 
                  class=" btn green-meadow">
                 <i class="fa fa-eye"></i> View Donor Details</a>
                <a onclick="ViewSosFormPdf(<?php echo  $idClient;?>,<?php echo $idsite;?>)" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                <a href="<?php echo __BASE_URL__; ?>/reporting/excelfr_stockassignlist"
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                            </div>
        </div>
         
          <?php
        if(!empty($sosRormDetailsAry))
        { 
            ?>
        <div class="portlet-body alert">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Requesting Client :</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['szName'];?></p>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>City:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['szCity'];?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Country:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $sosRormDetailsAry['szCountry'];?></p>
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Drugtest:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $sosRormDetailsAry['szCity'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Service Commenced:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $sosRormDetailsAry['ServiceCommencedOn'];?></p>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Address:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['szAddress'];?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>State:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['szState'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>ZIP/Postal Code:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['szZipCode'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Service Concluded:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $sosRormDetailsAry['ServiceConcludedOn'];?></p>
                        </div>
                    </div>
                    
                </div>
              
             </div>
            <hr>
                    
                  <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class=" text-info bold" style="width:60px"> Emp/Con.</th>
                                        <th class=" text-info bold" style="width:120px"> Donor Name</th>
                                        <th class=" text-info bold" style="width:100px"> Result</th>
                                        <th class=" text-info bold" style="width:100px"> Drug </th>
                                        <th class=" text-info bold" style="width:100px"> Alcohol </th>
                                        <th class=" text-info bold" style="width:100px"> Lab </th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                    if ($sosRormDetailsAry) { 
                                      
                                       $donarDetailBySosIdAry = $this->Form_Management_Model->getDonarDetailBySosId($idsite);
                                       
                                       if(!empty($donarDetailBySosIdAry)){
                                       $i = 0;
                                       foreach($donarDetailBySosIdAry as $donarDetailBySosIdData){
                                           
                                       ?>
                                        <tr>
                                            <td><?php echo $donarDetailBySosIdData['id'];?> </td>
                                            <td> <?php echo $donarDetailBySosIdData['donerName'];?> </td>
                                            <td><?php if($donarDetailBySosIdData['result']==0)  echo "Negative";  else echo "Positive";?></td>
                                            <td> <?php  echo $donarDetailBySosIdData['drug'];?> </td>
                                            <td><?php if($donarDetailBySosIdData['alcohol']==0)  echo "Negative";  else echo "Positive";?></td>
                                            <td> <?php  echo $donarDetailBySosIdData['lab'];?> </td>
                                          
                                        </tr>
                                       <?php
                                       $i++;
                                        }
                                       }
                                       else{?>
                                        <tr>
                                              <td align="center" colspan="6">Not Found</td>
                                        </tr> 
                                        <?php
                                       }
                                    }
                                    else {
                        echo "Not Found";
                    }
                    
                                    ?>
                                </tbody>
                            </table>
                        </div>
                 </div>
            
             <hr>
              <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class=" text-info bold" style="width:160px"><p>* U = Result Requiring Further Testing N = Negative</p><p>** P = Positive N = Negative</p></th>
                                        <th class=" text-info bold" style="width:120px"> Urine</th>
                                        <th class=" text-info bold" style="width:100px"> Oral</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        <tr>
                                            <td class="bold">Total Donar Screenings/Collections </td>
                                            <td> <?php echo $sosRormDetailsAry['TotalDonarScreeningUrine'];?></td>
                                            <td> <?php echo $sosRormDetailsAry['TotalDonarScreeningOral'];?> </td>
                                        </tr>
                                         <tr>
                                            <td class="bold"> Negative Results</td>
                                            <td> <?php echo $sosRormDetailsAry['NegativeResultOral'];?> </td>
                                            <td> <?php echo $sosRormDetailsAry['NegativeResultOral'];?> </td>
                                        </tr>
                                         <tr>
                                            <td class="bold"> Result Requiring Further Testing </td>
                                            <td> <?php echo $sosRormDetailsAry['FurtherTestUrine'];?></td>
                                            <td> <?php echo $sosRormDetailsAry['FurtherTestOral'];?> </td>
                                        </tr>
                                      
                                </tbody>
                            </table>
                        </div>
                 </div>
             <hr>
                 <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Total No Alcohol Screens:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['TotalAlcoholScreening'];?></p>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Positive Alcohol Results:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['PositiveAlcohol'];?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Negative Alcohol Results:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['NegativeAlcohol'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Refusals , No Shows or Others:</lable>
                        </div>
                        <div class="col-sm-8">
                           <p><?php echo $sosRormDetailsAry['Refusals'];?></p>
                        </div>
                    </div>
                     </div>
                  
                </div>
              <hr>
              
              <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Device Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['DeviceName'];?></p>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Extra Used:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['ExtraUsed'];?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Breath Testing Unit:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['BreathTesting'];?></p>
                        </div>
                    </div>
                  
                     </div>
                  
                </div>
              <hr>
              <div class="row">
              <p>I/we <?php echo $sosRormDetailsAry['CollectorName'];?> conducted the alcohol and/or drugscreening/collection service detailed above and confirm that all procedures were undertaken in accordance with the relevant Standard.</p><div class="col-md-3"><h4 class="bold"> Collector Signature:</h4></div> <div class="info"><?php echo $sosRormDetailsAry['CollectorSignature'];?></div>
              </div>
              <hr>
              <div class="row">
               <div class="col-sm-4 text-info bold">
                 <lable>Comments Or Observation:</lable>
                </div>
                <div class="col-sm-8">
                    <p><?php echo $sosRormDetailsAry['Comments'];?></p>
                </div>
              </div>
              <hr>
               <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Nominated Client Representative:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['ClientRepresentative'];?></p>
                        </div>
                    </div>
                   
                   
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Signed:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['RepresentativeSignature'];?></p>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Time:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $sosRormDetailsAry['RepresentativeSignatureTime'];?></p>
                        </div>
                    </div>
                     </div>
                  
                </div>
              <div class="row">
               <div class="col-sm-2 text-info bold">
                            <lable>Status:</lable>
                        </div>
                        <div class="col-sm-4">
                            <p><?php if($sosRormDetailsAry['Status']==0)  echo "Not Completed";  else echo "Completed";?></p>
                        </div>    
             </div>
             </div>
        <?php  }else{
            echo"Not Found";
        }?>
        </div>
          </div>
        </div>
     </div>
     </div>
    </div>
<div id="popup_box"></div>