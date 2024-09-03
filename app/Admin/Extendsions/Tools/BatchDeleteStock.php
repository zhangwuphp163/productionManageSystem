<?php

namespace App\Admin\Extendsions\Tools;

use App\Models\Stock;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class BatchDeleteStock extends BatchAction
{
    protected $action;

    // 注意action的构造方法参数一定要给默认值
    public function __construct($title = null)
    {
        $this->title = $title;
    }

    // 确认弹窗信息
    public function confirm()
    {
        return '您确定要批量删除吗？';
    }

    // 处理请求
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();

        /** @var Stock $stock */
        foreach (Stock::find($keys) as $stock) {
            $stock->delete();
        }

        return $this->response()->success("批量删除成功")->refresh();
    }

    // 设置请求参数
    public function parameters()
    {
        return [
            'action' => $this->action,
        ];
    }
}
