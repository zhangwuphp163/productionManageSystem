@include('admin::layouts.content')
<style>
    .content-header{
        display: none;
    }
</style>
<script>
    $().ready(function(){
        $(".fa-search").click(function (){
            var orderNumber = $("input[name='order_number']").val();
            location.href = "order?order_number="+orderNumber;
        });
        $("input[name='order_number']").keypress(function(e){
            if(e.keyCode == 13){
                var orderNumber = $("input[name='order_number']").val();
                location.href = "order?order_number="+orderNumber;
                return false;
            }
        })
    });
</script>
