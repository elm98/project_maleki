@extends('sitemap._layout')
@section('content')
    @foreach ($articles as $item)
        <url>
            <loc>{{ getLink('post',$item) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
            @if(count(glob(basePath().'/uploads/media/'.$item->img)))
                <image:image>
                    <image:loc>{{url('/uploads/media/'.$item->img)}}</image:loc>
                </image:image>
            @endif
        </url>
    @endforeach
@stop
