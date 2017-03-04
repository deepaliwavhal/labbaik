
<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">

        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("trips/add");?>
        
            
                <div class="form-group">
                    <label for="tour_name"><?= lang("Title"); ?></label>
                    <div class="controls"> <?= form_input('tour_name', '', 'class="form-control" id="tour_name"');?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tour_description"><?= lang("description"); ?></label>
                     <textarea class="form-control skip" id="tour_description" name="tour_description"></textarea>
                    
                </div> 
                <div class="form-group">
                    <label for="tour_price"><?= lang("price"); ?></label>
                    <div class="controls"> <?= form_input('tour_price', '', 'class="form-control" id="tour_price"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="tour_agent"><?= lang("Agent"); ?></label>
                    <div class="controls"> <?= form_input('tour_agent', '', 'class="form-control" id="tour_agent"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="tour_hotel"><?= lang("Hotel"); ?></label>
                    <div class="controls">
                        <?php
                        $hotels=array("1","2");
                        $hotel_list[""] = lang("select") . " " . lang("Hotel");
                        foreach ($hotels as $key=>$value) {
                            $hotel_list[$value] = $value;
                        }
echo form_dropdown('tour_hotel', $hotel_list, (isset($_POST['tour_hotel']) ? $_POST['tour_hotel'] : ""), 'class="form-control tour_hotel" data-placeholder="' . lang("select") . " " . lang("Hotel") . '" id="tour_hotel" style="width:100%;"');
                        ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label for="tour_airline"><?= lang("airline"); ?></label>
                    <div class="controls">
                        <?php
                        $airlines=array("1","2");
                        $airline_list[""] = lang("select") . " " . lang("airline");
                        foreach ($airlines as $key=>$value) {
                            $airline_list[$value] = $value;
                        }
echo form_dropdown('tour_airline', $airline_list, (isset($_POST['tour_airline']) ? $_POST['tour_airline'] : ""), 'class="form-control tour_airline" data-placeholder="' . lang("select") . " " . lang("airline") . '" id="tour_airline" style="width:100%;"');
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="tour_max_capacity"><?= lang("max_capacity"); ?></label>
                    <div class="controls"> <?= form_input('tour_max_capacity', '', 'class="form-control" id="tour_max_capacity"');?>
                    </div>
                </div> 
                
                <div class="form-group">
                    <label for="tour_city"><?= lang("city"); ?></label>
                    <div class="controls"> <?= form_input('tour_city', '', 'class="form-control" id="tour_city"');?>
                    </div>
                </div> 
               
                
                <div class="form-group">
                    <label for="tour_country"><?= lang("country"); ?></label>
                    <div class="controls"> <?= form_input('tour_country', '', 'class="form-control" id="tour_country"');?>
                    </div>
                </div>
                
                    <div class="form-group">
                        <label for="tour_from_date"><?= lang("from_date"); ?></label>
                        <div class="controls"> <?= form_input('tour_from_date', (isset($_POST['tour_from_date']) ? $_POST['tour_from_date'] : ""), 'class="form-control date" id="tour_from_date"');?> </div>
                    </div>
                    <div class="form-group">
                        <label for="tour_to_date"><?= lang("TO_date"); ?></label>
                        <?php// $date = date($dateFormats['php_sdate']); 
                        ?>
                        <div class="controls"> <?= form_input('tour_to_date', (isset($_POST['tour_to_date']) ? $_POST['tour_to_date'] : ""), 'class="form-control date" id="tour_to_date"');?> </div>
                    </div>
                
          
            
       
        <div class="form-group">
            <div class="controls"> <?= form_submit('submit', lang("add_trip"), 'class="btn btn-primary"');?> </div>
        </div>
        <?= form_close();?> 

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
