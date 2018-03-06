<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>零壹云管理平台 | 分店业务系统</title>
    <link rel="stylesheet" href="{{asset('public/Branch')}}/library/jPlayer/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Branch')}}/css/app.css" type="text/css" />
    <link href="{{asset('public/Branch')}}/library/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="{{asset('public/Branch')}}/library/wizard/css/custom.css" rel="stylesheet" />
    <!--[if lt IE 9]>
    <script src="{{asset('public/Branch')}}/library/ie/html5shiv.js"></script>
    <script src="{{asset('public/Branch')}}/library/ie/respond.min.js"></script>
    <script src="{{asset('public/Branch')}}/library/ie/excanvas.js"></script>
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
                            <h3 class="m-b-none">"主打印机"关联商品</h3>
                        </div>
                        <button class="btn btn-s-md btn-success" type="button" onclick="location.href='printer_list.html'"><i class="fa fa-reply"></i>&nbsp;&nbsp;返回列表</button>
                        <div class="line line-dashed b-b line-lg pull-in"></div>

                        <section class="panel panel-default">
                            <header class="panel-heading">
                                商品列表
                            </header>
                            <div class="row wrapper">
                                <form class="form-horizontal" method="get">
                                    <div class="col-sm-2">
                                        <select name="account" class="form-control m-b">
                                            <option>所有分店</option>
                                            <option>总店</option>
                                            <option>宝能店</option>

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="account" class="form-control m-b">
                                            <option>所有分类</option>
                                            <optgroup label="总店">
                                                <option value="AK">主食</option>
                                                <option value="HI">酒水饮料</option>
                                            </optgroup>
                                            <optgroup label="宝能店">
                                                <option value="AK">主食</option>
                                                <option value="HI">饮料</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <label class="col-sm-1 control-label">商品标题</label>

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
                                        <th style="width:20px;"><label class="checkbox m-n i-checks"><input type="checkbox"><i></i></label></th>
                                        <th>ID</th>
                                        <th>商品标题</th>
                                        <th>商品价格</th>
                                        <th>商品分类</th>
                                        <th>库存</th>
                                        <th>商品状态</th>
                                        <th>隶属分店</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><label class="checkbox m-n i-checks"><input checked="checked" type="checkbox" name="post[]"><i></i></label></td>
                                        <td>1</td>
                                        <td>奇味鸡煲</td>
                                        <td>
                                            100.00
                                        </td>
                                        <td>
                                            <label class="label label-info">主食</label>
                                        </td>
                                        <td>
                                            999
                                        </td>
                                        <td>
                                            <label class="label label-success">在售</label>
                                        </td>
                                        <td>
                                            <label class="label label-primary">刘记鸡煲王-总店</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="checkbox m-n i-checks"><input checked="checked" type="checkbox" name="post[]"><i></i></label></td>
                                        <td>1</td>
                                        <td>奇味鸡煲</td>
                                        <td>
                                            100.00
                                        </td>
                                        <td>
                                            <label class="label label-info">主食</label>
                                        </td>
                                        <td>
                                            999
                                        </td>
                                        <td>
                                            <label class="label label-success">在售</label>
                                        </td>
                                        <td>
                                            <label class="label label-primary">刘记鸡煲王-总店</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="checkbox m-n i-checks"><input checked="checked" type="checkbox" name="post[]"><i></i></label></td>
                                        <td>1</td>
                                        <td>奇味鸡煲</td>
                                        <td>
                                            100.00
                                        </td>
                                        <td>
                                            <label class="label label-info">主食</label>
                                        </td>
                                        <td>
                                            999
                                        </td>
                                        <td>
                                            <label class="label label-success">在售</label>
                                        </td>
                                        <td>
                                            <label class="label label-primary">刘记鸡煲王-总店</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
                                        <td>1</td>
                                        <td>奇味鸡煲</td>
                                        <td>
                                            100.00
                                        </td>
                                        <td>
                                            <label class="label label-info">主食</label>
                                        </td>
                                        <td>
                                            999
                                        </td>
                                        <td>
                                            <label class="label label-success">在售</label>
                                        </td>
                                        <td>
                                            <label class="label label-primary">刘记鸡煲王-总店</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
                                        <td>1</td>
                                        <td>奇味鸡煲</td>
                                        <td>
                                            100.00
                                        </td>
                                        <td>
                                            <label class="label label-info">主食</label>
                                        </td>
                                        <td>
                                            999
                                        </td>
                                        <td>
                                            <label class="label label-success">在售</label>
                                        </td>
                                        <td>
                                            <label class="label label-primary">刘记鸡煲王-总店</label>
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
<!-- App -->
<script src="{{asset('public/Branch')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Branch')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Branch')}}/js/app.js"></script>
<script src="{{asset('public/Branch')}}/js/app.plugin.js"></script>
<script src="{{asset('public/Branch/library')}}/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Branch/library')}}/file-input/bootstrap-filestyle.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch/library')}}/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch/library')}}/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch/library')}}/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#deleteBtn').click(function(){
            $('#myModal').modal();
        });

    });
</script>
</body>
</html>