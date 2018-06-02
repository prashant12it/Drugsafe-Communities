<script type='text/javascript'>
    $(function() {
//        $("#szSearch").customselect();
        $("#szSearchname").customselect();
        $("#szSearchProductCode").customselect();

    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo __BASE_URL__; ?>/reporting/allstockreqlist">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                    <li>
                        <span class="active">All Stock Request List</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">All Stock Request List</span>
                        </div>
                        <?php
                        if (!empty($allReqQtyAray)) {

                            ?>

                            <div class="actions">
                               
                                     <a onclick="ReqReportingPdf('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                               
                                <a onclick="stockreqexcellist('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                            </div>
                            <?php
                        }
                        ?>

                    </div>

                    <?php

                    if (!empty($allReqQtyAray)) {

                        ?>
                        <div class="row">
                            <form class="form-horizontal" id="szSearchQtyReqList"
                                  action="<?= __BASE_URL__ ?>/reporting/allstockreqlist " name="szSearchQtyReqList"
                                  method="post">
<!--                                <div class="search col-md-3">
                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="<?//=sanitize_post_field_value($_POST['szSearch'])?>">
                              <select class="form-control custom-select" name="szSearch1" id="szSearch" onfocus="remove_formError(this.id,'true')">
                                  <option value="">Franchisee Id</option>
                                  <?php
                                      foreach($allQtyRequestListAray as $allQtyRequestListItem)
                                      {
                                          $selected = ($allQtyRequestListItem['iFranchiseeId'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                          echo '<option value="'.$allQtyRequestListItem['iFranchiseeId'].'" >FR-'.$allQtyRequestListItem['iFranchiseeId'].'</option>';
                                      }
                                  ?>
                              </select>
                          </div>
                                  <div class="col-md-1" style="text-align: center; padding: 5px 0px;">OR</div>-->
<!--                           <!--<button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>-->
                                  <div class="search col-md-3">
                                      <!--                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="--><?/*//=sanitize_post_field_value($_POST['szSearch'])*/?><!--">-->
                                      <select class="form-control custom-select" name="szSearch2" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          
                                        
                                          <option value="">Franchisee Name</option>
                                          <?php 
                                          foreach($allQtyRequestListAray as $allQtyRequestListItem)
                                          {
                                              $selected = ($allQtyRequestListItem['szName'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$allQtyRequestListItem['szName'].'"' . $selected . ' >'.$allQtyRequestListItem['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>
                               <div class="col-md-1" style="text-align: center; padding: 5px 0px;"></div>
                                  <div class="search col-md-3">
                                      <!--                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="--><?//=sanitize_post_field_value($_POST['szSearch'])?><!--">-->
                                      <select class="form-control custom-select" name="szSearch" id="szSearchProductCode" onfocus="remove_formError(this.id,'true')">
                                         
                                        
                                          <option value="">Product Code</option>
                                          <?php 
                                          foreach($allQtyProductRequestListAray as $allQtyProductRequestListItem)
                                          {
                                              $selected = ($allQtyProductRequestListItem['szProductCode'] == $_POST['szSearch'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$allQtyProductRequestListItem['szProductCode'].'" ' . $selected . '>'.$allQtyProductRequestListItem['szProductCode'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-1">
                                  <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>

                                        <th> Id</th>
                                        <th> Franchisee</th>
                                        <th> Product Code</th>
                                        <th> Quantity Request</th>
                                        <th> Requested On</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($allReqQtyAray) {
                                        $i = 0;

                                        foreach ($allReqQtyAray as $allReqQtyData) {
                                            ?>
                                            <tr>
                                                <td> FR-<?php echo $allReqQtyData['iFranchiseeId']; ?> </td>
                                                <td> <?php echo $allReqQtyData['szName'] ?> </td>
                                                <td> <?php echo $allReqQtyData['szProductCode']; ?> </td>
                                                <td> <?php echo $allReqQtyData['szQuantity']; ?> </td>
                                                <td> <?php echo date('d/m/Y h:i:s A', strtotime($allReqQtyData['dtRequestedOn'])) ?>  </td>


                                            </tr>
                                            <?php
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        $i++;
                    } else {
                        echo "Not Found";
                    }
                    ?>
                    <?php if (!empty($allReqQtyAray)) { ?>
                        <div class="row">

                            <div class="col-md-7 col-sm-7">
                                <div class="dataTables_paginate paging_bootstrap_full_number">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>
                            </div>


                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>