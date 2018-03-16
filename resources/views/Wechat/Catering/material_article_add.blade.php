<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>零壹云管理平台 | 总分店管理系统</title>
    <link rel="stylesheet" href="{{asset('public/Catering')}}/js/jPlayer/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/app.css" type="text/css" />
    <link href="{{asset('public/Catering')}}/sweetalert/sweetalert.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/trumbowyg/design/css/trumbowyg.css">
    <!--[if lt IE 9]>
    <script src="{{asset('public/Catering')}}/js/ie/html5shiv.js"></script>
    <script src="{{asset('public/Catering')}}/js/ie/respond.min.js"></script>
    <script src="{{asset('public/Catering')}}/js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body class="">
<section class="vbox">
    <header class="bg-white-only header header-md navbar navbar-fixed-top-xs">
        @include('Catering/Public/Header')
    </header>
    <section>
        <section class="hbox stretch">

            <!-- .aside -->
            <aside class="bg-black dk aside hidden-print" id="nav">
                <section class="vbox">
                    <section class="w-f-md scrollable">
                        @include('Catering/Public/Nav')
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
                                <a href="{{url('api/catering/material_image')}}" class="list-group-item">
                                    图片素材
                                </a>
                                <a href="{{url('api/catering/material_article')}}" class="list-group-item active">
                                    图文素材
                                </a>

                                </div>
                            </section>
                        </section>
                    </aside>
                    <!-- / side content -->
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder-lg">
                                <h2 class="font-thin m-b">添加单条图文</h2>
                                <div class="row row-sm">
                                    <button class="btn btn-s-md btn-success" type="button" onclick="location.href='{{url('api/catering/material_article')}}'" id="addBtn"><i class="fa fa-reply"></i>&nbsp;&nbsp;返回列表</button>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                </div>
                                <section class="panel panel-default">
                                    <header class="panel-heading font-bold">
                                        添加单条图文
                                    </header>
                                    <div class="panel-body">
                                        <form class="form-horizontal" method="get">
                                            <input type="hidden" id="material_image_select_url" value="{{ url('api/ajax/meterial_image_select') }}">
                                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">图片</label>
                                                <div class="col-sm-10">
                                                    <button class="btn btn-info" type="button" onclick="selectImageForm(0);">选择图片素材</button>
                                                </div>
                                            </div>

                                            <div class="line line-dashed b-b line-lg pull-in"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-id-1">标题</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="input-id-1" value="">
                                                </div>
                                            </div>

                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-id-1">作者</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="input-id-1" value="">
                                                </div>
                                            </div>

                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-id-1">摘要</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" rows="5"></textarea>
                                                </div>
                                            </div>

                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-id-1">正文</label>
                                                <div class="col-sm-10">
                                                    <textarea id="form-content" class="editor" cols="30" rows="10"> </textarea>
                                                </div>
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>

                                            <div class="form-group">
                                                <div class="col-sm-12 col-sm-offset-6">

                                                    <button type="button" class="btn btn-success" id="save_btn">保存信息</button>
                                                </div>
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                        </form>
                                    </div>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<script src="{{asset('public/Catering')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Catering')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Catering')}}/js/app.js"></script>
<script src="{{asset('public/Catering')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Catering')}}/js/app.plugin.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/js/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/js/jPlayer/demo.js"></script>

<script src="{{asset('public/Catering')}}/js/wysiwyg/jquery.hotkeys.js"></script>
<script src="{{asset('public/Catering')}}/js/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{{asset('public/Catering')}}/js/wysiwyg/demo.js"></script>

<script type="text/javascript" src="{{asset('public/Catering')}}/sweetalert/sweetalert.min.js"></script>
<script src="{{asset('public/Catering')}}/js/file-input/bootstrap-filestyle.min.js"></script>
<script src="{{asset('public/Catering')}}/trumbowyg/trumbowyg.js"></script>


<script src="{{asset('public/Catering')}}/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>

<script src="{{asset('public/Catering')}}/trumbowyg/plugins/base64/trumbowyg.base64.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#form-content').trumbowyg({

            lang: 'fr',

            closable: false,

            mobile: true,

            fixedBtnPane: true,

            fixedFullWidth: true,

            semantic: true,

            resetCss: true,

            autoAjustHeight: true,

            autogrow: true

        });
        $('#save_btn').click(function(){
            swal({
                title: "温馨提示",
                text: "操作成功",
                type: "success"
            });
        });
    });

    //弹出图片上传框
    function selectImageForm(i){
        var url = $('#material_image_select_url').val();
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

                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
</script>
</body>
</html>