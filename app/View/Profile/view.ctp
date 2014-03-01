<b>Naam</b>: 
<? if (trim($fullname)):?>
<?=$fullname?><?=($nickname) ? ' (' . $nickname . ')' : ''?> 
<? else: ?>
<?=$nickname?> 
<? endif; ?>