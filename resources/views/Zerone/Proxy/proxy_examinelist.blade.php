<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>零壹新科技程序管理平台</title>
    <link href="{{asset('public/Zerone/library/bootstrap')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('public/Zerone/library/font')}}/css/font-awesome.css" rel="stylesheet">
    <link href="{{asset('public/Zerone/library/sweetalert')}}/css/sweetalert.css" rel="stylesheet">

    <link href="{{asset('public/Zerone')}}/css/animate.css" rel="stylesheet">
    <link href="{{asset('public/Zerone')}}/css/style.css" rel="stylesheet">



    {{--<link href="{{asset('public/Zerone/library/bootstrap')}}/css/plugins/footable/footable.core.css" rel="stylesheet">--}}
    {{--<!-- Sweet Alert -->--}}
    {{--<link href="{{asset('public/Zerone/library/bootstrap')}}/css/plugins/iCheck/custom.css" rel="stylesheet">--}}
    {{--<link href="{{asset('public/Zerone/library/bootstrap')}}/css/plugins/switchery/switchery.css" rel="stylesheet">--}}
</head>

<body class="">


<div id="wrapper">
    @include('Zerone/Public/Nav')

    <div id="page-wrapper" class="gray-bg">
        @include('Zerone/Public/Header')

        <div class="wrapper wrapper-content animated fadeInRight ecommerce">


            <div class="ibox-content m-b-sm border-bottom">

                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="amount">服务商名称</label>
                            <input type="text" id="amount" name="amount" value="" placeholder="请输入服务商名称" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="amount">手机号码</label>
                            <input type="text" id="amount" name="amount" value="" placeholder="手机号码" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="amount"> &nbsp;</label>
                            <button type="button" class="block btn btn-info"><i class="fa fa-search"></i>搜索</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                            <input type="hidden" id="proxy_examine" value="{{ url('zerone/ajax/proxy_examine') }}">
                            <table class="table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>服务商名称</th>
                                    <th>所在战区</th>
                                    <th>负责人姓名</th>
                                    <th>身份证号</th>
                                    <th>手机号码</th>
                                    <th>申请状态</th>
                                    <th class="col-sm-1">注册时间</th>
                                    <th class="col-sm-2 text-right" >操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key=>$value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->proxy_name}}</td>
                                    <td>{{$value->warzone->zone_name}}</td>
                                    <td>{{$value->proxy_owner}}</td>

                                    <td>{{$value->proxy_owner_idcard}}</td>
                                    <td>{{$value->proxy_owner_mobile}}</td>
                                    <td>
                                        <label class="label label-primary">
                                         @if($value->status==0)
                                                待审核
                                         @elseif($value->status==1)
                                                已通过
                                         @elseif($value->status==-1)
                                                未通过
                                         @endif
                                        </label>
                                    </td>
                                    <td>{{$value->created_at}}</td>
                                    <td class="text-right">
                                        <button type="button" id="okBtn" class="btn  btn-xs btn-primary" onclick="getEditForm({{ $value->id }},this.value)" value="1"><i class="fa fa-check"></i>&nbsp;&nbsp;审核通过</button>
                                        <button type="button" id="notokBtn" class="btn  btn-xs btn-danger" onclick="getEditForm({{ $value->id }},this.value)" value="-1"><i class="fa fa-remove"></i>&nbsp;&nbsp;拒绝通过</button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9" class="footable-visible">
                                        <ul class="pagination pull-right">
                                            {{$list->links()}}
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        @include('Zerone/Public/Footer')

        <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    </div>
</div>

{{--<!-- Page-Level Scripts -->--}}
<script src="{{asset('public/Zerone/library/jquery')}}/js/jquery-2.1.1.js"></script>
<script src="{{asset('public/Zerone/library/bootstrap')}}/js/bootstrap.min.js"></script>
<script src="{{asset('public/Zerone/library/metisMenu')}}/js/jquery.metisMenu.js"></script>
<script src="{{asset('public/Zerone/library/slimscroll')}}/js/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('public/Zerone')}}/js/inspinia.js"></script>
<script src="{{asset('public/Zerone/library/pace')}}/js/pace.min.js"></script>
<script src="{{asset('public/Zerone/library/iCheck')}}/js/icheck.min.js"></script>
<script src="{{asset('public/Zerone/library/sweetalert')}}/js/sweetalert.min.js"></script>

<script src="{{asset('public/Zerone')}}/js/switchery.js"></script>
<script src="{{asset('public/Zerone')}}/js/footable.all.min.js"></script>
<script src="{{asset('public/Zerone')}}/js/bootstrap-datepicker.js"></script>


<script>
$(function(){

    //设置CSRF令牌
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

//审核
function getEditForm(id,status){

    var url = $('#proxy_examine').val();
    var token = $('#_token').val();
    alert(status);
    if(id==''){
        swal({
            title: "提示信息",
            text: '数据传输错误',
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
        },function(){
            window.location.reload();
        });
        return;
    }

    var data = {'id':id,'status':status,'_token':token};
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
