<script>
	$(function () {
		Install.sources = <?php echo json_encode($sources) ?>;
		Install.check();
	});
</script>
<table class="table" id="install-status">
	<thead>
	<tr>
		<th>Data</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>

	</tbody>
</table>