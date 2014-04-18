<?
$this->Html->addCrumb(__('Organizations'), $this->here);
$this->set('title_for_layout', __('Organizations'));
?>
<table class="table">
    <thead>
        <tr>
            <th>Datum</th>
            <th>Naam</th>
            <th>Verander</th>
            <th>Verwijderen</th>
        </tr>
    </thead>
    <tbody>
		<? foreach ($organizations as $organization): ?>
	        <tr>
	            <td></td>
	            <td><?= $organization['School']['name'] ?></td>
	            <td>
	                <a class="btn btn-default" href="<?= Router::url(array('action' => 'edit', $organization['School']['id'])) ?>">
	                    <span class="glyphicon glyphicon-pencil"></span>
	                </a>
	            </td>
	            <td>
	                <a class="btn btn-default" href="<?= Router::url(array('action' => 'remove', $organization['School']['id'])) ?>">
	                    <span class="glyphicon glyphicon-remove"></span>
	                </a>
	            </td>
	        </tr>
		<? endforeach ?>
    </tbody>
</table>

<ul class="pagination">
	<?= $this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span')) ?>
</ul>