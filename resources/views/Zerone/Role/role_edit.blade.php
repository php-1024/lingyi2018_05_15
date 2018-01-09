<form method="post" role="form" id="currentForm" action="{{ url('zerone/ajax/role_edit_check') }}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="id" id="id" value="{{ $info->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                修改权限角色
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label">角色名称</label>
                    <div class="col-sm-10"><input type="text" class="form-control" id="edit_module_name" name="module_name" value="{{ $info->role_name }}"></div>
                </div>
                <div style="clear:both"></div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">角色权限</label>
                    <div class="col-sm-4">
                        <select name="from" id="multiselect" class="form-control" style="display: inline-block;" size="15" multiple="multiple">
                            @foreach($node_list as $key=>$val)
                                <option value="{{ $val->id }}" data-position="{{ $key }}">{{ $val->node_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="clear:both"></div>
                <div class="hr-line-dashed"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="return postForm();">保存</button>
            </div>
        </div>
    </div>
</form>
<script src="{{asset('public/Tooling/library/multiselect')}}/js/multiselect.js"></script>
<script>
    $(function(){
        $('#multiselect').multiselect({keepRenderingSort:false});
    });
    //提交表单
    function postForm() {
        var target = $("#currentForm");
        var url = target.attr("action");
        var data = target.serialize();
        $.post(url, data, function (json) {
            if (json.status == -1) {
                window.location.reload();
            } else if(json.status == 1) {
                swal({
                    title: "提示信息",
                    text: json.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
            }else{
                swal({
                    title: "提示信息",
                    text: json.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    //type: "warning"
                });
            }
        });
    }
</script>