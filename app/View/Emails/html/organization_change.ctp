<h1><?= __('Organization %1$s changed', $original['School']['name']) ?></h1>
<h2><?= __('Original') ?></h2>
<?= $this->element('emails/html/organization_details', array('details' => $original)) ?>
<h2><?= __('Current') ?></h2>
<?= $this->element('emails/html/organization_details', array('details' => $current)) ?>