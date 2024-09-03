<?php

namespace App\Admin\Forms;

use App\Models\Sku;
use App\Models\Stock;
use Carbon\Carbon;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class StockForm extends Form
{
    use LazyWidget;

    public function handle(array $input)
    {
        $id = $this->payload['id'] ?? null;
        $qty = $input['qty']??0;
        $type = $input['type']??'inbound';
        if (!$id) {
            return $this->response()->error('参数错误');
        }

        $sku = Sku::query()->find($id);

        /*if($type == 'outbound'){
            $qty = 0 - $qty;
        }*/
        Stock::create([
            'sku_id' => $sku->id,
            'qty' => $qty,
            //'inbound_at' => Carbon::now(),
            'type' => $type
        ]);

        return $this->response()->success('入库成功')->refresh();
    }

    public function form()
    {
        $this->display('name','商品名称');
        $this->number('qty','入库数量')->autofocus()->required();
        $this->select('type','操作类型')->options([
            'inbound' => '入库',
            'outbound' => '出库',
            //'rework' => '返工',
            //'damage' => '破损'
        ])->default("inbound");
    }
    public function default()
    {
        return [
            'name' => $this->payload['name']
        ];
    }


}


