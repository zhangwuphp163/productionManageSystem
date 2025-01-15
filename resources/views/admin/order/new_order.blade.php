@include('admin::layouts.content')
<script type="text/javascript">
    //var url = new URL(window.location.href);
    /*var columns = url.searchParams.get('_columns_');
    if(columns == null){
        //获取本地缓存的columns
        var localColumns = localStorage.getItem('dcat-admin-new-order-columns');
        if(localColumns != null){
            window.location.href = url + "?_columns_="+localColumns
        }
    }else{
        localStorage.setItem('dcat-admin-new-order-columns',columns);
    }*/
    $('.batch-print').on('click', function () {
        var ids = [];
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要打印的订单");
            return;
        }
        $.ajax({
            method:'POST',
            url:"/admin/new-orders/print-label",
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
    $('.btn-export').on('click', function () {
        var ids = [];
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要导出订单");
            return;
        }
        window.open('/admin/new-orders/export?ids='+ids.join(","))
    });
    var ids = [];
    $('.batch-copy').on('click', function () {
        var ids = [];
        $('.grid-row-checkbox').each(function () {
            if($(this).is(':checked')){
                ids.push($(this).data('id'));
            }
        });
        if(ids.length === 0){
            toastr.error("请选择要复制的订单");
            return;
        }
        $.ajax({
            method:'POST',
            url:"/admin/new-orders/batch-copy",
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
    $(".btn-search-track").click(function(){
        alert($(this).data('href'))
        window.open($(this).data('href'));
    });
</script>


