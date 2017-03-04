<style type="text/css">
	.mainbar { min-height:768px; }

	.today-datas li {
		width: 16%;
		min-width:130px;
		margin-right:0.5%;
		margin-bottom:10px;
		height:90px;
		vertical-align:middle;
		display: inline-table;
		text-align:center;
		text-transform:uppercase;
	}
	.today-datas li:last-child, .t li:last-child { margin-right:0; }
	.t li { width:32.7%; min-width:150px; }
</style>

<div class="widget wlightblue"> 
	<div class="widget-head">
		<div class="pull-left"><?= lang('name').": <strong>".$cus->company."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".lang('contact_person').": <strong>".$cus->name."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".lang('email').": <strong>".$cus->email."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".lang('phone').": <strong>".$cus->phone."</strong>"; ?></div>
		<div class="widget-icons pull-right"> <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> <a class="wclose" href="#"><i class="icon-remove"></i></a> </div>
		<div class="clearfix"></div>
	</div>

	<div class="widget-content">
		<div class="padd">
			<ul class="today-datas">
				<li class="bviolet"> <span class="bold" style="font-size:24px;">
					<?php /* echo $Settings->currency_prefix." ".$total['total_amount']; */ ?>
					<?= $total; ?></span><br>
					<?= lang('total'); ?> <?= lang('invoices'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="bgreen"> <span class="bold" style="font-size:24px;">
					<?php /* echo $Settings->currency_prefix." ".$paid['total_amount'];*/ ?>
					<?= $paid; ?></span><br>
					<?= lang('paid'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="bblue"> <span class="bold" style="font-size:24px;"><?= $pp; ?></span><br>
					<?= lang('partially_paid'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="borange"> <span class="bold" style="font-size:24px;"><?= $pending; ?></span><br>
					<?= lang('pending'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="bred"> <span class="bold" style="font-size:24px;"><?= $overdue; ?></span><br>
					<?= lang('overdue'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="bred" style="background:#000 !important;"> <span class="bold" style="font-size:24px;"><?= $cancelled; ?></span><br>
					<?= lang('cancelled'); ?>
					<div class="clearfix"></div>
				</li>
			</ul>
			<hr />
			<ul class="today-datas t">
				<li class="bviolet"> <span class="bold" style="font-size:24px;">
					<?php /* echo $Settings->currency_prefix." ".$total['total_amount']; */ ?>
					<?= $this->sim->formatMoney(isset($tpp->total) ? $tpp->total : '0.00'); ?></span><br>
					<?= lang('total'); ?> <?= lang('amount'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="bgreen"> <span class="bold" style="font-size:24px;">
					<?php /* echo $Settings->currency_prefix." ".$paid['total_amount'];*/ ?>
					<?= $this->sim->formatMoney(isset($tpp->paid) ? $tpp->paid : '0.00'); ?></span><br>
					<?= lang('paid'); ?> <?= lang('amount'); ?>
					<div class="clearfix"></div>
				</li>
				<li class="borange"> <span class="bold" style="font-size:24px;"><?= $this->sim->formatMoney(isset($tpp->total) || isset($tpp->paid) ? number_format(($tpp->total - $tpp->paid), 2, '.', '') : '0.00'); ?></span><br>
					<?= lang('balance'); ?> <?= lang('amount'); ?>
					<div class="clearfix"></div>
				</li>
			</ul>
		</div>
	</div>
</div>