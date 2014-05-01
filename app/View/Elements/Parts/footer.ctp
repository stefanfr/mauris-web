<?php
$this->startIfEmpty('footer');
?>
<hr>
<footer>
	<span>
		<?php echo $this->fetch('copyright'); ?>
	</span>
	<span class="pull-right">
		<?php echo $this->Naming->footer()?>
	</span>
</footer>
<?php
$this->end();
echo $this->fetch('footer');
?>