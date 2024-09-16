<!-- Modal -->
<div class="modal fade" id="batchAddProductToStoreModal" tabindex="-1" role="dialog" aria-labelledby="batchAddProductToStoreModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="batchAddProductToStoreModal">批量添加产品到店铺</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="box-body">
                        <input type="hidden" id="batchType" value="inbound">
                        <div class="fields-group">
                            <div class="ml-2 mb-2 mr-2" style="margin-top: -0.5rem">
                                <select class="form-control" id="store_id" name="store_id">
                                    <option value=""> - 请选择店铺 - </option>
                                    @foreach(\App\Models\Store::get() as $row)
                                        <option value="{{$row->id}}"> {{$row->name}} </option>
                                    @endforeach
                                </select>
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
    $("#batchAddProductToStoreModal .btn-submit").click(function(){
        var store_id = $("#store_id").val();
        if(store_id === ""){
            toastr.error("请选择店铺");
            return;
        }
        $.ajax({
            method:'POST',
            url:"/admin/store-skus/batch-add-product",
            data:{
                ids:ids,
                store_id:store_id
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
