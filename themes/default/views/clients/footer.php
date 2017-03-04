<div class="clearfix"></div>
</div>

<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

<script src="<?= $assets; ?>js/bootstrap.min.js"></script>
<script src="<?= $assets; ?>js/plugins.js"></script>
<script src="<?= $assets; ?>js/custom.js"></script>
<script type="text/javascript" src="<?= $assets; ?>datatables/datatables.min.js"></script>
<?php unset($Settings->email_html, $Settings->protocol, $Settings->mailpath, $Settings->smtp_host, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->smtp_crypto, $Settings->default_email, $Settings->envato_username, $Settings->purchase_code); ?>
<script type="text/javascript">
	var Site = <?= json_encode(array('base_url' => base_url(), 'Settings' => $Settings, 'dateFormats' => $dateFormats)); ?>;
	var lang = <?= json_encode(array('not_allowed' => lang('not_allowed'))); ?>;
</script>
<?php 
$v = strtolower($this->router->fetch_method());
?>
<script type="text/javascript"  charset="UTF-8">
	$(document).ready(function() {
		$('#<?= $v; ?>').parent('li').addClass('current');
		$(document).on('click', '.invoice_link', function (e) {
		    e.preventDefault();
		    var link = '<?= site_url('clients/view_invoice/'); ?>?id=' + $(this).attr('id');
		    $.get(link).done(function(data) {
		        $('#myModal').html(data).modal();
		    });
		    return false;
		});
		$(document).on('click', '.quote_link', function (e) {
		    e.preventDefault();
		    var link = '<?= site_url('clients/view_quote/'); ?>?id=' + $(this).attr('id');
		    $.get(link).done(function(data) {
		        $('#myModal').html(data).modal();
		    });
		    return false;
		});
	});
</script>

</body>
</html>
