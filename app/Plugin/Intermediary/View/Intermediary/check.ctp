<?

$infoDisplay = array(
    'title' => __('Title'),
    'description' => __('Description'),
    'author' => __('Author'),
    'publisher' => __('Publisher'),
    'copyright' => __('Copyright holder'),
);

$this->Html->scriptStart();
?>
$(function(){
    var sec = 5;
    
    var language = {};
    language.goto = "<?=__('Go to the website')?>";
    language.gotoin = "<?=__('Go to the website in %s second(s)', '[seconds]')?>";
    
	$('#continue-button').html(language.gotoin.replace('[seconds]', sec--));
		
    var timer = setInterval(function() {
		$('#continue-button').html(language.gotoin.replace('[seconds]', sec--));
		if (sec == -1) {
			$('#continue-button').removeClass('disabled');
			$('#continue-button').html(language.goto);
			clearInterval(timer);
		} 
	}, 1000);
});
<?=$this->Html->scriptEnd()?>
<div class="col-md-12">
    <div class="row">
        <div class="col-sm-7">
            <h1><?=__('Warning')?></h1>
            <p><?=__('The webpage you\'re trying to go to might be dangerous. For more information about the page, take a look at the information shown on this page.')?></p>
            <br/>
            <?=$this->Html->link(__('Go to the website'), $page_url, array('id' => 'continue-button', 'class' => 'btn btn-danger disabled'))?>
            <br/><br/>
        </div>
        <div class="col-sm-5">
            <table class="table">
                <tbody>
                    <tr>
                        <th><?=h(__('Link'))?></th>
                        <td><?=h($page_url)?></td>
                    </tr>
                    <?
                    foreach ($infoDisplay as $key => $name):
                        if (!isset($page_info[$key])):
                            continue;
                        endif;
                    ?>
                    <tr>
                        <th><?=h($name)?></th>
                        <td><?=h($page_info[$key])?></td>
                    </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>