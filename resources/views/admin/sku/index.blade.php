@include('admin::layouts.content')

    <script type="text/javascript">

        $('.batch-edit').on('click', function () {
            var ids = [];
            $('.grid-row-checkbox').each(function () {
                if($(this).is(':checked')){
                    ids.push($(this).data('id'));
                }
            });

            console.log(ids)
            if(ids.length === 0){
                toastr.error("请选择要编辑的商品");
                return;
            }
        });

    </script>

