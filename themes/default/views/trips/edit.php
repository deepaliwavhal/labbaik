<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">

        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("trips/edit?id=".$id);?>
                <div class="form-group">
                    <label for="tour_name"><?= lang("Title"); ?></label>
                    <div class="controls"> <?= form_input('tour_name', (isset($_POST['tour_name']) ? $_POST['tour_name'] : $trip->t_name), 'class="form-control" id="tour_name"');?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tour_description"><?= lang("description"); ?></label>
                     <textarea class="form-control skip" id="tour_description" name="tour_description"><?php echo (isset($_POST['tour_from_date']) ? $_POST['tour_from_date'] : $trip->t_description); ?></textarea>
                    
                </div> 
                <div class="form-group">
                    <label for="tour_price"><?= lang("price"); ?></label>
                    <div class="controls"> <?= form_input('tour_price', (isset($_POST['tour_price']) ? $_POST['tour_price'] : $trip->t_price), 'class="form-control" id="tour_price"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="tour_agent"><?= lang("Agent"); ?></label>
                    <div class="controls"> <?= form_input('tour_agent', (isset($_POST['tour_agent']) ? $_POST['tour_agent'] : $trip->t_agent), 'class="form-control" id="tour_agent"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="tour_hotel"><?= lang("Hotel"); ?></label>
                    <div class="controls">
                        <?php
                        $hotels=array("1","2");
                        $hotel_list[""] = lang("select") . " " . lang("Hotel");
                        $selected_hotel='';
                        foreach ($hotels as $key=>$value) {
                            if($value==$trip->t_hotel)
                                $selected_hotel=$value;
                            $hotel_list[$value] = $value;                           
                        }
echo form_dropdown('tour_hotel', $hotel_list, (isset($_POST['tour_hotel']) ? $_POST['tour_hotel'] : $selected_hotel), 'class="form-control tour_hotel" data-placeholder="' . lang("select") . " " . lang("Hotel") . '" id="tour_hotel" style="width:100%;"');
                        ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label for="tour_airline"><?= lang("airline"); ?></label>
                    <div class="controls">
                        <?php
                        $airlines=array("1","2");
                        $airline_list[""] = lang("select") . " " . lang("airline");
                        $selected_airline='';
                        foreach ($airlines as $key=>$value) {
                            if($value==$trip->t_hotel)
                                $selected_airline=$value;
                            $airline_list[$value] = $value;
                        }
echo form_dropdown('tour_airline', $airline_list, (isset($_POST['tour_airline']) ? $_POST['tour_airline'] : $selected_airline), 'class="form-control tour_airline" data-placeholder="' . lang("select") . " " . lang("airline") . '" id="tour_airline" style="width:100%;"');
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="tour_max_capacity"><?= lang("max_capacity"); ?></label>
                    <div class="controls"> <?= form_input('tour_max_capacity', (isset($_POST['tour_max_capacity']) ? $_POST['tour_max_capacity'] : $trip->t_max_capacity), 'class="form-control" id="tour_max_capacity"');?>
                    </div>
                </div> 
                
                <div class="form-group">
                    <label for="tour_city"><?= lang("city"); ?></label>
                    <div class="controls"> <?= form_input('tour_city', (isset($_POST['tour_city']) ? $_POST['tour_city'] : $trip->t_city), 'class="form-control" id="tour_city"');?>
                    </div>
                </div> 
               
                
                <div class="form-group">
                    <label for="tour_country"><?= lang("country"); ?></label>
                    <div class="controls"> <?= form_input('tour_country', (isset($_POST['tour_country']) ? $_POST['tour_country'] : $trip->t_country), 'class="form-control" id="tour_country"');?>
                    </div>
                </div>
                
                    <div class="form-group">
                        <label for="tour_from_date"><?= lang("from_date"); ?></label>
                        <div class="controls"> <?= form_input('tour_from_date', (isset($_POST['tour_from_date']) ? $_POST['tour_from_date'] : $trip->t_fromdate), 'class="form-control date" id="tour_from_date"');?> </div>
                    </div>
                    <div class="form-group">
                        <label for="tour_to_date"><?= lang("TO_date"); ?></label>
                        <?php// $date = date($dateFormats['php_sdate']); 
                        ?>
                        <div class="controls"> <?= form_input('tour_to_date', (isset($_POST['tour_to_date']) ? $_POST['tour_to_date'] : $trip->t_todate), 'class="form-control date" id="tour_to_date"');?> </div>
                    </div>
        
        <div class="form-group">
            <div class="controls"> <?= form_submit('submit', lang("edit_trip"), 'class="btn btn-primary"');?> </div>
        </div>
        <?= form_close();?> 

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
