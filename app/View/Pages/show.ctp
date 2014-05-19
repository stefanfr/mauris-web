<?
$this->Title->setPageTitle($page['Page']['title']);

$this->Title->addCrumbs(array(
	$this->here
));

$this->set('title_for_layout', $this->Title->getPageTitle());
?>

<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<?=$body?>

<div class="well"><em><?=__('This page was not created by the developers of the system. We\'ve added a intermediary page that checks every link to warn about possible dangerous activies.')?></em></div>