<?=__('Organization %1$s changed', $original['School']['name'])?>



<?=__('Original')?>


<?=$this->element('emails/text/organization_details', array('details' => $original))?>



<?=__('Current')?>


<?=$this->element('emails/text/organization_details', array('details' => $current))?>