@include("mobile.index")
<div class="wrapper">
    <div class="content-body" id="app" >
        {!! $content !!}
    </div>
</div>
<script>
    $().ready(function(){
        $(".fa-search").click(function (){
            var barcode = $("input[name='barcode']").val();
            location.href = "sku?barcode="+barcode;
        });
        $("input[name='barcode']").keypress(function(e){
            if(e.keyCode === 13){
                e.preventDefault();
                var barcode = $("input[name='barcode']").val();
                location.href = "sku?barcode="+barcode;
                return false;
            }
        });
    });
</script>


