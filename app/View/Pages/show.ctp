<?
    $this->Html->addCrumb($page['Page']['title'], $this->here);
    $this->set('title_for_layout', $page['Page']['title']);
?>

<?=$body?>

<div class="well"><em><?=__('This page was not created by the developers of the system. We\'ve added a intermediary page that checks every link to warn about possible dangerous activies.')?></em></div>