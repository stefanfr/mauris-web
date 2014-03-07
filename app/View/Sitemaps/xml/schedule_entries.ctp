<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Schedule entries-->
    <?php foreach ($schedule_entries as $entry):?>
    <url>
        <loc><?=Router::url(array('controller' => 'schedule', 'action' => 'view', $entry['ScheduleEntry']['id']), true)?></loc>
        <priority>0.1</priority>
        <changefreq>never</changefreq>
    </url>
    <?php endforeach; ?>
</urlset>