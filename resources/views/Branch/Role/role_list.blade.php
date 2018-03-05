<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8"/>
    <title>角色列表 | 零壹云管理平台 | 总分店管理系统</title>
    <link rel="stylesheet" href="{{asset('public/Branch/library')}}/jPlayer/jplayer.flat.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/animate.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/simple-line-icons.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/font.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/app.css" type="text/css"/>
    <link href="{{asset('public/Branch/library')}}/sweetalert/sweetalert.css" rel="stylesheet"/>
    <link href="{{asset('public/Branch/library')}}/iCheck/css/custom.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="{{asset('public/Branch/library')}}/ie/html5shiv.js"></script>
    <script src="{{asset('public/Branch/library')}}/ie/respond.min.js"></script>
    <script src="{{asset('public/Branch/library')}}/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body class="">
<section class="vbox">
    {{--头部--}}
    @include('Branch/Public/Header')
    {{--头部--}}
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
        @include('Branch/Public/Nav')
        <!-- /.aside -->
            <section id="content">
                <section class="vbox">
                    <section class="scrollable padder">
                        <div class="m-b-md">
                            <h3 class="m-b-none">角色列表</h3>
                        </div>
                        <section class="panel panel-default">
                            <header class="panel-heading">
                                角色列表
                            </header>
                            <div class="row wrapper">
                                <form class="form-horizontal" method="get">
                                    <label class="col-sm-1 control-label">角色名称</label>

                                    <div class="col-sm-2">
                                        <input class="input-sm form-control" size="16" type="text" value="">
                                    </div>

                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-s-md btn-info"><i class="fa fa-search"></i>&nbsp;&nbsp;搜索</button>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped b-t b-light">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>角色名称</th>
                                        <th>角色权限</th>
                                        <th>添加时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>财务管理员</td>
                                        <td>
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                        </td>
                                        <td>2017-08-09 11:11:11</td>
                                        <td>
                                            <button class="btn btn-info btn-xs" id="editBtn"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                            <button class="btn btn-danger btn-xs" id="deleteBtn"><i class="fa fa-times"></i>&nbsp;&nbsp;删除</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>财务管理员</td>
                                        <td>
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                        </td>
                                        <td>2017-08-09 11:11:11</td>
                                        <td>
                                            <button class="btn btn-info btn-xs" id="editBtn"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                            <button class="btn btn-danger btn-xs" id="deleteBtn"><i class="fa fa-times"></i>&nbsp;&nbsp;删除</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>财务管理员</td>
                                        <td>
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                        </td>
                                        <td>2017-08-09 11:11:11</td>
                                        <td>
                                            <button class="btn btn-info btn-xs" id="editBtn"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                            <button class="btn btn-danger btn-xs" id="deleteBtn"><i class="fa fa-times"></i>&nbsp;&nbsp;删除</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>财务管理员</td>
                                        <td>
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                            <button data-original-title="订单模块" data-content="订单添加  订单删除  订单查看 订单编辑" data-placement="top" data-trigger="hover" class="btn btn-info btn-xs popovers">订单模块</button>&nbsp;&nbsp;
                                        </td>
                                        <td>2017-08-09 11:11:11</td>
                                        <td>
                                            <button class="btn btn-info btn-xs" id="editBtn"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                            <button class="btn btn-danger btn-xs" id="deleteBtn"><i class="fa fa-times"></i>&nbsp;&nbsp;删除</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <footer class="panel-footer">
                                <div class="row">

                                    <div class="col-sm-12 text-right text-center-xs">
                                        <ul class="pagination pull-right">
                                            <li class="footable-page-arrow disabled">
                                                <a data-page="first" href="#first">«</a>
                                            </li>

                                            <li class="footable-page-arrow disabled">
                                                <a data-page="prev" href="#prev">‹</a>
                                            </li>
                                            <li class="footable-page active">
                                                <a data-page="0" href="#">1</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">2</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">3</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">4</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">5</a>
                                            </li>
                                            <li class="footable-page-arrow">
                                                <a data-page="next" href="#next">›</a>
                                            </li>
                                            <li class="footable-page-arrow">
                                                <a data-page="last" href="#last">»</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </footer>
                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<script src="{{asset('public/Branch')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Branch')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Branch')}}/js/app.js"></script>
<script src="{{asset('public/Branch')}}/js/app.plugin.js"></script>
<script src="{{asset('public/Branch/library')}}/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Branch/library')}}/file-input/bootstrap-filestyle.min.js"></script>
<script src="{{asset('public/Branch/library')}}/jPlayer/jquery.jplayer.min.js"></script>
<script src="{{asset('public/Branch/library')}}/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script src="{{asset('public/Branch/library')}}/sweetalert/sweetalert.min.js"></script>
<script src="{{asset('public/Branch/library')}}/iCheck/js/icheck.min.js"></script>
<script type="text/javascript">
    //获取删除权限角色删除密码确认框
    function getDeleteComfirmForm(id) {
        var url = $('#role_delete_comfirm_url').val();
        var token = $('#_token').val();
        if (id == '') {
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            }, function () {
                window.location.reload();
            });
            return;
        }

        var data = {'id': id, '_token': token};
        $.post(url, data, function (response) {
            if (response.status == '-1') {
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                }, function () {
                    window.location.reload();
                });
                return;
            } else {
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }

    //获取用户信息，编辑密码框
    function getEditForm(id) {
        var url = $('#role_edit_url').val();
        var token = $('#_token').val();

        if (id == '') {
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            }, function () {
                window.location.reload();
            });
            return;
        }

        var data = {'id': id, '_token': token};
        $.post(url, data, function (response) {
            if (response.status == '-1') {
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                }, function () {
                    window.location.reload();
                });
                return;
            } else {
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
</script>
</body>
</html>
