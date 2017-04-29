<link rel="stylesheet" href="<?= $assets; ?>style/font-awesome.css">

<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
    <?php 
    $i=0;
    
    foreach($package_titles as $pack) { 
        ?>
        <?php            
            if($i%3==0){
                echo '<div class="row">';
            }
        ?>
            <div class="col-md-4">
                <div class="panel panel-info">
          <div class="panel-heading">
            <h6 class="panel-title"><!--<i class="icon-thumbs-up3"></i>-->
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                <a href="trips?id=<?php echo $pack->id; ?>" style=" color:#000000"><strong><?php echo $pack->title_trip; ?></strong></a></h6>
          </div>
                  </div>
            </div>
            <?php            
            if($i%3==0){
                echo '</div>';
            }                                                                                                                                           
            $i++;
            ?>
        
        <?php
        }
        if(count($package_titles)<1){
        echo "<div class='row'>No Data Available</div>";
        
        }?>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
