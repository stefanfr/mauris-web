<table>
    <tr>
        <th><?=__('Name')?></th>
        <td><?=h($details['School']['name'])?></td>
    </tr>
    <tr>
        <th><?=__('Website')?></th>
        <td><?=$this->Html->link($details['School']['website'], $details['School']['website'])?></td>
    </tr>
    <tr>
        <th><?=__('Language')?></th>
        <td><?=($details['School']['language_id']) ? h($languages[$details['School']['language_id']]) : __('Default')?></td>
    </tr>
    <tr>
        <th><?=__('Style')?></th>
        <td><?=($details['School']['style_id']) ? h($styles[$details['School']['style_id']]) : __('Default')?></td>
    </tr>
    <tr>
        <th><?=__('Logo')?></th>
        <td>
            <?
                if ($details['School']['logo']):
                   echo $this->Html->image($details['School']['logo'], array('width' => '300px'));
                else:
                    echo __('None');
                endif;
            ?>
        </td>
    </tr>
</table>