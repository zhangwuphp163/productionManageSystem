<?php

namespace App\Admin\Metrics\Charts;

use App\Models\Sku;
use Dcat\Admin\Widgets\Metrics\Round;
use Illuminate\Http\Request;

class ChartStocks extends Round
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();
        $this->title('商品库存出入情况');
        $this->chartLabels(['入库', '出库']);
        $data[0] = "全部";
        $skus = Sku::query()->pluck('name','id')->toArray();
        foreach ($skus as $key => $sku) {
            $data[$key] = $sku;
        }
        $this->dropdown($data);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $option = $request->get('option','0');
        if($option){
            $stockInboundQty = \App\Models\Stock::query()->where('sku_id',$option)->where('type','inbound')->sum('qty');
            $stockOutboundQty = \App\Models\Stock::query()->where('sku_id',$option)->where('type','outbound')->sum('qty');
        }else{
            $stockInboundQty = \App\Models\Stock::query()->where('type','inbound')->sum('qty');
            $stockOutboundQty = \App\Models\Stock::query()->where('type','outbound')->sum('qty');
        }

        $this->withContent($stockInboundQty, $stockOutboundQty);

        // 图表数据
        $this->withChart([100, $stockOutboundQty >0 ?\round($stockInboundQty/$stockOutboundQty,2):0]);

        // 总数
        $this->chartTotal('结余', $stockInboundQty - $stockOutboundQty);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 卡片内容.
     *
     * @param int $finished
     * @param int $pending
     * @param int $rejected
     *
     * @return $this
     */
    public function withContent($finished, $pending)
    {
        $rejected = $finished - $pending;
        return $this->content(
            <<<HTML
<div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
    <div class="chart-info d-flex justify-content-between mb-1 mt-2" >
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-primary"></i>
              <span class="text-bold-600 ml-50">入库数量</span>
          </div>
          <div class="product-result">
              <span>{$finished}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-warning"></i>
              <span class="text-bold-600 ml-50">出库数量</span>
          </div>
          <div class="product-result">
              <span>{$pending}</span>
          </div>
    </div>
    <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-danger"></i>
              <span class="text-bold-600 ml-50">结余</span>
          </div>
          <div class="product-result">
              <span>{$rejected}</span>
          </div>
    </div>
</div>
HTML
        );
    }
}
