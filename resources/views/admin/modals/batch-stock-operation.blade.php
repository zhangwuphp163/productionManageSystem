<!-- Modal -->
<div class="modal fade" id="batchStockOperationModal" tabindex="-1" role="dialog" aria-labelledby="batchStockOperationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="batchStockOperationModalLabel">批量库存操作</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="box-body">
                        <input type="hidden" id="batchType" value="inbound">
                        <div class="fields-group">
                            <div class="ml-2 mb-2 mr-2" style="margin-top: -0.5rem">
                                <div class="row">
                                    <div class="col-md-4">商品名称</div>
                                    <div class="col-md-4">数量</div>
                                </div>
                                <div id="batch-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                <button type="button" class="btn btn-primary btn-submit" >保 存</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('.batch-edit').on('click', function () {
        var ids = [];
        var batchListHtml = "";
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
                batchListHtml += '<div class="row p-1">' +
                    '<div class="col-md-4"><input type="hidden" name="id" value="'+$(this).data('id')+'" class="form-control"/><input type="text" name="sku_name" value="'+$(this).data('label')+'" class="form-control" readonly/></div>' +
                    //'<div class="col-md-4"><select type=""></select></div><div class="col-md-4"><input type="number" step="1" name="qty[]" value="" class="form-control number"/></div></div>';
                    '<div class="col-md-4"><input type="number" step="1" name="qty" value="" class="form-control number"/></div><button class="btn btn-danger btn-remove-row"><i class="fa fa-remove"></i></button></div>';
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要库存操作的商品");
            return;
        }
        $("#batchStockOperationModalLabel").html($(this).data('title'));
        $("#batchType").val($(this).data('batch-type'));
        $("#batchStockOperationModal").modal().show();
        $("#batch-list").html(batchListHtml);
    });
    $("body").delegate(".btn-remove-row","click",function(){
        $(this).parents(".row").remove();
    })

    $(".btn-submit").click(function(){
        var data = [];
        var flag = true;
        var rowIndex = 1;
        $("#batch-list .row").each(function(){
            var qty = $(this).find("input[name='qty']").val();
            if(qty === ""){
                flag = false;
                return false;
            }
            data.push({id:$(this).find("input[name='id']").val(),qty:qty});
            rowIndex ++;
        });
        if(!flag){
            toastr.error("第"+rowIndex+"行，数量不能为空");
            return;
        }
        $.ajax({
            method:'POST',
            url:"/admin/stocks/batch",
            data:{
                type:$("#batchType").val(),
                rows:data
            },
            beforeSend:function(){
                $("btn").attr("disabled",true);
            },
            success:function (res) {
                if(res.status === 0){
                    toastr.success(res.msg);
                    location.reload();
                }else{
                    toastr.error(res.msg);
                }
            },
            complete:function(){
                $("btn").attr("disabled",false);
            }
        })
    });

</script>
