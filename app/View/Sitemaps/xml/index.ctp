<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <? foreach ($sitemaps as $sitemap): ?>
    <sitemap>
        <loc><?=Router::url(array('action' => 'view', 'ext' => 'xml', $sitemap), true)?></loc>
    </sitemap>
    <? endforeach; ?>
</sitemapindex>