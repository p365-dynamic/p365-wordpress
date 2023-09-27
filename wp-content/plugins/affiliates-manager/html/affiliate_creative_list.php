<div class="aff-wrap">
    <?php
    include WPAM_BASE_DIRECTORY . "/html/affiliate_cp_nav.php";
    /** better method but currently does not work
    global $wpdb;
    $currentUser = wp_get_current_user();
    $user_id = $currentUser->ID;
    $table_name = WPAM_AFFILIATES_TBL;
    $affiliate = $wpdb->get_row("SELECT * FROM $table_name WHERE userId = '$user_id' AND status = 'active'");
    $record_found = true;
    if(!$affiliate){
        $record_found = false;
    }
    $table_name = WPAM_CREATIVES_TBL;
    $default_creative_id = get_option(WPAM_PluginConfig::$DefaultCreativeId);
    $creative = '';
    if(empty($default_creative_id)){
        $record_found = false;
    }
    else{
        $creative = $wpdb->get_row("SELECT * FROM $table_name WHERE creativeId = '$default_creative_id'");
        if(!$creative){
            $record_found = false;
        }
    }
    $alink = '';
    $alink_id = '';
    $alink_email = '';
    if($record_found){
        $aid = $affiliate->affiliateId;
        $alink_id = add_query_arg( array( WPAM_PluginConfig::$RefKey => $aid ), home_url('/') );
        $aemail = $affiliate->email;
        $alink_email = add_query_arg( array( WPAM_PluginConfig::$RefKey => $aemail ), home_url('/') );
        $trackingKey = new WPAM_Tracking_TrackingKey();
        $trackingKey->setAffiliateRefKey($affiliate->uniqueRefKey);
        $trackingKey->setCreativeId($creative->creativeId);
        $alink = add_query_arg( array( WPAM_PluginConfig::$RefKey => $trackingKey->pack() ), home_url('/') );
    }
    ****/
    $db = new WPAM_Data_DataAccess();
    $currentUser = wp_get_current_user();
    $alink_id = '';
    $affiliateRepos = $db->getAffiliateRepository();
    $affiliate = $affiliateRepos->loadBy(array('userId' => $currentUser->ID, 'status' => 'active'));
    if ( $affiliate === NULL ) {  //affiliate with this WP User ID does not exist

    }
    else{
        $home_url = home_url('/');
        $aff_landing_page = get_option(WPAM_PluginConfig::$AffLandingPageURL);
        if(isset($aff_landing_page) && !empty($aff_landing_page)){
            $home_url = $aff_landing_page;
        }
        $alink_id = add_query_arg( array( WPAM_PluginConfig::$wpam_id => $affiliate->affiliateId ), $home_url );
    }
    ?>
<script type="text/javascript">
function copyaffLink() {
    var copyText = document.getElementById("Afflink");
    copyText.select();
    document.execCommand("copy");2
   
  }
jQuery(document).ready(function(){
    $('.copyLink').click(function(){
        var $tempElement = $("<input>");
        $("body").append($tempElement);
        $tempElement.val($(this).closest('tr').find('.campaignLink').text()).select();
        document.execCommand("Copy");
        $tempElement.remove();
        $('<span> Copied!</span>').insertAfter($(this).closest('tr').find('.copyLink')).delay(3000).fadeOut();
  
  });
})
$(document).on('mouseenter',".campaignLink" ,function() {
        var $this = $(this);
     if (this.offsetWidth < this.scrollWidth && !$this.attr('title')) {
         $this.tooltip({
             title: $this.text(),
             placement: "right"
         });
         $this.tooltip('show');
     }
 
     }); 

    
</script>
    <div>
        <?php
        if(!empty($alink_id)){
           // print_r($currentUser->ID);
        ?>
        
       
        <?php
        }
        ?>
       
        <?php 
        		$campaignLinks = get_user_meta($currentUser->ID, 'campaignsid', true);
                $campaignLinks = explode(',',$campaignLinks);
        ?>
        
    </div>

    <div class="container">
    <div class="row">
            <div class="col-md-10 col-xs-12">
                
                    <div class="col-md-10 col-xs-12" >
                        <div class="affIdHeading">What is Affiliate ID</div>
                            <div class="affdesc">Your affiliate ID is a unique number assigned to you when you set up your affiliate membership - note that this is separate from your customer account!
                                <input type="url" class="afflink" style="padding-top:0 !important;background:none !important;color:#636363 !important;" value="<?php echo $alink_id; ?>">
                            </div> 
                        </div>  


    <!-- <div class="col-md-10">
        
        <div class="col-md-12 gridbox campaignwhitebox">
            <div class="whitebox">
                  <div class="col-md-10"><span class="affiliateLink"><input type="text" id="Afflink" class="afflink" style="color:#2991ea !important;" value="<?php echo $alink_id; ?>"></span></div>
                  <div class="col-md-2" style="margin-top:40px;"><span><i class="fa fa-copy" onclick="copyaffLink()"></i></span></div>
        </div>
            
    </div> -->
       
        
        </div>
        
    </div>

<div class="row">
        <div class="col-md-12" >
                <div class="campaignHeading">The following Campaigns are available</div>
         <div class="col-md-12 col-xs-12 aff_camp_cont">
              
                <table class="pure-table table-hover table-responsive-shubham">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Link</th>
                            <th>Copy Link</th>
                            <th>Visitors</th>
                            <th>Sales</th>
                            <th>Premium</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $mydb = new wpdb('root','my$ql@07','devcrm79','192.168.0.20:3306');
                        $rows = $mydb->get_results("select * from campaigns");
                        $mydb = new wpdb('p365dev','Infintus@321','aff_data','192.168.0.200:3306');
                        $rows_visit = $mydb->get_row("select * from aff_camp_visits where affiliateId = $affiliate->affiliateId");
                        $mydb = new wpdb('p365dev','Infintus@321','aff_data','192.168.0.200:3306');
                        $rows_sales = $mydb->get_row("select * from aff_sales where affiliateId = $affiliate->affiliateId");
                        $mydb = new wpdb('p365dev','Infintus@321','aff_data','192.168.0.200:3306');
                        $rows_premium = $mydb->get_row("select * from aff_premium where affiliateId = $affiliate->affiliateId");
                        
                        // print_r($rows);
                        ?>
                        <?php foreach ($rows as $camp) { ?>
                        <?php if(in_array($camp->id, $campaignLinks)){ $cid = $camp->id?>

                                <!-- <?php if($creative->name != 'default creative'){ ?> -->
                                <tr>
                                 <td><?php echo $camp->name ?></td>
                                 <td><label class="campaignLink hidetxt"><?php echo get_home_url().'/?campaign_id='.$camp->id.'&wpam_id='.$affiliate->affiliateId; ?></label></td>
                                 <td><i style="cursor: pointer" class="fa fa-copy copyLink"></i></td>
                                 <td><?php echo $rows_visit->$cid ?></td>
                                 <td><?php echo $rows_sales->$cid ?></td>
                                 <td><?php echo $rows_premium->$cid ?></td>
                                 <td class="<?php if($camp->status == 'Active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $camp->status ?></td>
                                </tr>
                        <!-- <?php }?> -->
                             <?php }?>
                         <?php } ?>
                        </tbody>
                      </table>
       
                    </div>
        </div>
         
    </div>
</div>
</div>
<!-- <div style="background:#f5f6fa;color#f2f2f2;text-align:center;font-size:16px;width:100%;bottom:0;position:absolute">All Rights Reserved. Infintus Innovations Pvt Ltd</div> -->


</div>
