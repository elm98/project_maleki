@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
@stop

@section('content')
    <form method="post" action="{{url('/management/permission-update')}}" class="send-ajax">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($data->id)}}">
        <div class="card ">
            <div class="card-header gradient-45deg-light-blue-cyan gradient-shadow">
                <div class="title">بروز رسانی مجوز</div>
                <div class="tools">
                    <a href="{{url('/management/permission-list')}}" class="btn white black-text">
                        <i class="material-icons left">arrow_forward</i> برگشت به لیست
                    </a>
                </div>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col m4 s12">
                        <div class="input-field">
                            <input type="text" name="title" value="{{$data->title}}">
                            <label>نام مجوز را تعیین کنید</label>
                        </div>
                    </div>
                    <div class="col m4 s12">
                        <div class="input-field">
                            <button type="submit" class="btn waves-effect waves-light animated ">ذخیره مشخصات</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;flex-wrap: wrap">
                    @foreach($list as $row)
                        <div class="col m4 s12" style="display: flex;">
                            <div class="card padding-4" style="width: 100%">
                                <label class="blue-text">
                                    <input type="checkbox" class="paren-checkbox" data-parent="{{$row['id']}}">
                                    <span>{{$row['title']}}</span>
                                </label>
                                <div class="divider mt-2 mb-2"></div>
                                @foreach($row['items'] as $item)
                                    <?php
                                    $routes=explode(',',$item->routes);
                                    $arr=$data->array_items;
                                    $count=[];
                                    $count=array_map(function ($a)use($count,$arr){
                                        return in_array($a,$arr)?1:0;
                                    },$routes)
                                    ?>
                                    <div>
                                        <label class="black-text">
                                            <input type="checkbox" name="foo[]" class="child_{{$row['id']}}" value="{{implode('|',$routes)}}" {{array_sum($count) == count($routes)?'checked':''}}>
                                            <span>{{$item->title}}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @for($i=1;$i<=3 - fmod(count($list),3);$i++)
                        <div class="col m4 s12"></div>
                    @endfor
                </div>
            </div>
        </div>
    </form>

@stop

@section('modal')
@stop

@section('footerScript')

    <script>
        $('.paren-checkbox').click(function () {
            var $id=$(this).data('parent');
            if($(this).prop('checked'))
                $(".child_"+$id).prop('checked',true);
            else
                $(".child_"+$id).prop('checked',false);
        })
    </script>
@stop

