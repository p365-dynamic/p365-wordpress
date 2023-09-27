<?php
    //display My Affiliates menu
    $wpam_plugin_tabs = array(
        'wpam-affiliates' => __('Affiliate Details', 'affiliates-manager'),
        'wpam-affiliates&tab=export_data' => __('Export Data', 'affiliates-manager')
    );
    
    echo '<div class="wrap"><h1>'.__('My Affiliates', 'affiliates-manager').'</h1>'; 
    
    if(isset($_GET['page'])){
        $current = $_GET['page'];
        if(isset($_GET['action'])){
            $current .= "&action=".$_GET['action'];
        }
    }

    // if(isset($_POST['report_export'])){

    //     }

    $content = '';
    $content .= '<h2 class="nav-tab-wrapper">';
    foreach($wpam_plugin_tabs as $location => $tabname)
    {
        if($current == $location){
            $class = ' nav-tab-active';
        } else{
            $class = '';    
        }
        $content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
    }
    $content .= '</h2>';
    echo $content;
    echo '<div id="poststuff"><div id="post-body">';
    if(isset($_GET['tab']))
    { 
        switch ($_GET['tab'])
        {
           case 'export_data':
               wpam_my_affiliates_export();
               break;
        }
    }
    else
    {
        wpam_my_affiliates_list();
    }

    echo '</div></div>';
    echo '</div>';

    function wpam_my_affiliates_list()
    {
        
        $status_array = array(
            'all_active' => __('All Active', 'affiliates-manager'),
            'all' => __('All (Including Closed)', 'affiliates-manager'),
            'active' => __('Active', 'affiliates-manager'),
            // 'applied' => __('Applied', 'affiliates-manager'),
            'approved' => __('Approved', 'affiliates-manager'),
            // 'confirmed' => __('Confirmed', 'affiliates-manager'),
            // 'declined' => __('Declined', 'affiliates-manager'),
            'blocked' => __('Blocked', 'affiliates-manager'),
            'inactive' => __('Inactive', 'affiliates-manager')
        );
        $current_class = "";
        if (isset($_REQUEST['statusFilter'])) {
            $status_text = esc_sql($_REQUEST['statusFilter']);
            if (!empty($status_text)) {
                $current_class = $status_text;
            }
        }
        ?>

        <ul class="subsubsub"> 
            <?php
            $count = 1;
            foreach ($status_array as $key => $status) {
                ?>
                <li><a href="admin.php?page=wpam-affiliates&statusFilter=<?php echo $key; ?>"<?php echo ($current_class == $key) ? ' class="current"' : ''; ?>><?php echo $status; ?></a><?php echo ($count == 9) ? '' : ' |'; ?></li>
                <?php
                $count = $count + 1;
            }
            ?>
        </ul>
        <!--<div id="poststuff"><div id="post-body">-->
                <?php
                include_once(WPAM_BASE_DIRECTORY . '/classes/ListAffiliatesTable.php');
                //Create an instance of our package class...
                $affiliates_list_table = new WPAM_List_Affiliates_Table();
                //Fetch, prepare, sort, and filter our data...
                $affiliates_list_table->prepare_items();
                ?>
                <!--        
                <style type="text/css">
                    .column-affiliateId {width:6%;}
                    .column-status {width:6%;}
                    .column-balance {width:6%;}
                    .column-earnings {width:6%;}
                    .column-firstName {width:6%;}
                    .column-lastName {width:6%;}
                    .column-email {width:10%;}
                    .column-companyName {width:10%;}
                    .column-dateCreated {width:10%;}
                    .column-websiteUrl {width:10%;}
                </style>
                -->
                <div class="wpam-click-throughs">

                    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
                    <form id="wpam-click-throughs-filter" method="get">
                        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                        <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
                        <!-- Now we can render the completed list table -->
                        <?php $affiliates_list_table->display() ?>
                    </form>

                </div>
        <?php
    }
    
    function wpam_my_affiliates_export()
    {
// //         $url = "http://uatcrm.policies365.com/service/v4_1/rest.php";
//         $username = "leadpush";
//         $password = "308973632c20b57f30e89dfcf1c21e04";
        
//         $parameters = array(
//             "user_auth" => array(
//             "user_name" => $username,
//             "password" => $password,
//             "version" => "1"
//             ),
//             "application_name" => "test",
//             "name_value_list" => array(),
//             );
//         $jsonEncodedData = json_encode($parameters);

// $post = array(
// "method" => 'login',
// "input_type" => "JSON",
// "response_type" => "JSON",
// "rest_data" => $jsonEncodedData
// );

// $args = array(
//                 'method' => 'POST',
//                 'timeout' => 45,
//     	        'redirection' => 5,
//                 'httpversion' => '1.0',
//                 'headers' => array(),
//     	        'blocking' => true,
//                 'sslverify' => false,
//                 'body' => $post,
//                 'cookies' => array()
// );
// $response = wp_remote_post( 'http://uatcrm.policies365.com/service/v4_1/rest.php', $args);
// //print_r($response['body']);
// //$resp = explode("\r\n\r\n", $response, 2);
// $resp1 = json_decode($response['body']);
// $linkid = $resp1->id;
// $replink='http://uatcrm.policies365.com/index.php?entryPoint=newview&date=2018-07-10&getReport=1&MSID='.$linkid;

// // $replink = wp_remote_post( $replink, $args);
// // print_r($replink);

// // if ( is_array( $result ) ) {
// //   //$header = $response['headers']; // array of http header lines
// //   //$body = $response['body']; // use the content
// // }

// $url = $replink;//your url will come here
// $fp = fopen ('report.pdf', 'w+');
// $ch = curl_init(str_replace(" ","%20",$url));
// curl_setopt($ch, CURLOPT_TIMEOUT, 100);
// curl_setopt($ch, CURLOPT_FILE, $fp); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// curl_exec($ch); 
// curl_close($ch);
// fclose($fp);

    ?>  
        
<script>

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
            var today = "notrequired";
            var rangeflag = '';
            var fromval = '';
            var toval = '';

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
            url:     ajaxurl,
            data:{
            action:  'make_booking',
            type: valdata,
            datedata: today,
            rangeflag:rangeflag,
            fromr:fromval,
            tor:toval,
            affiliateid:'none'
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
        
        <div class="postbox">
        <h3 class="hndle"><label for="title"><?php _e('Export Affiliates Record', 'affiliates-manager'); ?></label></h3>
            <div class="inside">
            <form method="POST">
                <?php wp_nonce_field('wpam-export-affiliates-to-csv-nonce'); ?>
                <p>
                    <input type="submit" name="wpam-export-affiliates-to-csv" value="<?php _e('Export to CSV', 'affiliates-manager') ?>" class="button-primary"/>
                </p>
            </form>
            </div>
        </div>

        <div class="postbox">
        <h3 class="hndle"><label for="title"><?php _e('Download affiliates Data', 'affiliates-manager'); ?></label></h3>
        <div class="inside">
        <form>
        <p>
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
        <option value="dispositionrep">Disposition</option>
        <option value="newview">Daily Report</option>
        <option value="dailyactivity">Daily Activity</option>
        <option value="affiliate">Affiliate</option>
        <option value="policy">Policies</option>    
    </select>
        <span style="display:inline-block;"><img src="http://p365dev.infintus.com/media/2018/09/demo_wait.gif" height="20" width="20" id="load-ajax" style="display:none;"></span>
        <span  id="feedback" style="display:inline-block;"></span>
        </form>
    </p>

        </div>
        </div>
        <?php        
    }
    
