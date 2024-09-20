@include("mobile.index")
<div class="wrapper">
    <div class="content-body" id="app" >
        {!! $content !!}
    </div>
    <input type="file" name="123">
</div>
<script>
    $().ready(function(){
        $(".fa-save").click(function (){
            var platform_number = $("#platform_number").val();
            var weight = $("#weight").val();
            var length = $("#length").val();
            var width = $("#width").val();
            var height = $("#height").val();
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
                url:"{{route('mobile.weight')}}",
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                data:{
                    platform_number:platform_number,
                    weight:weight,
                    length:length,
                    width:width,
                    height:height,
                },
                beforeSend:function(){
                    $("btn").attr("disabled",true);
                },
                success:function (res) {
                    if(res.status === 0){
                        toastr.success(res.msg);
                        $("input").val("");
                        $("#platform_number").focus();
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


