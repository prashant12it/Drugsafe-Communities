<script type='text/javascript'>
    $(function() {
         $("#szSearchstate").customselect();
         $("#szSearchRegionName").customselect();
    });
</script>
<div class="page-content-wrapper">
        <div class="page-content">
                        <?php 
            if(!empty($_SESSION['drugsafe_user_message']))
            {
                    if(trim($_SESSION['drugsafe_user_message']['type']) == "success")
                    {
                    ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                        </div>
                    <?php
                    }
                    if(trim($_SESSION['drugsafe_user_message']['type']) == "error")
                    {
                    ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                        </div>
                    <?php
                    }
                    $this->session->unset_userdata('drugsafe_user_message');
            }
            ?>
            <ul class="page-breadcrumb breadcrumb">
             
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/admin/operationManagerList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                       
                        <li>
                            <span class="active">Region List</span>
                        </li>
     </ul>
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Region List</span>
                            </div>
                             <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>admin/addRegion');">
                                        &nbsp;Add New Region
                                    </button>
                                </div>
                            </div>
                        </div>
                         <div class=" search row">
                            <form class="search-bar" id="szSearchRegionRecord"
                                  action="<?= __BASE_URL__ ?>/admin/regionManagerList" name="szSearchRegionRecord"
                                  method="post">
                 
                                <div class="col-md-3">

                                    <select class="form-control custom-select" name="szSearchstate"
                                            id="szSearchstate" onblur="remove_formError(this.id,'true')"
                                            onchange="getRegionNameByState(this.value);">
                                        <option value="">State</option>

                                        <?php
                                     
                                        foreach ($getAllStatesAry as $getAllStates) {
                                            $selected = ($getAllStates['id'] == $_POST['szSearchstate'] ? 'selected="selected"' : '');
                                            echo '<option value="' . $getAllStates['id'] . '"' . $selected . ' >' . $getAllStates['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="search col-md-3 clienttypeselect">
                                     <div id='szRegion'>
                                        <div class="form-group <?php if (!empty($arErrorMessages['szSearchRegionName']) != '') { ?>has-error<?php } ?>">
                                            <select class="form-control custom-select" name="szSearchRegionName"
                                                id="szSearchRegionName" onfocus="remove_formError(this.id,'true')">
                                            <option value="">Region Name</option>
                                            <?php
                                            foreach ($regionListArray as $regionList) {
                                                $selected = ($regionList['regionName'] == $_POST['szSearchRegionName'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $regionList['regionName'] . '"' . $selected . ' >' . $regionList['regionName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        </div>
                                          </div>
                                    </div>
                               
                                <div class="col-md-1">
                                    <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            
                            </form>
                        </div>
                        <?php
                        
                        if(!empty($getAllRegion))
                        {
                           
                            ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Id.</th>
                                        <th> Region Name</th>
                                        <th> State</th>
                                        <th> Region Code</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($getAllRegion as $getAllRegionData)
                                        {
                                            $i++;
                                        ?>
                                        <tr>
                                            <td> <?php echo $i;?> </td>
                                            <td> <?php echo $getAllRegionData['regionName']?> </td>
                                            <td> <?php echo $getAllRegionData['name'];?> </td>
                                            <td> <?php echo $getAllRegionData['regionCode'];?> </td>
                                            <td>
                                                 <a class="btn btn-circle btn-icon-only btn-default" title="Edit Region Data" onclick="editRegionDetails('<?php echo $getAllRegionData['id'];?>');" href="javascript:void(0);">
                                                            <i class="fa fa-pencil"></i> 
                                                 </a>
                                                <?php
                                                if($getAllRegionData['assign']=='0')
                                                {
                                                    ?>
                                                       
                                                        <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="Delete Region" onclick="regionDelete(<?php echo $getAllRegionData['id'];?>);" href="javascript:void(0);"></i>
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                    
                                                }
                                                ?>
                                                
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