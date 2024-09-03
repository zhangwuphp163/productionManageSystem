<?php

namespace App\Admin\Extendsions\Tools;

use App\Admin\Renderable\StockTable;
use App\Models\Stock;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;

class BatchAddStock extends BatchAction
{
    protected $action;

    public function __construct($title = null)
    {
        $this->title = $title;
    }
    public function render()
    {
        return Modal::make()
            ->lg()
            ->title('异步加载 - 表格')
            ->body(StockTable::make()) // Modal 组件支持直接传递 渲染类实例
            ->button('打开表格');
        return parent::render(); // TODO: Change the autogenerated stub
    }

    // 确认弹窗信息
    public function confirm()
    {

        //dd($this->getKey());
        return '您确定要批量删除吗？';
    }

    // 处理请求
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();

        // 获取请求参数
        //$action = $request->get('action');

        /** @var Stock $stock */
        foreach (Stock::find($keys) as $stock) {
            $stock->delete();
        }


        return $this->response()->success("")->refresh();
    }

    // 设置请求参数
    public function parameters()
    {
        return [
            'action' => $this->action,
        ];
    }
}
