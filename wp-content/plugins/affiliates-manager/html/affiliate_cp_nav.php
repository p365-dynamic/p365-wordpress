<nav class="aff_nav navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img class="alignleft size-full wp-image-2510"src="http://p365dev.infintus.com/media/2018/04/Policies365_Logo.png" alt="" width="125" height="40"></a>
      <a href="javascript:void(0);" class="icon topnav-icon" onclick="responsiveNav()"><i class="fa fa-bars"></i></a>
    </div>
    <div class="topnav" id="myTopnav">
    <ul class="nav navbar-nav">
	<?php 
    $sublink =  $_REQUEST['sub'];
    
    $homeurl = '/affiliate-home/index.php';                               
    $homepage = '/affiliate-home/';
    $currentpage = $_SERVER['REQUEST_URI'];
 
    foreach($this->viewData['navigation'] as $link) 
    { 
      list($linkText, $linkHref) = $link;
      if($linkText != "Edit Profile" && $linkText !="Log out")
      {
        // code for default index page 
        if($currentpage == $homepage or $currentpage == $homeurl) 
        { 
          if($linkText == "Overview" ) 
          { ?>
            <li class="active">
              <a href="<?php echo $linkHref?>">
                <?php {echo $linkText;}?>
              </a>
            </li>
          <?php
          }
          else
          { ?>
            <li>
              <a href="<?php echo $linkHref?>">
                <?php if($linkText != "Sales"){echo $linkText;}else{echo "Revenue History";}?>
              </a>
            </li>
          <?php 
          }
        }
        else
        {
          if(strpos($linkHref,$sublink)!==false)
          {  ?>
            <li class="active">
              <a href="<?php echo $linkHref?>">
                <?php if($linkText != "Sales" ){echo $linkText;}else{echo "Revenue History";}?>
              </a>
            </li>
          <?php 
          }
          else
          { ?>
            <li>
              <a href="<?php echo $linkHref?>">
                <?php if($linkText != "Sales" ){echo $linkText;}else{echo "Revenue History";}?>
              </a>
            </li>
          <?php 
          }
        }
      } 
    }
    ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://p365dev.infintus.com/affiliate-home/?sub=profile"><i class="fa fa-user"></i> Edit Profile</a></li>
      <li><a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>	
    </ul>

    </div>
  </div>
</nav>

<script>
function responsiveNav() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

<style>
li:hover {
  cursor: pointer;
}
.topnav-icon {
  display: none;

  font-size: 1.5em;
  padding-top: 1em;
  padding-bottom: 1em;

  padding-right: 15px;

  color: #2991ea;
}

@media screen and (max-width: 767px) {
  .navbar-header {
    padding-top: 0.8em;
    padding-bottom: 0.8em;
  }
  .topnav {
    display: none;
    overflow: hidden;
  }

  .topnav-icon {
    float: right;
    display: block;
  }

  .topnav.responsive {position: relative;}

  .topnav.responsive a.icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive{
    display: block;
    max-height:   0%;

    width: 100%;

    animation-name: slide;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
  }

  @-webkit-keyframes slide {
    0%   { max-height:   0%; }
    100% { max-height: 100%; }
  }
  @-moz-keyframes slide {
    0%   { max-height:   0%; }
    100% { max-height: 100%; }
  }
  @-o-keyframes slide {
    0%   { max-height:   0%; }
    100% { max-height: 100%; }
  }
  @keyframes slide {
    0%   { max-height:   0%; }
    100% { max-height: 100%; }
  }

}
</style>

	


<div id="aff-controls" class="pure-menu pure-menu-open pure-menu-horizontal wpam-nav-menu">
  <?php 
    $sublink =  $_REQUEST['sub'];
    foreach($this->viewData['navigation'] as $link) 
    { 
      list($linkText, $linkHref) = $link; 
      $linkslug = $link[1];
      if(strpos($linkslug,$sublink)!==false)
      {
        print_r($link[0]);
      }
      //print_r($link[1]);
		
    }
	
    //Script to set the default page title if its a index.php
    $homeurl = '/affiliate-home/index.php';                               
    $homepage = '/affiliate-home/';
    $currentpage = $_SERVER['REQUEST_URI'];
   
    if($currentpage == $homepage or $currentpage == $homeurl) 
    {
      echo 'Overview';
    } 
   
  ?>

</div>