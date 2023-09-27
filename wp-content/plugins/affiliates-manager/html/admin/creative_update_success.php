
<div class="wrap">

	<h2><?php echo $this->viewData['request']['action'] === 'edit' ? __( 'Edit', 'affiliates-manager' ) : __( 'New', 'affiliates-manager' ) ?> <?php _e( 'Campaign', 'affiliates-manager' ) ?></h2>

	<h3>
		<?php
			if ($this->viewData['request']['action'] === 'edit') {
				_e( 'Campaign updated.', 'affiliates-manager' );
			} else if ($this->viewData['request']['action'] === 'new') {
				_e( 'New Campaign created.  This Campaign is not yet active.', 'affiliates-manager' );
			} 
		?>
	</h3>

	<a href="<?php echo admin_url( 'admin.php?page=wpam-creatives' ) ?>"><?php _e( 'Return to Campaigns', 'affiliates-manager' ) ?></a>

</div>