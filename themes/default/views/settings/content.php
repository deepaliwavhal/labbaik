<div id="body_section">
	<!-- Errors -->
	<?php if ($message) { echo "<div class=\"yellow_bar\">".$message."</div>"; } ?>
	<div id="body_section_inner">
		<div class="contentPageWrapper">
		<h1><?= $page_title; ?></h1>

			<ul class="dash">
				<li>
					<a href="settings/system_setting" title="<?= lang("system_setting"); ?>" class="tooltip">
						<img src="<?= $this->config->base_url(); ?>smlib/images/icons/settings.png" alt="" />
						<span><?= lang("system_setting"); ?></span>
					</a>
				</li>
				<li>
					<a href="settings/change_logo" title="<?= lang("change_logo"); ?>" class="tooltip">
						<img src="<?= $this->config->base_url(); ?>smlib/images/icons/upload.png" alt="" />
						<span><?= lang("change_logo"); ?></span>
					</a>
				</li>
				<li>
					<a href="settings/upload_biller_logo" title="<?= lang("upload_biller_logo"); ?>" class="tooltip">
						<img src="<?= $this->config->base_url(); ?>smlib/images/icons/upload_folder.png" alt="" />
						<span><?= lang("upload_biller_logo"); ?></span>
					</a>
				</li>

				<li>
					<a href="settings/warehouses" title="<?= lang("warehouses"); ?>" class="tooltip">
						<img src="<?= $this->config->base_url(); ?>smlib/images/icons/warehouse.png" alt="" />
						<span><?= lang("warehouses"); ?></span>
					</a>
				</li><li>
				<a href="settings/add_warehouse" title="<?= lang("new_warehouse"); ?>" class="tooltip">
					<img src="<?= $this->config->base_url(); ?>smlib/images/icons/add_warehouse.png" alt="" />
					<span><?= lang("new_warehouse"); ?></span>
				</a>
			</li>

			<li>
				<a href="settings/backup_database" title="<?= lang("backup_database"); ?>" class="tooltip">
					<img src="<?= $this->config->base_url(); ?>smlib/images/icons/db-backup.png" alt="" />
					<span><?= lang("backup_database"); ?></span>
				</a>
			</li>
		</ul>
		<div class="clr"></div>

		<div class="clr"></div>
	</div>
	<div class="clear"></div>
</div>
</div>