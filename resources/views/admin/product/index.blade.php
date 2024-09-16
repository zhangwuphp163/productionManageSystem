@include('admin::layouts.content')
@include('admin.modals.confirm')
<script type="text/javascript">

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

</script>


