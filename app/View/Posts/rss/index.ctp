<?
$this->set('channelData', array(
    'title' => __('Latest news'),
    'link' => $this->Html->url('/', true),
    'description' => __('The latest news')
));

foreach ($posts as $post) {
    $postTime = strtotime($post['Post']['created']);

    $postLink = array(
        'controller' => 'posts',
        'action' => 'view',
        $post['Post']['id'],
        Inflector::slug($post['Post']['title'])
    );

    // Remove & escape any HTML to make sure the feed content will validate.
    $bodyText = h(strip_tags($post['Post']['body']));
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));

    echo  $this->Rss->item(array(), array(
        'title' => $post['Post']['title'],
        'link' => $postLink,
        'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'pubDate' => $post['Post']['created']
    ));
}