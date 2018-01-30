<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>零壹新科技服务商管理平台</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('public/Proxy')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('public/Proxy')}}/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="{{asset('public/Proxy')}}/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="{{asset('public/Proxy')}}/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('public/Proxy')}}/css/style.css" rel="stylesheet">
    <link href="{{asset('public/Proxy')}}/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('public/Proxy')}}/js/html5shiv.js"></script>
    <script src="{{asset('public/Proxy')}}/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<section id="container" class="">
    <!--header start-->
    <header class="header white-bg">
        @include('Proxy/Public/Header')
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        @include('Proxy/Public/Nav')
    </aside>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="icon-sitemap"></i> 下辖商户管理</a></li>
                        <li class="active">商户列表</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <form class="form-horizontal tasi-form" method="get">

                                <div class="form-group">
                                    <label class="control-label col-lg-1" for="inputSuccess">商户名称</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" placeholder="商户名称">
                                    </div>
                                    <label class="control-label col-lg-1" for="inputSuccess">手机号码</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" placeholder="手机号码">
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-primary"><i class="icon-search"></i> 查询</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        商户列表
                                    </header>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>商户名称</th>
                                            <th>负责人姓名</th>
                                            <th>商户账号</th>
                                            <th>手机号码</th>
                                            <th>商户状态</th>
                                            <th>注册时间</th>
                                            <th class="text-right" >操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                        @foreach($list as $key=>$val)
                                            <td>{{$val->id}}</td>
                                            <td>{{$val->organization_name}}</td>
                                            <td>{{$val->organizationCompanyinfo->company_owner}}</td>
                                            <td>{{$val->account}}</td>
                                            <td>{{$val->organizationCompanyinfo->company_owner_mobile}}</td>
                                            <td>
                                                @if($val->status ==1)
                                                <label class="label label-primary">正常</label>
                                                @else
                                                    <label class="label label-danger">冻结</label>
                                                @endif
                                            </td>
                                            <td>2017-08-08 10:30:30</td>
                                            <td class="text-right">
                                                <button type="button" id="peoplesBtn" onclick="location.href='company_structure.html'" class="btn btn-outline btn-xs btn-primary"><i class="icon-sitemap"></i>&nbsp;&nbsp;店铺结构</button>
                                                <button type="button" id="programBtn" onclick="location.href='company_program.html'" class="btn btn-outline btn-xs btn-info"><i class="icon-code"></i>&nbsp;&nbsp;程序划拨</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="99">
                                                <ul class="pagination pull-right">

                                                </ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
</section>

</body>
</html>

