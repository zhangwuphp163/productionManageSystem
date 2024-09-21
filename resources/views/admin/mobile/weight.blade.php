@include('admin::layouts.content')
<style>
    .content-header{
        display: none;
    }
</style>
<script>
    $().ready(function(){
        $(".fa-save").click(function (){
            var platform_number = $("#platform_number").val();
            var weight = $("#weight").val();
            var length = $("#length").val();
            var width = $("#width").val();
            var height = $("#height").val();
            var images = $("input[name='images']").val();
            if(platform_number == ''){
                toastr.error("请输入平台单号");
                $("#platform_number").focus();
                return false;
            }
            if(weight == '' || weight <= 0){
                $("#weight").focus();
                toastr.error("请输入有效的重量");
                return false;
            }
            $.ajax({
                method:'POST',
                url:"{{route('admin.mobile.weight-save')}}",
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                data:{
                    platform_number:platform_number,
                    weight:weight,
                    length:length,
                    width:width,
                    height:height,
                    images:images
                },
                beforeSend:function(){
                    $("btn").attr("disabled",true);
                },
                success:function (res) {
                    if(res.status === 0){
                        toastr.success(res.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },2000)
                    }else{
                        toastr.error(res.msg);
                    }
                },
                complete:function(){
                    $("btn").attr("disabled",false);
                }
            })
        });

    });
</script>
