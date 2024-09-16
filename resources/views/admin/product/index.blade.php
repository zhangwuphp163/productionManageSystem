@include('admin::layouts.content')
@include('admin.modals.confirm')
@include('admin.modals.batch-add-product-to-store')
<script type="text/javascript">
    var ids = [];
    $('.batch-copy').on('click', function () {
        var ids = [];
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要复制的产品");
            return;
        }
        $.ajax({
            method:'POST',
            url:"/admin/products/batch-copy",
            data:{
                ids:ids
            },
            beforeSend:function(){
                $("btn").attr("disabled",true);
            },
            success:function (res) {
                if(res.status === 0){
                    toastr.success(res.msg);
                    window.location.reload()
                }else{
                    toastr.error(res.msg);
                }
            },
            complete:function(){
                $("btn").attr("disabled",false);
            }
        })
    });

    $('.batch-add-store').on('click', function () {
        ids = [];
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要添加的产品");
            return;
        }
        $("#batchAddProductToStoreModal").modal().show();
        /*$.ajax({
            method:'POST',
            url:"/admin/products/batch-copy",
            data:{
                ids:ids
            },
            beforeSend:function(){
                $("btn").attr("disabled",true);
            },
            success:function (res) {
                if(res.status === 0){
                    toastr.success(res.msg);
                    window.location.reload()
                }else{
                    toastr.error(res.msg);
                }
            },
            complete:function(){
                $("btn").attr("disabled",false);
            }
        })*/
    });

</script>


