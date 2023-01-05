<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($list as $item)
        @foreach(explode(',',$item->tags) as $tag)
            @if(!empty($tag))
                <url>
                    <loc>{{ url('/shop?tag='.$tag) }}</loc>
                    <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.9</priority>
                </url>
            @endif
        @endforeach
    @endforeach
</urlset>
