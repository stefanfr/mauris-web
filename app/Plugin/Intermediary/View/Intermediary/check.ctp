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
$(document).ready(function () {
console.log('lalalal');
    var sec = 5;
    var timer = setInterval(function() { 
   $('#continue-button span').text(sec--);
   if (sec == -1) {
      $('#continue-button').prop('disabled', false);
      $('#continue-button span').text('');
      clearInterval(timer);
   } 
}, 1000);
});
<?=$this->Html->scriptEnd()?>
<div class="col-md-12">
    <div class="row">
        <div class="col-sm-7">
            <h1>Warning</h1>
            <p><?=__('The webpage you\'re trying to go to might be dangerous. For more information about the page, take a look at the information shown on this page.')?></p>
            <br>
            <button id="continue-button" class="btn btn-danger" disabled>
                <?=$this->Html->link(__('Go to the website'), $page_url)?>
                <span></span>
            </button>
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