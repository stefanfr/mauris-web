<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Pages -->
    <?php foreach ($pages as $page):?>
    <url>
        <loc><?=Router::url(array('controller' => 'pages', 'action' => 'show', $page['Page']['id'], Inflector::slug($page['Page']['title'])), true)?></loc>
        <changefreq>hourly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
</urlset>