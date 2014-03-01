<b><?=h(__('Name'))?></b>:
<? if (trim($fullname)):?>
<?=$fullname?><?=($nickname) ? ' (' . $nickname . ')' : ''?> 
<? else: ?>
<?=$nickname?> 
<? endif; ?>