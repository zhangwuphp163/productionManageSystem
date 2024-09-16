

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>商品详情</title>
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
        var barcode = $("input[name='barcode']").val();
        location.href = "sku?barcode="+barcode;
    });
    $("input[name='barcode']").keypress(function(e){
        if(e.code === 13){
            e.preventDefault();
            var barcode = $("input[name='barcode']").val();
            location.href = "sku?barcode="+barcode;
        }

    });
</script>
</html>

