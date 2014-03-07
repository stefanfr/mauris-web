<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc> 
        <changefreq>daily</changefreq> 
        <priority>1.0</priority> 
    </url>
    <url>
        <loc><?php echo Router::url(array('controller' => 'posts', 'action' => 'index'),true); ?></loc>
        <changefreq>hourly</changefreq>
        <priority>1.0</priority>
    </url> 
    <url>
        <loc><?php echo Router::url(array('controller' => 'pages', 'action' => 'display', 'organization'),true); ?></loc>
        <changefreq>hourly</changefreq>
        <priority>1.0</priority>
    </url>
    <!-- Departments-->
    <?php foreach ($this->get('departments') as $department):?>
    <url>
        <loc>http://<?=$department['Department']['hostname']?>/</loc>
        <changefreq>hourly</changefreq>
        <priority>1</priority>
    </url>
    <?php endforeach; ?>
    <!-- Posts -->
    <?php foreach ($posts as $post):?>
    <url>
        <loc><?=Router::url(array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], Inflector::slug($post['Post']['title'])), true)?>/</loc>
        <changefreq>hourly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
    <!-- Pages -->
    <?php foreach ($pages as $page):?>
    <url>
        <loc><?=Router::url(array('controller' => 'pages', 'action' => 'show', $page['Page']['id'], Inflector::slug($page['Page']['title'])), true)?>/</loc>
        <changefreq>hourly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
    <!-- Schedule entries-->
    <?php foreach ($this->get('schedule-entries') as $entry):?>
    <url>
        <loc><?=$entry['url']?></loc>
        <priority>0.1</priority>
        <changefreq>never</changefreq>
    </url>
    <?php endforeach; ?>
</urlset>