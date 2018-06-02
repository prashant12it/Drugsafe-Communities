<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Client List</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm blue" onclick="addClientData(<?php echo $idfranchisee;?>);" href="javascript:void(0);">
                                        &nbsp;Add New Client
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                        
                        if(!empty($clientAry))
                        {
                           
                            ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Id.</th>
                                        <th> Name</th>
                                        <th> Email</th>
                                        <th> Client Type</th>
                                        <th> Contact No </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($clientAry as $clientData)
                                        {
                                            $i++;
                                        ?>
                                        <tr>
                                            <td> CL-<?php echo $clientData['id'];?> </td>
                                            <td> <?php echo $clientData['szName']?> </td>
                                            <td> <?php echo $clientData['szEmail'];?> </td>
                                            <td>
                                                
                                                <?php
                                                if($clientData['clientType']=='0')
                                                {
                                                    echo "Parent";
                                                }
                                                else
                                                {
                                                    echo "Child";
                                                }
                                                ?>
                                                
                                            </td>
                                            <td> <?php echo $clientData['szContactNumber'];?> </td>
                                            <td>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Client Data" onclick="editClient('<?php echo $clientData['id'];?>');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="View Client Details" onclick="viewClientDetails(<?php echo $clientData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-eye" aria-hidden="true"></i>

                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="Delete Client" onclick="clientDelete(<?php echo $clientData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>

                                                </a>
                                                
                                               
                                            </td>
                                        </tr>
                                        <?php 
                                        }
                                   ?>
                                </tbody>
                            </table>
                        </div>
                             <?php
                            
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                        
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div id="popup_box"></div>