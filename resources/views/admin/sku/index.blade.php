@include('admin::layouts.content')
@include('admin.modals.batch-stock-operation')
<script type="text/javascript">

    $('.batch-print').on('click', function () {
        var ids = [];
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要打印的商品");
            return;
        }
        $.ajax({
            method:'POST',
            url:"/admin/skus/print-label",
            data:{
                ids:ids
            },
            beforeSend:function(){
                $("btn").attr("disabled",true);
            },
            success:function (res) {
                if(res.status === 0){
                    toastr.success(res.msg);
                    window.open(res.url)
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


