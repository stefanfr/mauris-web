<?
$this->set('schema_type_for_layout', 'ProfilePage');
?>
<div itemprop="about" itemscope itemtype="http://schema.org/Person">
<b><?=h(__('Name'))?></b>:<span itemprop="name">
<? if (trim($fullname)):?>
<?=$fullname?><?=($nickname) ? ' (' . $nickname . ')' : ''?> 
<? else: ?>
<?=$nickname?> 
<? endif; ?>
</span>
</div>