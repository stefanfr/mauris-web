<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Other pages -->
    <?php foreach ($pages as $pageRoute):?>
    <url>
        <loc><?=Router::url($pageRoute, true)?>/</loc>
    </url>
    <?php endforeach; ?>
</urlset>