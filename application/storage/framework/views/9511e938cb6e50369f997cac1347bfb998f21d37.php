<?php
$dotSlashes=\App\Helper\Helper::dot_slashes();
$auth = auth()->user();
?>
<?php $__env->startSection('headerScript'); ?>
    <!--Chart Js--->
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/vendors/chartist-js/chartist.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/vendors/chartist-js/chartist-plugin-tooltip.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/css-rtl/pages/dashboard-modern.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/css-rtl/pages/intro.min.css">
    <!--Clock Analog--->
    <link href="<?php echo e(_slash('plugin/clock-analog')); ?>/style.css" rel="stylesheet" type="text/css">
    <script src="<?php echo e(_slash('plugin/clock-analog')); ?>/prefixfree.min.js" type="cf9533af10c137594dc1687f-text/javascript"></script>

    <style>
        .card.shortcode{
            border-radius: 5px;
        }
        .card.shortcode p{
            font-size: 14px;
            color: #3a3939;
        }
        .login-chip .chip{
            width: 100%;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="row" style="display: flex;flex-wrap: wrap">

        <div class="col s12 m6 l8 display-flex">
            <div class="card subscriber-list-card animate fadeUp" style="width: 100%">
                <div class="card-content pb-1">
                    <h4 class="card-title mb-0">آخرین مکاتبات اضافه شده </h4>
                </div>
                <?php $list=\App\Models\post::whereNotNull('id')
                    ->orderby('created_at','DESC')
                    ->limit(4)
                    ->get();
                ?>
                <table class="subscription-table responsive-table highlight">
                    <thead>
                    <tr>
                        <th>تصویر</th>
                        <th>وضعیت</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo imageTitle($item->img,$item->title,30); ?></td>
                            <td><span> <?php echo status_color($item->status,\App\Models\Post::status($item->status)); ?> </span></td>
                            <td><a href="<?php echo e(url('/management/post-edit/'.hashId($item->id))); ?>" class="btn btn-link">نمایش</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col s12 m6 l4 display-flex" id="clock-fence">
            <div class="card padding-4 animate fadeUp" style="background: rgb(169,237,232);background: linear-gradient(90deg, rgba(169,237,232,1) 0%, rgba(93,218,209,1) 100%);width: 100%">
                <div class="row">
                    <div class="col s12 m12">
                        <div class='clock' style="margin: auto">
                            <div class='face'>
                                <div class='midnight'></div>
                                <div class='three'></div>
                                <div class='six'></div>
                                <div class='nine'></div>
                                <div class='hour' id='analoghour'></div>
                                <div class='minute' id='analogminute'></div>
                                <div class='second' id='analogsecond'></div>
                                <div class='dot'></div>
                            </div>
                        </div>

                        <div>
                            <p style="color: #000;text-align: center">
                                <span>امروز</span>
                                <span><?php echo e(vv(date('Y-m-d'),'l , j F Y')); ?></span>
                            </p>
                            <p style="color: #000;text-align: center">
                                <span>Today</span>
                                <span><?php echo e(date('l , j F Y')); ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="display: flex;flex-wrap: wrap">
        <div class="col s12 l5 display-flex">
            <!-- User Statistics -->
            <div class="card user-statistics-card animate " style="width: 100%">
                <div class="card-content">
                    <h4 class="card-title mb-0">آمار کاربر </h4>
                    <div class="row">
                        <div class="col s12 m6">
                            <ul class="collection border-none mb-0">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle pink accent-2">trending_up</i>
                                    <p class="medium-small">امسال</p>
                                    <h5 class="mt-0 mb-0" id="chart-user-max-a">60%</h5>
                                </li>
                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <ul class="collection border-none mb-0">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle purple accent-4">trending_down</i>
                                    <p class="medium-small">سال پیش</p>
                                    <h5 class="mt-0 mb-0" id="chart-user-max-b">40%</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-statistics-container">
                        <div id="user-statistics-bar-chart" class="user-statistics-shadow ct-golden-section"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 l4 display-flex">
            <!-- Recent Buyers -->
            <div class="card recent-buyers-card animate fadeUp" style="width: 100%">
                <div class="card-content">
                    <h4 class="card-title mb-0"> کاربران اخیر </h4>
                    <p class="medium-small pt-2">آخرین اضافه شده های سامانه</p>
                    <?php
                    $users = \App\Models\User::orderby('created_at','desc')->limit(3)->get();
                    ?>
                    <ul class="collection mb-0">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="collection-item avatar">
                            <img src="<?php echo e(_slash('uploads/avatar/'.$user->avatar)); ?>" onerror="this.src='<?php echo e(_slash('back/custom/img/avatar.png')); ?>'" alt="" class="circle" />
                            <p class="font-weight-600"><?php echo e($user->nickname); ?></p>
                            <p class="medium-small"><?php echo e(vv($user->created_at,'j F Y')); ?></p>
                            <a href="./customer-edit/<?php echo e(hashId($user->id)); ?>" class="secondary-content"><i class="material-icons">link</i></a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col s12 l3 display-flex">
            <div class="card animate " style="width: 100%">
                <div class="card-content">
                    <h4 class="card-title mb-0"><a href="./login-list">آخرین گزارشات ورود</a></h4>
                    <?php
                    $list = \App\Models\LoginInfo::join('users','users.id','login_info.user_id')
                        ->limit(4)
                        ->orderby('login_info.created_at','desc')
                        ->select(
                            'login_info.created_at',
                            'users.nickname',
                            'users.avatar'
                        )
                        ->get()
                    ?>
                    <div class=" mt-8">
                        <div>
                            <?php if($list->count()): ?>
                            <p class="login-chip">
                                <?php echo imageTitle('uploads/avatar/'.$list[0]->avatar,$list[0]->nickname); ?>

                                <hr/>
                            </p>
                            <?php endif; ?>
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p>
                                    <span class="chip font-small indigo lighten-4 black-text width-100"><?php echo e(vv($item->created_at)); ?></span>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    <!--Clock Analog--->
    <script src="<?php echo e(_slash('plugin/clock-analog')); ?>/index.js" type="cf9533af10c137594dc1687f-text/javascript"></script>
    <script src="<?php echo e(_slash('plugin/clock-analog')); ?>/rocket-loader.min.js" data-cf-settings="cf9533af10c137594dc1687f-|49" defer=""></script>

    <!--Chart Js--->
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/chartjs/chart.min.js"></script>
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/chartist-js/chartist.min.js"></script>
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/chartist-js/chartist-plugin-tooltip.js"></script>
    <script src="<?php echo e($dotSlashes); ?>back/app-assets/vendors/chartist-js/chartist-plugin-fill-donut.min.js"></script>

    
    <script>
        $(".card-animate").hover(
            function () {
                $(this).find('.animated').addClass('rubberBand');
            },
            function () {
                $(this).find('.animated').removeClass('rubberBand');
            }
        );
    </script>

    <script>
        var UserStatisticsBarChart;
        $(document).ready(function () {
            newChartData();
            $('.tap-target').tapTarget();

        });

        /*تنظیم ارتفاع ستون*/
        /*function setHeight() {
            let elem =$("#clock-fence").closest('.row').find('.col')[0];
            let $height = $(elem).outerHeight();
            $("#clock-fence .card").css('height',($height - 35)+'px');
        }*/

        /*دریافت دیتای نمودارها*/
        function newChartData() {
            helper().get('./chart').done(function (r) {
                let series= [
                    r.data.user['a'],
                    r.data.user['b']
                ];
                UserStatisticsBarChart.data.series = series;
                UserStatisticsBarChart.data.labels = r.data.user['labels'];
                UserStatisticsBarChart.update();

                let max_a=parseInt(r.data.user['max_a']);
                let max_b=parseInt(r.data.user['max_b']);
                let max_all = max_a + max_b;
                let class_a = max_a > max_b?'trending_up':'trending_down';
                let class_b = max_b > max_a?'trending_up':'trending_down';
                $("#chart-user-max-a").html(((max_a * 100) / max_all).toFixed(1)+'%');
                $("#chart-user-max-b").html(((max_b * 100) / max_all).toFixed(1)+'%');
                $("#chart-user-max-a").closest('li').find('i').text(class_a);
                $("#chart-user-max-b").closest('li').find('i').text(class_b);
            });

            //return newData();
        }
    </script>

    <script>

        // Dashboard - Modern
        //----------------------

        (function (window, document, $) {
            // User Statics
            UserStatisticsBarChart = new Chartist.Bar(
                "#user-statistics-bar-chart",
                {
                    labels: ["B1", "B2", "B3", "B4", "B5", "B6"],
                    series: []
                },
                {
                    // Default mobile configuration
                    stackBars: true,
                    chartPadding: 10,
                    axisX: {
                        showGrid: false
                    },
                    axisY: {
                        showGrid: true,
                        labelInterpolationFnc: function (value) {
                            return value + "نفر"
                        },
                        scaleMinSpace: 50
                    },
                    plugins: [
                        Chartist.plugins.tooltip({
                            class: "user-statistics-tooltip",
                            appendToBody: true
                        })
                    ]
                },
                [
                    // Options override for media > 800px
                    [
                        "screen and (min-width: 800px)",
                        {
                            stackBars: false,
                            seriesBarDistance: 10
                        }
                    ],
                    // Options override for media > 1000px
                    [
                        "screen and (min-width: 1000px)",
                        {
                            reverseData: false,
                            horizontalBars: false,
                            seriesBarDistance: 15
                        }
                    ]
                ]
            );

            UserStatisticsBarChart.on("draw", function (data) {
                if (data.type === "bar") {
                    data.element.attr({
                        style: "stroke-width: 12px",
                        x1: data.x1 + 0.001
                    });
                    data.group.append(
                        new Chartist.Svg(
                            "circle",
                            {
                                cx: data.x2,
                                cy: data.y2,
                                r: 6
                            },
                            "ct-slice-pie"
                        )
                    )
                }
            });

            UserStatisticsBarChart.on("created", function (data) {
                var defs = data.svg.querySelector("defs") || data.svg.elem("defs");
                defs
                    .elem("linearGradient", {
                        id: "barGradient1",
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    })
                    .elem("stop", {
                        offset: 0,
                        "stop-color": "rgba(255,75,172,1)"
                    })
                    .parent()
                    .elem("stop", {
                        offset: 1,
                        "stop-color": "rgba(255,75,172, 0.6)"
                    });

                defs
                    .elem("linearGradient", {
                        id: "barGradient2",
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    })
                    .elem("stop", {
                        offset: 0,
                        "stop-color": "rgba(129,51,255,1)"
                    })
                    .parent()
                    .elem("stop", {
                        offset: 1,
                        "stop-color": "rgba(129,51,255, 0.6)"
                    });
                return defs
            });

            // charts update on sidenav collapse
            $('.logo-wrapper .navbar-toggler').on('click', function () {
                setTimeout(function () {
                    //CurrentBalanceDonutChart.update();
                    //TotalTransactionLine.update();
                    UserStatisticsBarChart.update();
                    //ConversionRatioBarChart.update();
                }, 200);
            })
        })(window, document, jQuery);
    </script>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('back-end.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\mis_maleki\application\resources\views/back-end/index.blade.php ENDPATH**/ ?>