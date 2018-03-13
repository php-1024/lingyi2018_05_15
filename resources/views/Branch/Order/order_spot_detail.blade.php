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
                            <h3 class="m-b-none">现场订单详情</h3>
                        </div>
                        <div class="row row-sm">
                            <button class="btn btn-s-md btn-success" type="button" onclick="location.href='order_spot'" id="addBtn"><i class="fa fa-reply"></i>&nbsp;&nbsp;返回列表</button>
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                        </div>
                        <div class="col-lg-4">
                            <section class="panel panel-default">

                                <header class="panel-heading font-bold">
                                    现场订单详情
                                </header>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="get">

                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">订单编号</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    {{$order->ordersn}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">用户账号</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    {{$order->account->account}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">微信昵称</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    {{$order->account->account_info->realname}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">联系方式</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    {{$order->account->mobile}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">支付方式</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    <label class="label label-info">
                                                        @if($order->paytype==1)
                                                            余额支付
                                                        @elseif($order->paytype==2)
                                                            在线支付
                                                        @elseif($order->paytype==3)
                                                            货到付款
                                                        @elseif($order->paytype==4)
                                                            现场现金支付
                                                        @elseif($order->paytype==5)
                                                            现场刷卡支付
                                                        @elseif($order->paytype==6)
                                                            现场支付宝支付
                                                        @elseif($order->paytype==7)
                                                            现场微信支付
                                                        @elseif($order->paytype==8)
                                                            线上手动确认付款
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">订单状态</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    @if($order->status==-1)
                                                        <label class="label label-default">已取消</label>
                                                    @elseif($order->status==0)
                                                        <label class="label label-primary">待付款</label>
                                                    @elseif($order->status==1)
                                                        <label class="label label-warning">已付款</label>
                                                    @elseif($order->status==2)
                                                        <label class="label label-success">配送中</label>
                                                    @elseif($order->status==3)
                                                        <label class="label label-info">已完成</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">下单时间</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    <label class="label label-primary">{{$order->created_at}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 text-right" for="input-id-1">订单备注</label>
                                            <div class="col-sm-9">
                                                <div>
                                                    <label class="label label-danger">{{$order->remarks}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group text-center">
                                            @if($order->status==0)
                                                    <button class="btn btn-success" type="button"><i class="fa fa-check"></i>&nbsp;&nbsp;确认付款</button>
                                            @endif
                                            @if($order->status==1 || $order->status==2)
                                                    <button class="btn btn-primary" type="button"><i class="fa fa-check"></i>&nbsp;&nbsp;完成订单</button>
                                            @endif
                                            @if($order->status==0 || $order->status==1 || $order->status==2)
                                                    <button class="btn btn-default" type="button"><i class="fa fa-times"></i>&nbsp;&nbsp;取消订单</button>
                                            @endif
                                            @if($order->status==-1)
                                                    <button class="btn btn-default" type="button"><i class="fa fa-check"></i>&nbsp;&nbsp;已取消</button>
                                            @endif
                                            @if($order->status==3)
                                                    <button class="btn btn-success" type="button"><i class="fa fa-check"></i>&nbsp;&nbsp;已完成</button>
                                            @endif
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                    </form>
                                </div>
                            </section>
                        </div>

                        {{--购物车--}}
                        <div class="col-lg-8">
                            <section class="panel panel-default">
                                <header class="panel-heading font-bold">
                                    购物车 {{$order->account->account_info->realname}} 003号桌 12人
                                </header>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>商品标题</th>
                                            <th>数量</th>
                                            <th>规格</th>
                                            <th>商品价格</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>奇味鸡煲</td>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                米饭 + 辣
                                            </td>
                                            <td>
                                                <input class="input-sm form-control" style="width: 50px;" type="text" value="50">
                                            </td>
                                            <th>
                                                <select name="account" style="width: 100px;" class="form-control form-xs m-b text-xs">
                                                    <option>待上菜</option>
                                                    <option>已上菜</option>
                                                </select>
                                            </th>
                                            <td>
                                                <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-plus"></i></button>
                                                <input type="text" id="exampleInputPassword2" class="text-center" value="1" size="4">
                                                <button type="button" class="btn btn-danger btn-xs"> <i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>麻辣鸡煲</td>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                米饭 + 辣
                                            </td>
                                            <td>
                                                <input class="input-sm form-control" style="width: 50px;" type="text" value="50">
                                            </td>
                                            <th>
                                                <select name="account" style="width: 100px;" class="form-control form-xs m-b text-xs">
                                                    <option>待上菜</option>
                                                    <option>已上菜</option>
                                                </select>
                                            </th>
                                            <td>
                                                <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-plus"></i></button>
                                                <input type="text" id="exampleInputPassword2" class="text-center" value="1" size="4">
                                                <button type="button" class="btn btn-danger btn-xs"> <i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td><label class="label label-info">商品总计</label></td>
                                            <td>
                                                <label class="label label-danger">¥100000.00</label>
                                            </td>
                                            <td></td>
                                            <td><label class="label label-danger">2份</label></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><label class="label label-info">餐位费</label></td>

                                            <td>
                                                <label class="label label-danger">¥12.00</label>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><label class="label label-info">总计</label></td>
                                            <td>
                                                <label class="label label-danger">¥100012.00</label>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-info btn-xs" type="button" id="addBtn"><i class="fa fa-edit"></i>&nbsp;&nbsp;加减菜</button>
                                                <button class="btn btn-danger btn-xs" type="button" id="addBtn"><i class="fa fa-edit"></i>&nbsp;&nbsp;修改价格</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                        {{--购物车--}}

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
<script src="{{asset('public/Branch')}}/library/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Branch')}}/js/app.plugin.js"></script>
<script src="{{asset('public/Branch')}}/library/file-input/bootstrap-filestyle.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch')}}/library/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch')}}/library/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch')}}/library/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="{{asset('public/Branch')}}/library/wizard/js/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#rootwizard').bootstrapWizard({'tabClass': 'bwizard-steps'});
        $('.selected_btn').click(function(){
            $('.selected_btn').removeClass('btn-success').addClass('btn-info');
            $(this).addClass('btn-success').removeClass('btn-info');
        });
        $('.selected_table').click(function(){
            $('.selected_table').removeClass('btn-success').addClass('btn-info');
            $(this).addClass('btn-success').removeClass('btn-info');
        });
    });
</script>
</body>
</html>