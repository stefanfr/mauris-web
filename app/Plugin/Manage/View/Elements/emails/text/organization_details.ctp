<?=__('Name')?>: <?=h($details['School']['name'])?>

<?=__('Website')?>: <?=h($details['School']['website'])?>

<?=__('Language')?>: <?=($details['School']['language_id']) ? $languages[$details['School']['language_id']] : __('Default')?>

<?=__('Style')?>: <?=($details['School']['style_id']) ? $styles[$details['School']['style_id']] : __('Default')?>

<?=__('Logo')?>: <?=($details['School']['logo']) ? $details['School']['logo'] : __('None')?>