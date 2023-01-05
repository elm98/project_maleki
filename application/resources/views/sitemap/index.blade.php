<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('sitemap.xml/articles') }}</loc>
    </sitemap>
    {{--<sitemap>
        <loc>{{ url('sitemap.xml/tags') }}</loc>
    </sitemap>--}}
    <sitemap>
        <loc>{{ url('sitemap.xml/products') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap.xml/product/categories') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap.xml/product/tags') }}</loc>
    </sitemap>
</sitemapindex>
