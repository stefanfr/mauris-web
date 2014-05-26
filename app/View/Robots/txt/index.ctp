User-Agent: *
<?php foreach ($disallow as $entry): ?>
Disallow: <?php echo Router::url($entry); ?>

<?php endforeach; ?>
<?php foreach ($sitemaps as $sitemap): ?>
Sitemap: <?php echo Router::url($sitemap, true); ?>

<?php endforeach; ?>
