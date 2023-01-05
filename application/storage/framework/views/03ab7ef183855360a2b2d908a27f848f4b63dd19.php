<?php $dotSlashes=\App\Helper\Helper::dot_slashes();?>
<?php $head_color='yes'?>
<?php $__env->startSection('headerScript'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/vendors/data-tables/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/css/pages/data-tables.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card card-round">
                <div class="card-header rounded  gradient-45deg-light-blue-cyan gradient-shadow">
                    <div class="title"> گزارشات ورود کاربران <i class="material-icons left white-text">people</i> </div>

                </div>
                <div class="card-content">
                    <form id="dt_form">
                        <div class="row mb-2">
                            <div class="col m2 s12 input-field">
                                <input name="date1" id="pdate1" placeholder="انتخاب تاریخ از" type="text" class="validate d-filter" autocomplete="off">
                                <label class="active always">زمان ایجاد از تاریخ</label>
                            </div>
                            <div class="col m2 s12 input-field">
                                <input name="date2" id="pdate2" placeholder="تا" type="text" class="validate d-filter " autocomplete="off">
                                <label class="active always">تا تاریخ</label>
                            </div>
                            <div class="col m2 s12 input-field">
                                <select name="role" class="d-filter validate">
                                    <option value="0">همه</option>
                                    <?php $__currentLoopData = \App\Models\User::role(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label>نقش کاربری</label>
                            </div>
                            <div class="col m3 s12 input-field">
                                <select name="status" class="d-filter validate">
                                    <option value="0">همه</option>
                                    <?php $__currentLoopData = \App\Models\User::status(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label>وضعیت</label>
                            </div>

                            <div class="--BUTTON-- col m2 s12 left-align">
                                <button type="submit" class="btn blue btn-small waves-effect waves-light mb-2"><i class="material-icons left">search</i> اعمال فیلتر</button>
                                <button type="button" id="dt_reset" class="btn btn-small waves-effect waves-light mb-2"><i class="material-icons left">close</i> حذف فیلترها </button>
                            </div>
                        </div>
                    </form>
                    <!--dataTable-->
                    <div class="row">
                        <div class="col s12 section-data-tables scrollspy">
                            <table id="my-dt" class="display tbl-border">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 11px"><label><input type="checkbox" class="check-all"><span></span></label></th>
                                        <th>شناسه</th>
                                        <th>نام کاربری</th>
                                        <th>اسم و فامیل</th>
                                        <th>شماره همراه</th>
                                        <th>نقش کاربری</th>
                                        <th>ای پی</th>
                                        <th>تاریخ ورود</th>
                                        <th>اطلاعات مرورگر</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="action-button mt-2">
                                <button class="btn rows-delete--" onclick="helper().rows_delete('login-delete')" data-action="user-delete">حذف دسته جمعی<i class="material-icons left">delete</i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('float_button'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
    <!--دیتا تیبل-->
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>
    <script>
        $(function () {
            var dt=$("#my-dt").DataTable({
                responsive:!0,
                lengthMenu:[5, 10, 25, 50, 100, 200, 500, 1000, 2000],
                pageLength:25,
                searching: true,
                processing: true,
                serverSide: true,
                searchDelay: 500,
                //scrollX:!0,
                language: {
                    sProcessing: "درحال پردازش ....",
                    emptyTable: "هیچ اطلاعاتی در دسترس نیست",
                    info: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                    infoEmpty: "هیچ رکوردی یافت نشد",
                    infoFiltered: "(فیلتر 1 از _MAX_ رکورد)",
                    lengthMenu: "نمایش سطر در هر صفحه  _MENU_ ",
                    search: "جستجوی گسترده: ",
                    zeroRecords: "هیچ نتیجه ای یافت نشد",
                },
                ajax: {
                    url: '<?php echo e(url("/management/login-list")); ?>',
                    type: "POST",
                    dataType: "json",
                    delay:5000,
                    data:
                        function(d) {
                            d=helper().dtParam(d,'d-filter');
                        }
                },
                columns: [
                    { data: 'checked', name: 'checkboxes',orderable: false, searchable: false },
                    { data: 'id', name: 'users.id',"visible": false},
                    { data: 'username', name: 'users.username' },
                    { data: 'nickname', name: 'users.nickname' },
                    { data: 'mobile', name: 'users.mobile' },
                    { data: 'role', name: 'users.role' },
                    { data: 'ip', name: 'ip' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'agent', name: 'agent', orderable: false, searchable: false}
                ],
                order: [[1, 'desc']]
            });
            $('#dt_form').on('submit', function(e) {
                e.preventDefault();
                dt.draw();
                helper().scrollTo('my-dt',70);
            });
            $('#dt_reset').on('click', function(e) {
                $("#dt_form").find("input[type],select").val('');
                dt.draw();
                helper().scrollTo('my-dt',70);
            });
        });
        setTimeout(function () {
            helper().scrollTo('my-dt',70);
        },2000)
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('back-end.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\mis_maleki\application\resources\views/back-end/login-list.blade.php ENDPATH**/ ?>