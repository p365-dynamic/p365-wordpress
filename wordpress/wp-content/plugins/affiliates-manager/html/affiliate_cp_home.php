<div class="aff-wrap">
    <?php
    include WPAM_BASE_DIRECTORY . "/html/affiliate_cp_nav.php";
    $currentUser = wp_get_current_user();
    $db1 = new WPAM_Data_DataAccess();
    $affiliateRepos = $db1->getAffiliateRepository();
    $affiliate = $affiliateRepos->loadBy(array('userId' => $currentUser->ID, 'status' => 'active'));
    $affiliateID = $affiliate->affiliateId;
    
     $header = array(
        "header" => array(	"deviceId" => $affiliateID,
        "transactionName" => "fetchAffiliate"),
        "body"=> array("action"=>"FETCH", 
        "deviceId"=>$affiliateID)
	 );
	 $jsonEncodedheader = json_encode($header);

    // $jsonEncodedbody = json_encode($body);

$args = array(
 			'method' => 'POST',
			'timeout' => 45,
			 'redirection' => 5,
			 'httpversion' => '1.0',
			'headers' => array("Content-type" =>"application/json;charset=UTF-8"),
			// 'blocking' => true,
			// 'sslverify' => false,
			'body' => $jsonEncodedheader,
			'cookies' => array()
);

$response = wp_remote_post( 'http://192.168.0.10:8181/cxf/authrestservices/integrate/invoke', $args);
$resp1 = json_decode($response['body']);
//print_r($response);
$resp1 = json_decode($resp1);
//print_r($resp1->data);
// print_r($resp1->data->name);

//for update

// {"header": {"deviceId":"<affiliateID>", "transactionName":"updateAffiliate"}, "body":{"action":"UPDATE", "source": "<affiliateSource>", "deviceId": <affiliateID>, "leadCount": 0, "noOfPolicies": 0, "isActive": "Y", "name": "", "description": "", "campaignId": "", "affilateURL": "", "affilateUser": false, "redirectToAffilateScreen": false }}
?>
    <div class="wrap mainBackground">
    <div class="row">
        <div class="col-md-6 padLR" >
         <div class="col-md-12 gridbox">
            <div class="col-md-4  whitebox separator">
                    <div class="boximage"><img src="http://p365dev.infintus.com/media/2018/10/1.png"/></div>
                    <div class="labelheading">Earnings</div>
            </div>
            <div class="col-md-8 whitebox" style="display:flex;">
                <div class="col-md-6" style="align-self:center;">
                        <div class="labeltxt"><h4 class="text-success"><?php echo wpam_format_money(abs($this->viewData['accountDebits'])); ?></h4></div>
                        <div class="labeltxt">Paid</div>
                </div>
                <div class="col-md-6" style="align-self:center;">
                        <div class="labeltxt"><h4 class="text-danger"><?php echo wpam_format_money($this->viewData['accountStanding']); ?></h4></div>
                        <div class="labeltxt">Unpaid</div>
                </div>
            </div>
        </div>

        <style>
        /* Style for the Earings tab */

        h4.text-danger span.positiveMoney {
            color: #a94442;
        }
        h4.text-success span.positiveMoney {
            color: #3c763d;
        }
        </style>

        <div class="clearfix"></div>
        
        </div>

        <div class="col-md-6 padLR">
                <div class="col-md-12  gridbox">
                <div class="col-md-4  whitebox separator">
                        <div class="boximage"><img src="http://p365dev.infintus.com/media/2018/10/2.png"/></div>
                        <div class="labelheading" >Today</div>
                </div>
                <div class="col-md-8 whitebox" style="display:flex;">
                    <div class="col-md-4" style="align-self:center;">
                            <div class="labeltxt"><h4><?php echo $this->viewData['todayVisitors'] ?></h4></div>
                            <div class="labeltxt">Visitors</div>
                    </div>
                    <div class="col-md-4" style="align-self:center;">
                            <div class="labeltxt"><h4><?php echo $this->viewData['todayClosedTransactions'] ?></h4></div>
                            <div class="labeltxt">Sales</div>
                    </div>
                    <div class="col-md-4" style="align-self:center;">
                            <div class="labeltxt"><h4><?php echo $this->viewData['todayRevenue'] ?></h4></div>
                            <div class="labeltxt">Premium</div>
                    </div>
                </div>
            </div>
                <div class="clearfix"></div>
            
         </div>  
 
    </div>

    <div class="row">
    <div class="col-md-6 padLR">
                    <div class="col-md-12  gridbox">
                    <div class="col-md-4  whitebox separator">
                            <div class="boximage"><img src="http://p365dev.infintus.com/media/2018/10/3.png"/></div>
                            <div class="labelheading" >This Month</div>
                    </div>
                    <div class="col-md-8 whitebox" style="display:flex;">
                        <div class="col-md-4" style="align-self:center;">
                                <div class="labeltxt"><h4><?php echo $this->viewData['monthVisitors'] ?></h4></div>
                                <div class="labeltxt">Visitors</div>
                        </div>
                        <div class="col-md-4" style="align-self:center;">
                                <div class="labeltxt"><h4><?php echo $this->viewData['monthClosedTransactions'] ?></h4></div>
                                <div class="labeltxt">Sales</div>
                        </div>
                        <div class="col-md-4" style="align-self:center;">
                                <div class="labeltxt"><h4><?php echo ($this->viewData['monthRevenue']) ?></h4></div>
                                <div class="labeltxt">Premium</div>
                        </div>
                    </div>  
                    </div>
                    <div class="clearfix"></div>
     </div>
    <div class="col-md-6 padLR">
                <div class="col-md-12  gridbox">
                    <div class="col-md-4  whitebox separator">
                            <div class="boximage"><img src="http://p365dev.infintus.com/media/2018/10/4.png"/></div>
                            <div class="labelheading">This Year</div>
                    </div>
                    <div class="col-md-8 whitebox" style="display:flex;">
                        <div class="col-md-4" style="align-self:center;">
                                <div class="labeltxt"><h4><?php print_r($resp1->data->noOfPolicies); ?></h4></div>
                                <div class="labeltxt">Policies Converted</div>
                        </div>
                        <div class="col-md-4"  style="align-self:center;">
                                <div class="labeltxt"><h4><?php print_r($resp1->data->leadCount); ?></h4></div>
                                <div class="labeltxt">Total Leads</div>
                        </div>
                        <div class="col-md-4" style="align-self:center;">
                                <div class="labeltxt"><h4><?php echo ($this->viewData['monthRevenue']) ?></h4></div>
                                <div class="labeltxt">Premium</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

           
            
    </div>
    
          
    <div class="row">
            <div class="col-md-12 padLR">
                    <div class="col-md-12  gridbox">
                        <div class="col-md-2  whitebox separator">
                                <div class="boximage"><img src="http://p365dev.infintus.com/media/2018/10/5.png"/></div>
                                <div class="labelheading">Download Report</div>
                        </div>
                    <div class="col-md-10 whitebox">
                        <form style="width:100%">
                            <div class="col-md-2" style="align-self:center">
                                        <div>Desired Timeline</div>
                                        <select  class="form-control" id="drop_timeline" name="drop_timeline" onChange="timeSelect()">
                                                <option value="today">Today</option>
                                                <option value="date">Date</option>
                                                <option value="range">Period</option>
                                        </select>                                  
                            </div>
                            <div id="dateselect" class="col-md-2" style="display:none;align-self:center">
                            <label for="repodate">Date</label>
                            <input class="form-control" type="date" id="repodate" onChange="resetrepo()"/>
                            </div>         
                            <div id="rangeselect" class="col-md-5" style="display:none;padding:0;align-self:center">
                            <div class="row">
                            <div class="col-md-6" style="padding-left:0;align-self:center">
                            <label for="datefrom">from</label>
                            <input class="form-control" type="date" id="datefrom" onChange="resetrepo()"/>
                            </div>
                            <div class="col-md-6" style="padding-right:0;align-self:center">
                            <label for="dateto">to</label>
                            <input class="form-control" type="date" id="dateto" onChange="resetrepo()"/>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-5" style="align-self:center">
                                    <div class="col-md-6" style="padding-left:0;align-self:center">
                                    <div>Report</div>
                                            <select class="form-control" id="dropdown-report" name="select" onChange="ajaxSubmit()">
                                                
                                                <option value="affiliate">Affiliate</option>
                                                <option value="policy">Policies</option>
                                            </select>
                                    </div> 
                                    <div  class="col-md-6" style="display:inline-block;padding-right:0;align-self:center">
                                   <img src="http://p365dev.infintus.com/media/2018/09/demo_wait.gif" height="20" width="20" id="load-ajax" style="display:none;"></span>
                                    <span  id="feedback" style="display:inline-block;"></div>            
                            </div>
                            
                            

                        </form>  
                    </div>
                    <div class="clearfix"></div>
            </div>
    </div>      
 
    <!-- <div style="background:#f5f6fa;color#f2f2f2;text-align:center;font-size:16px;width:100%;bottom:0;position:absolute">All Rights Reserved. Infintus Innovations Pvt Ltd</div> -->



        <!-- <table class="pure-table">
            <thead>
                <tr>
                    <th colspan="2"><?php _e('Account Summary', 'affiliates-manager') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php _e('Balance', 'affiliates-manager') ?></td>
                    <td><?php echo wpam_format_money($this->viewData['accountStanding']) ?></td>
                </tr>
                <tr>
                    <td><?php _e('Commission Rate', 'affiliates-manager') ?></td>
                    <td><?php echo $this->viewData['commissionRateString'] ?></td>
                </tr>
            </tbody>
        </table>

        <table class="pure-table">
            <thead>
                <tr>
                    <th colspan="2"><?php _e('Today', 'affiliates-manager') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="summaryPanel">
                            <?php if (get_option(WPAM_PluginConfig::$AffEnableImpressions)) { ?>
                                <div class="summaryPanelLine">
                                    <div class="summaryPanelLineValue"><?php echo $this->viewData['todayImpressions'] ?></div>
                                    <div class="summaryPanelLineLabel"><?php _e('Impressions', 'affiliates-manager') ?></div>
                                </div>
                            <?php } ?>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php echo $this->viewData['todayVisitors'] ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Visitors', 'affiliates-manager') ?></div>
                            </div>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php echo $this->viewData['todayClosedTransactions'] ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Closed Transactions', 'affiliates-manager') ?></div>
                            </div>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php echo $this->viewData['todayRevenue'] ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Revenue', 'affiliates-manager') ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table class="pure-table">
            <thead>
                <tr>
                    <th colspan="2"><?php _e('This Month', 'affiliates-manager') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="summaryPanel">
                            <?php if (get_option(WPAM_PluginConfig::$AffEnableImpressions)) { ?>
                                <div class="summaryPanelLine">
                                    <div class="summaryPanelLineValue"><?php echo $this->viewData['monthImpressions'] ?></div>
                                    <div class="summaryPanelLineLabel"><?php _e('Impressions', 'affiliates-manager') ?></div>
                                </div>
                            <?php } ?>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php echo $this->viewData['monthVisitors'] ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Visitors', 'affiliates-manager') ?></div>
                            </div>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php echo $this->viewData['monthClosedTransactions'] ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Closed Transactions', 'affiliates-manager') ?></div>
                            </div>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php echo ($this->viewData['monthRevenue']) ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Revenue', 'affiliates-manager') ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table> -->
<script>
        jQuery(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    jQuery('#datefrom').attr('max', maxDate);
    jQuery('#repodate').attr('max', maxDate);
    jQuery('#dateto').attr('max', maxDate);
});
        function resetrepo(event){
            jQuery("#dropdown-report").val("empty");
        }
        function timeSelect(event){
            var droptime = jQuery("#drop_timeline").val();
            if(droptime == "date"){
            jQuery("#dateselect").css("display","inline-block");
            jQuery("#rangeselect").css("display","none");
            }
            else if(droptime == "range"){
            jQuery("#rangeselect").css("display","inline-block");
            jQuery("#dateselect").css("display","none"); 
            }
            else{
                jQuery("#dateselect").css("display","none"); 
                jQuery("#rangeselect").css("display","none");
            }
        }
        function ajaxSubmit(event) 
        {
            var affid = "<?php echo $affiliate->affiliateId?>";
            var today = "notrequired";
            var rangeflag = '';
            var fromval = '';
            var toval = '';
            var ajax_url = "<?php echo admin_url( 'admin-ajax.php' )?>";
            var droptime = jQuery("#drop_timeline").val();
        if(droptime==null || droptime =="today"){
            var today1 = new Date();
            var dd = today1.getDate();
            var mm = today1.getMonth()+1; 
            var yyyy = today1.getFullYear();
            if(dd<10) {
            dd = '0'+dd;
            } 
            if(mm<10) {
            mm = '0'+mm;
        } 
            today = yyyy + '-' + mm + '-' + dd;
        }else if(droptime=="date"){
            rangeflag = '0';
            today = jQuery("#repodate").val();
        }
        else if(droptime == "range"){
            rangeflag = '1';
            fromval = jQuery("#datefrom").val();
            toval = jQuery("#dateto").val();
        }

        jQuery("#load-ajax").css("display","block");
        jQuery("#feedback").css("display","none");
        var valdata = jQuery("#dropdown-report").val();
        console.log(valdata);
        jQuery.ajax({
            type:    "POST",
            url:     ajax_url,
            data:{
            action:  'make_booking',
            type: valdata,
            datedata: today,
            rangeflag:rangeflag,
            fromr:fromval,
            tor:toval,
            affiliateid:affid
            },
            success: function(response) {
                jQuery("#load-ajax").css("display","none");
                jQuery("#feedback").css("display","inline-block");
                jQuery("#feedback").html(response);
            }
        });
        return false;
        }
</script>
        <!-- <table class="pure-table">
            <thead>
                <tr>
                    <th colspan="2"><?php _e('Custom Report', 'affiliates-manager') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="summaryPanel">
                        <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php print_r($resp1->data->noOfPolicies); ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Policies Converted', 'affiliates-manager') ?></div>
                            </div>
                            <div class="summaryPanelLine">
                                <div class="summaryPanelLineValue"><?php print_r($resp1->data->leadCount); ?></div>
                                <div class="summaryPanelLineLabel"><?php _e('Total Leads', 'affiliates-manager') ?></div>
                            </div>
                            <div>
                                <div>Select Desired Timeline
                                <select id="drop_timeline" name="drop_timeline" onChange="timeSelect()">
                                <option value="today">Today</option>
                                <option value="date">Date</option>
                                <option value="range">Range</option>
                                </select>
        <span id="dateselect" style="display:none;"><label for="repodate">Date</label>
        <input type="date" id="repodate" onChange="resetrepo()"/></span>
        <span id="rangeselect" style="display:none;"><label for="datefrom">from</label>
        <input type="date" id="datefrom" onChange="resetrepo()"/>
        <label for="dateto">to</label>
        <input type="date" id="dateto" onChange="resetrepo()"/></span>
        <select id="dropdown-report" name="select" onChange="ajaxSubmit()">
        <option value="empty"></option>
        <option value="affiliate">Affiliate</option>
        <option value="policy">Policies</option>
        </select>
        <span style="display:inline-block;"><img src="http://p365dev.infintus.com/media/2018/09/demo_wait.gif" height="20" width="20" id="load-ajax" style="display:none;"></span>
        <span  id="feedback" style="display:inline-block;"></span>
                            </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table> -->

    </div>
    </div></div>


    