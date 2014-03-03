<?
$this->Html->addCrumb(__('Organization'), $this->here);
?>
<div itemscope itemtype="http://schema.org/EducationalOrganization">
<h1 itemprop="name"><?=h($school['School']['name'])?></h1>
<img itemprop="logo" src="<?=$school['School']['logo']?>" width="300px" />

    <div itemprop="department" itemscope itemtype="http://schema.org/EducationalOrganization">
        <h2 itemprop="name"><?=h($department['Department']['name'])?></h2>
        <img itemprop="logo" src="<?=$department['Department']['logo']?>" width="300px" />
    </div>
</div>