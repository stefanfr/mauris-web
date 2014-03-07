<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Posts -->
    <?php foreach ($posts as $post):?>
    <url>
        <loc><?=Router::url(array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], Inflector::slug($post['Post']['title'])), true)?>/</loc>
        <changefreq>hourly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
</urlset>