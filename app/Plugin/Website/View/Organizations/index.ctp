<?
$this->set('title_for_layout', __('Organizations'));

$this->Html->addCrumb(
    __('Organizations'),
    $this->here
);
?>
<style>
    .thumbnail {
        <?=$this->Html->style(array(
            'width' => '400px'
        ), false)?>
    }
</style>
<h1><?=h(__('Organizations'))?></h1>
<?
foreach ($organizations as $organization):
?>
    <h2><?=h($organization['School']['name'])?></h2>
    <?if ($organization['School']['hostname']):?>
    <p>
        <?=String::insert(
            __('To go to the organization\'s website :click_here'),
            array(
                'click_here' => $this->Html->link(
                    __('click here'),
                    'http://' . $organization['School']['hostname'] . Router::url(
                        array(
                            'plugin' => null,
                            'controller' => 'pages',
                            'action' => 'display',
                            'home'
                        )
                    ),
                    array(
                        'target' => '_blank'
                    )
                )
            )
        )?>
    </p>
    <?endif?>
<?
    if ($organization['School']['logo']):
        echo $this->Html->image($organization['School']['logo'], array('class' => 'thumbnail'));
    endif;
    foreach ($organization['HasDepartments'] as $department):
?>
        <h3><?=h($department['name'])?></h3>
        <?if ($department['hostname']):?>
        <p>
            <?=String::insert(
                __('To go to the department\'s website :click_here'),
                array(
                    'click_here' => $this->Html->link(
                        __('click here'),
                        'http://' . $department['hostname'] . Router::url(
                            array(
                                'plugin' => null,
                                'controller' => 'pages',
                                'action' => 'display',
                                'home'
                            )
                        ),
                        array(
                            'target' => '_blank'
                        )
                    )
                )
            )?>
        </p>
        <?endif?>
<?
        if ($department['logo']):
            echo $this->Html->image($department['logo'], array('class' => 'thumbnail'));
        endif;
    endforeach;
endforeach;
?>
<ul class="pagination">
<?=$this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span'))?>
</ul>