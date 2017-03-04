<div id="body_section">
    <div id="body_section_inner">
        <div class="contentPageWrapper">
            <h1><?= $page_title; ?></h1>
            <ul class="dash">
                <li>
                    <a href="<?= site_url('reports/products'); ?>" title="<?= lang("product_reports"); ?>" class="tooltip">
                       <img src="<?= $this->config->base_url(); ?>smlib/images/icons/product_report.png" alt="" />
                       <span><?= lang("product_reports"); ?></span>
                   </a>
               </li>

               <?php $group1 = array('admin', 'viewer', 'purchaser'); if($this->sim->in_group($group1)) { ?>
               <li>
                <a href="<?= site_url('reports/purchases'); ?>" title="<?= lang("purchase_reports"); ?>" class="tooltip">
                   <img src="<?= $this->config->base_url(); ?>smlib/images/icons/purchase_report.png" alt="" />
                   <span><?= lang("purchase_reports"); ?></span>
               </a>
           </li>
           <?php } ?>
           <?php $group2 = array('owner', 'admin', 'viewer', 'salesman'); if($this->sim->in_group($group2)) { ?>
           <li>
            <a href="<?= site_url('reports/sales'); ?>" title="<?= lang("sale_reports"); ?>" class="tooltip">
               <img src="<?= $this->config->base_url(); ?>smlib/images/icons/sale_report.png" alt="" />
               <span><?= lang("sale_reports"); ?></span>
           </a>
       </li>
       <?php } ?>
   </ul>
   <div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>