

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>订单详情</title>
    {!! Dcat\Admin\Admin::asset()->headerJsToHtml() !!}
    {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}
    <style>
        .label{color:#414750 !important;font-size: 15px;}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content-body" id="app" >
            {!! $content !!}
        </div>
    </div>
</body>
<script>
    $(".fa-search").click(function (){
        var orderNumber = $("input[name='order_number']").val();
        location.href = "order?order_number="+orderNumber;
        console.log("debug")
    });
</script>
</html>

