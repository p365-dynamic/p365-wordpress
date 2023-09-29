<?php
/**
 * The template for displaying job content in list view within loops.
 *
 * Override this template by copying it to yourtheme/simple_job_board/content-job-listing-list-view.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/Templates
 * @version     2.0.0
 * @since       2.2.0
 * @since       2.2.3   Added @hook sjb_job_listing_heading_after.
 * @since       2.3.0   Added "sjb_list_view_template" filter.
 * @since       2.4.0   Revised whole HTML template
 */
// ob_start();
global $post;

/**
 * Fires before job listing on job listing page.
 * 
 * @since   2.2.0
 */
// do_action('sjb_job_listing_list_view_before');
 ?>

<!-- Start Jobs List View 
================================================== -->     
    
    <!-- Jobs List view header -->

    <div class="panel panel-default panel-job-desc">
    <div class="panel-heading job-list-head">
    <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $post->ID?>"><span class="glyphicon glyphicon-plus"></span>
        <?php the_title(); ?>
    </a>
    </h4>
    </div>
    <div id="collapse-<?php echo $post->ID?>" class="panel-collapse collapse collapsesign">
                    
    <div class="panel-body">
    <p>          

    <?php
    /**
     * Template -> Short Description:
     * 
     * - Job Description
     */
    //get_simple_job_board_template('listing/list-view/short-description.php');
    the_content();
    ?>
    </p>  
    <button type="button" class="btn btn-info btn-lg apply-now" data-toggle="modal" data-target="#myModal<?php echo $post->ID?>">Apply Now</button>

<div class="modal fade" id="myModal<?php echo $post->ID?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header custom-modal">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title job-app-modal">Want to connect with HR team?</h4>
        </div>
        <div class="modal-body">
            <?php do_action('sjb_single_job_listing_end');?>
        </div>
      </div>
      
    </div>
</div>    



    </div> 
    </div>
    </div>


<!-- ==================================================
End Jobs List View -->
<!-- Modal -->


