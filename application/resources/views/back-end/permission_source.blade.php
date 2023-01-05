@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
    <style>
        .list-route{
            border:solid 1px #dfe3e7;
            border-radius: 7px;
            max-height: 500px;
            height: 500px;
            overflow-y: scroll;
            overflow-x: hidden;
            position: relative;
        }
        .group-box{
            background: #fff;
            /*box-shadow: 0px -1px 11px 0px rgb(205 208 214);*/
            padding: 7px;
        }
        .collection{
            border:solid 1px #dfe3e7;
            padding: 5px;
            border-radius: 5px;
            background: #f7f7f7;
            position: relative;
            z-index: 9;
        }
        .collection:not(.active)::before{
            content: '';
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #e6e6e6;
            z-index: 999;
            left: 0;
            opacity: 0.5;
        }
        .collection.active{
            border-color: blue;
            background-color: #53ddf0;
        }
        .route-collection{
            margin: 0;
            padding: 0;
        }
        .route-collection li{
            display: inline-block;
            padding: 3px 3px 3px 18px;
            background: #fff;
            border:solid 1px #ddd;
            list-style: none;
            margin: 0px;
            border-radius: 3px;
            line-height: 1.5;
            position: relative;
            margin-left: 5px;
            margin-bottom: 5px;
        }
        .route-collection li .close,.close{
            display: inline-block;
            content: '×';
            position: absolute;
            left: 1px;
            top:1px;
            cursor: pointer;
            font-size: 18px ;
        }

    </style>
@stop

@section('content')
    <div class="row" id="vue_body">
        <div class="col m5 s12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">مجوز های منبع</h4>
                </div>
                <div class="card-content">
                    <p style="font-size: 13px" class="mt-1">با انتخاب یک یا چند روت آنها را تحت یک عنوان در یک گروه مجوز جای دهید.</p>
                    <form class="form-horizontal" novalidate>
                        <button type="button" class="btn blue" v-on:click="insert_routes()">افزودن <i class="material-icons right">arrow_back</i> </button>
                        <div class="mt-2">
                            <input type="text" v-on:input="filter($event.target.value)" placeholder="جستجو ..." >
                        </div>
                        <div class="list-route mt-1 padding-1 pb-1">
                            <label class=" mb-1 w-100 display-block" v-for="(v,k) in list">
                                <input type="checkbox" :value="v" v-model="selected"  >
                                <span v-text="v"></span>
                            </label>
                        </div>
                        <div class="break"></div>
                        <button type="button" class="btn blue" v-on:click="insert_routes()">افزودن <i class="material-icons right">arrow_back</i> </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col m7">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">ایجاد گروههای مجوز</h4>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col m7">
                            <div>
                                <label>عنوان گروه مجوز</label>
                                <input type="text" v-model="group_new_name" class="form-control" placeholder="عنوان گروه مجوز">
                            </div>
                        </div>
                        <div class="col m5">
                            <label class="col m12">.</label>
                            <button type="button" class="btn blue" v-on:click="add_group()"><i class="material-icons left">arrow_downward</i>افزودن گروه مجوز</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="title">
                        انتخاب گروه مجوز برای ویرایش
                        <button type="button" class="btn btn-light-indigo btn-small" v-on:click="status_group()">فعال / غیرفعال کردن وضعیت گروه</button>

                    </h4>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div>
                                <select  class="form-control select browser-default" v-model="group_id" required data-validation-required-message="تکمیل ایمیل ضروری است">
                                    <option value="0">یک گروه مجوز انتخاب کنید</option>
                                    <option v-for="v in group_list" :value="v.id" v-text="v.status?v.group_title + ' (فعال) ':v.group_title + ' (غیر فعال) '"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="group-box row mb-2">
                                <span class="close" v-on:click="delete_group()" style="position: absolute;left: 10px;">×</span>
                                <label class="col m12 mb-3 font-medium" v-text="group_select.group_title"></label>
                                <div class="col m12 mb-1" >
                                    <div class="row">
                                        <div class="col m8">
                                            <input type="text" class="fill mb-1" v-model="permission_new_name"  placeholder="افزودن مجوز تازه">
                                        </div>
                                        <div class="col m4 text-left">
                                            <button class="btn orange" v-on:click="add_subGroup()">افزودن<i class="material-icons left">arrow_downward</i></button>
                                        </div>
                                        <div class="collection col m12 mb-1"  v-for="(v,k) in group_select.items" :class="{'active':k==permission_select}" v-on:click="permission_select = k">
                                            <span class="close" v-on:click="delete_subGroup()">×</span>
                                            <label class="font-small-3" v-text="v.title"></label>
                                            <ul class="route-collection">
                                                <li v-for="(value,key) in v.routes" class="font-small-1">@{{ value }} <span class="close" v-on:click="delete_route(value,key)">×</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('footerScript')

    <!--Veu-->
    <script src="{{$dotSlashes}}back/custom/js/vue.js"></script>
    <script src="{{$dotSlashes}}back/custom/js/axios.min.js"></script>
    <script>
        var vm = new Vue({
            el: '#vue_body',
            data: {
                all:[],
                list:[],
                selected:[],
                search:'',
                group_id:0,
                group_list:[],
                group_new_name:'',
                permission_new_name:'',
                permission_select:0,
                group_select:{
                   group_title:'گروهی انتخاب نشد',
                   items:[]
                },
                loading:false,
            },
            mounted:function () {
                let vm=this;
                setTimeout(function () {
                    vm.page_load();
                },1000);
            },
            computed:{
            },
            methods:{
                send(action,params,callback){
                    return axios({
                        url:action,
                        method:'post',
                        params:params
                    }).then(function (r) {
                        if(r.data.result){
                            callback(r);
                        }else{
                            M.toast({html:r.data.msg});
                        }
                    }).catch(function (e) {
                        M.toast({html:'خطای شبکه رخ داده ، دوباره امتحان کنید'});
                    })
                },
                page_load:function () {
                    vm.search='';
                    axios.get('{{url('/management/permission-route')}}').then(function (r) {
                        if(r.data.result){
                            vm.list = vm.all =Object.values(r.data.data.list);
                            vm.group_list=r.data.data.group_list;
                        }
                    })
                },
                filter:function (term) {
                    vm.list=vm.all.filter(function (item) {
                        return (item.indexOf(term) > -1 || term == '')
                    })
                },
                add_group:function () {
                    if(vm.group_new_name !==''){
                        vm.send('{{url('/management/permission-new-group')}}',
                            {
                                token:'{{csrf_token()}}',
                                group_title:vm.group_new_name
                            },function (r) {
                                vm.group_list.push({
                                    id:r.data.id,
                                    group_title:vm.group_new_name,
                                });
                                vm.group_new_name='';
                                M.toast({html:'گروه مجوز ایجاد شد',classes:'green'});
                            });
                    }
                },
                add_subGroup:function () {
                    if(vm.permission_new_name !==''){
                        vm.send('{{url('/management/permission-new-subGroup')}}',
                            {
                                token:'{{csrf_token()}}',
                                title:vm.permission_new_name,
                                group_id:vm.group_id,
                            },function (r) {
                                vm.group_select.items.push({
                                    id:r.data.data.new_id,
                                    title:vm.permission_new_name,
                                    routes:[]
                                });
                                vm.permission_new_name='';
                                M.toast({html:'آیتم برای گروه مجوز ایجاد شد',classes:'green'});
                            });
                    }
                },
                insert_routes(){
                    if(typeof vm.group_select.items[vm.permission_select] === 'undefined'){
                        M.toast({html:'ابتدا گروه مجوز را انتخاب کنید',classes:'red'});
                        return 0;
                    }
                    vm.loading=true;
                    vm.send('{{url('/management/permission-insert-route')}}',{
                        token:'{{csrf_token()}}',
                        subGroup_title:vm.group_select.items[vm.permission_select].title,
                        item_id:vm.group_select.items[vm.permission_select].id, //subGroup_id
                        group_id:vm.group_id,
                        routes:vm.selected,
                    },function(r){
                        vm.selected.forEach(function (v) {
                            vm.group_select.items[vm.permission_select].routes.push(v);
                        });
                        vm.selected=[];
                        vm.page_load();
                        vm.loading=false;
                    });
                },
                delete_route(route,key){
                    vm.loading=true;
                    vm.send('{{url('/management/permission-delete-route')}}',{
                        token:'{{csrf_token()}}',
                        subGroup_title:vm.group_select.items[vm.permission_select].title,
                        item_id:vm.group_select.items[vm.permission_select].id, //subGroup_id
                        group_id:vm.group_id,
                        route:route,
                    },function(r){
                        vm.group_select.items[vm.permission_select].routes.splice(key,1);
                        vm.page_load();
                        vm.loading=false;
                    });
                },
                delete_subGroup(){
                    if(confirm('آیا از انجام این عمل اطمینان دارید')){
                        vm.loading=true;
                        vm.send('{{url('/management/permission-delete-subGroup')}}',{
                            token:'{{csrf_token()}}',
                            subGroup_title:vm.group_select.items[vm.permission_select].title,
                            item_id:vm.group_select.items[vm.permission_select].id, //subGroup_id
                            group_id:vm.group_id,
                        },function(r){
                            vm.group_select.items.splice([vm.permission_select],1);
                            vm.permission_select=0;
                            vm.page_load();
                            vm.loading=false;
                        });
                    }
                },
                delete_group(){
                    if(confirm('آیا از انجام این عمل اطمینان دارید')){
                        vm.loading=true;
                        vm.send('{{url('/management/permission-delete-group')}}',{
                            token:'{{csrf_token()}}',
                            group_id:vm.group_id,
                        },function(r){
                            vm.group_id=0;
                            vm.group_select={
                                group_title:'حذف گروه مجوز انجام شد',
                                items:[]
                            };
                            vm.page_load();
                            vm.loading=false;
                        });
                    }
                },
                status_group(){
                    if(confirm('آیا از انجام این عمل اطمینان دارید')){
                        vm.loading=true;
                        vm.send('{{url('/management/permission-status-group')}}',{
                            token:'{{csrf_token()}}',
                            group_id:vm.group_id,
                        },function(r){
                            if(r.data.result){
                                M.toast({html:r.data.msg,classes:'green'});
                                vm.group_list.forEach(function (item,key) {
                                    if(vm.group_id == item.id){
                                        let row = vm.group_list[key];
                                        vm.group_list[key].status = r.data.status;
                                    }
                                });
                            }
                            //vm.page_load();
                            vm.loading=false;
                        });
                    }
                },
            },

            watch: {
                group_id:function (value) {
                    if(value > 0){
                        axios.get('{{url('/management/select-permission-group')}}/'+value).then(function (r) {
                            if(r.data.result){
                                vm.group_select = r.data.data;
                            }
                        })
                        .catch(function (e) {
                            M.toast({html:'خطای شبکه رخ داده ، دوباره امتحان کنید'});
                        })
                    }

                },
            }
        });
    </script>
@stop

