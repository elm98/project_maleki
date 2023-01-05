@extends('sitemap._layout')
@section('content')
    @foreach ($list as $item)
        <?php
        $item->title = urlencode($item->title);
        $item->slug = urlencode($item->slug);
        ?>
        <url>
            <loc>{{ getLink('product',$item) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1</priority>
            @if(count(glob(basePath().'/'.$item->img)))
                <image:image>
                    <image:loc>{{url('/'.$item->img)}}</image:loc>
                </image:image>
            @endif
        </url>
    @endforeach
@stop
