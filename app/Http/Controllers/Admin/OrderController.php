<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Extendsions\Tools\BatchAddStock;
use App\Admin\Extendsions\Tools\BatchDeleteStock;
use App\Models\Sku;
use App\Models\Stock;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Controllers\HasResourceActions;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;


class OrderController extends AdminController
{
    use HasResourceActions;
    protected $title = "订单管理";
    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description("列表")
            ->body($this->grid())
            ->view("admin.stock.index");
    }
    protected function grid()
    {
        $grid = new Grid(new Stock());
        $grid->column('id', 'ID')->sortable();
        $grid->column('sku.name', "商品名称")->filter(
            //Grid\Column\Filter\Equal::make()->setColumnName('sku.name')
            Grid\Column\Filter\Like::make()->setColumnName('sku.name')
        );;
        $grid->column('type', "库存类型")->using(['inbound' => '入库', 'outbound' => '出库'])->label([
            'inbound' => 'primary',
            'outbound' => 'danger'
        ])->filter(
            Grid\Column\Filter\In::make([
                'inbound' => '入库',
                'outbound' => '出库'
            ])
        );


        $grid->column('qty', "数量")->if(function ($column) {
            return $this->type == 'inbound';
        })->label('#222')->else()->display(function($qty){
            return 0-$qty;
        })->label('danger');

            /*->display(function($qty){

        })->label('#222');*/
        $grid->column('created_at', "创建时间")->display(function ($created_at) {
            return Carbon::parse($created_at)->format('Y-m-d H:i:s');
        });
        $grid->column('updated_at', "更新时间")->display(function ($updated_at) {
            return Carbon::parse($updated_at)->format('Y-m-d H:i:s');
        });

        //$grid->disableCreateButton();
        $grid->enableDialogCreate();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->quickEdit();
            //$actions->disableDelete();
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
                $actions->add(new BatchDeleteStock('批量删除'));
                //$actions->add(new BatchAddStock('批量操作'));
            });
        });
        //$grid->tools('<a class="btn btn-primary disable-outline">测试按钮</a>');
        //$grid->tools(new \App\Admin\Extendsions\Tools\UserGender());
        //$grid->tools(new BatchAddStock());

        $grid->filter(function($filter){
            // 展开过滤器
            //$filter->expand(false);
            //$filter->rightSide();
            $filter->panel();
            $filter->like('sku.name', '商品名称')->width(3);
            $filter->in('type')->multipleSelect(['inbound' => '入库','outbound' => '出库'])->width(3);;

        });
        //$grid->export();



        return $grid;
    }
    public function form()
    {
        return Form::make(new Stock(), function (Form $form) {
            //$id = $form->getKey();
            $form->display('id', 'ID');
            $form->select('sku_id', "商品名称")->options(Sku::query()->pluck('name','id')->toArray())->required();
            $form->number('qty')->required();
            $form->select('type')->options(['inbound' => '入库','outbound' => '出库'])->required();
            //$form->hidden('inbound_at')->default(Carbon::now());
        });
    }

    public function batch(Request $request)
    {
        try {
            $type = $request->get('type','inbound');
            foreach ($request->get('rows', []) as $row) {
                Stock::create([
                    'sku_id' => $row['id'],
                    'qty' => $row['qty'],
                    'type' => $type
                ]);
            }
            return [
                'status' => 0,
                'msg' => '批量操作成功'
            ];
        }catch (\Exception $e){
            return [
                'status' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }

}
