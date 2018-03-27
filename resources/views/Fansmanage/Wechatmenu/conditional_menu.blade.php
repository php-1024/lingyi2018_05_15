<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>零壹云管理平台 | 总分店管理系统</title>
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/js/jPlayer/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/app.css" type="text/css" />
    <link href="{{asset('public/Fansmanage')}}/sweetalert/sweetalert.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/js/nestable/nestable.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/js/chosen/chosen.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="{{asset('public/Fansmanage')}}/js/ie/html5shiv.js"></script>
    <script src="{{asset('public/Fansmanage')}}/js/ie/respond.min.js"></script>
    <script src="{{asset('public/Fansmanage')}}/js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body class="">
<section class="vbox">
    <header class="bg-white-only header header-md navbar navbar-fixed-top-xs">
        @include('Fansmanage/Public/Header')
    </header>
    <section>
        <section class="hbox stretch">

            <!-- .aside -->
            <aside class="bg-black dk aside hidden-print" id="nav">
                <section class="vbox">
                    <section class="w-f-md scrollable">
                        @include('Fansmanage/Public/Nav')
                    </section>
                </section>
            </aside>
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <!-- side content -->
                    <aside class="aside bg-dark" id="sidebar">
                        <section class="vbox animated fadeInUp">
                            <section class="scrollable hover">
                                <div class="list-group no-radius no-border no-bg m-t-n-xxs m-b-none auto">
                                    <a href="{{url('fansmanage/wechatmenu/defined_menu')}}" class="list-group-item">
                                        自定义菜单
                                    </a>
                                    <a href="{{url('fansmanage/wechatmenu/conditional_menu')}}" class="list-group-item active">
                                        个性化菜单
                                    </a>
                                    <input type="hidden" id="defined_menu_add_url" value="{{ url('fansmanage/ajax/conditional_menu_add') }}">
                                    <input type="hidden" id="defined_menu_get_url" value="{{ url('fansmanage/ajax/conditional_menu_get') }}">
                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                </div>
                            </section>
                        </section>
                    </aside>
                    <!-- / side content -->
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder-lg">
                                <h2 class="font-thin m-b">个性化菜单</h2>
                                <div class="col-sm-4" id="menu_box">

                                </div>
                                <div class="col-sm-8">

                                    <section class="panel panel-default" id="ctrl_box"></section>
                                    <section class="panel panel-default">
                                        <header class="panel-heading font-bold">
                                            常用入口链接
                                        </header>
                                        <div class="panel-body">
                                            <form class="form-horizontal" method="get">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-id-1">点餐系统入口</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="input-id-1" disabled="" value="http://o2o.01nnt.com/diancan-11">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-id-1">外卖系统入口</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"  disabled="" value="http://o2o.01nnt.com/diancan-12">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-id-1">预约系统入口</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" disabled="" value="http://o2o.01nnt.com/diancan-13">
                                                    </div>
                                                </div>
                                                <div class="line line-dashed b-b line-lg pull-in"></div>
                                            </form>
                                        </div>
                                    </section>
                                </div>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<script src="{{asset('public/Fansmanage')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Fansmanage')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Fansmanage')}}/js/app.js"></script>
<script src="{{asset('public/Fansmanage')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Fansmanage')}}/js/app.plugin.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/js/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script src="{{asset('public/Fansmanage')}}/js/nestable/jquery.nestable.js"></script>
<script src="{{asset('public/Fansmanage')}}/js/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/js/jPlayer/demo.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
    $(function(){
        get_menu_add_box();
    });

    function get_menu_add_box(){
        var url = $('#defined_menu_add_url').val();
        var token = $('#_token').val();
        var data = {'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{
                $('#ctrl_box').html(response);
            }
        });
    }

//    function get_menu(){
//        var url = $('#defined_menu_get_url').val();
//        var token = $('#_token').val();
//        var data = {'_token':token};
//        $.post(url,data,function(response){
//            if(response.status=='-1'){
//                swal({
//                    title: "提示信息",
//                    text: response.data,
//                    confirmButtonColor: "#DD6B55",
//                    confirmButtonText: "确定",
//                },function(){
//                    window.location.reload();
//                });
//                return;
//            }else{
//                $('#menu_box').html(response);
//            }
//        });
//    }
</script>
</body>
</html>
