@foreach($spec as $key=>$val)
<form method="get" role="form" id="searchForm" action="">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    <input type="hidden" id="spec_item_add" value="{{ url('branch/ajax/spec_item_add') }}">
    <div class="m-t">
        <label class="label label-primary">{{$val->name}}</label>
        <button type="button" class="btn editBtn btn-info btn-xs" onclick="editSpec('{{$val->id}}')"><i class="fa fa-edit"></i></button>
        <button type="button" class="btn deleteBtn btn-danger btn-xs" onclick="deleteSpec('{{$val->id}}')"><i class="fa fa-times"></i></button>
    </div>
    <div class="m-t">
        @foreach($val->catering_spec_item as $k=>$v)
        <div class="m-t col-lg-2">
            <label class="label label-success">{{$v->name}}</label>
            <button type="button" class="btn editBtn btn-info btn-xs" onclick="editSpecItem('{{$val->id}}')"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn deleteBtn btn-danger btn-xs" onclick="deleteSpecItem('{{$val->id}}')"><i class="fa fa-times"></i></button>
        </div>
        @endforeach
        <div class="m-t col-lg-2">
            <button type="button" class="btn btn-info btn-xs" onclick="addSpecItem('{{$val->id}}','{{$val->goods_id}}')"><i class="fa fa-plus"></i>&nbsp;&nbsp;添加规格子项</button>
        </div>
    </div>
    <div style="clear: both;"></div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
</form>
@endforeach

<script>
    //编辑规格类
    function editSpec(spec_id) {
        console.log(spec_id);
    }
    //删除规格类
    function deleteSpec(spec_id) {
        console.log(spec_id);
    }
    //编辑子规格
    function editSpecItem(spec_id) {
        console.log(spec_id);
    }
    //删除子规格
    function deleteSpecItem(spec_id) {
        console.log(spec_id);
    }

    //弹出子规格添加页面
    function addSpecItem(spec_id,goods_id) {
        var url = $('#spec_item_add').val();
        var token = $('#_token').val();
        if(spec_id==''  || goods_id==''){
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
        var data = {'spec_id':spec_id,'goods_id':goods_id,'_token':token};
        console.log(data)
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
                $('#myModal_Spec_Item').html(response);
                $('#myModal_Spec_Item').modal();
            }
        });
    }
</script>