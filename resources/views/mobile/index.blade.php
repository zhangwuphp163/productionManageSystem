

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>{!! $title !!}</title>
    {!! Dcat\Admin\Admin::asset()->headerJsToHtml() !!}
    {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}
    <link rel="stylesheet" href="{{asset("css/toastr.css")}}">
    <style>
        .label{color:#414750 !important;font-size: 15px;}
    </style>
</head>
<body>
<div class="row toc-menu-btn">
    <a class="btn btn-success col-4" href="{{route('mobile.order')}}">订单查看</a>
    <a class="btn btn-info col-4" href="{{route('mobile.sku')}}">产品查看</a>
    <a class="btn btn-warning col-4" href="{{route('mobile.weight')}}">重量尺寸</a>
</div>
</body>
<script type="text/javascript" src="{{asset("js/toastr.js")}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    toastr.options = {
        closeButton: false,
        debug: false,
        progressBar: false,
        positionClass: "toast-top-center",
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };
</script>
</html>

