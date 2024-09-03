<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Stock;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Controllers\HasResourceActions;


class StockController extends AdminController
{
    use HasResourceActions;
    protected $title = "库存管理";
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

            return $column->getValue() > 0;
        })

            ->label('#222')
            ->else()
            ->label('danger');

            /*->display(function($qty){

        })->label('#222');*/
        $grid->column('created_at', "创建时间")->display(function ($created_at) {
            return Carbon::parse($created_at)->format('Y-m-d H:i:s');
        });
        $grid->column('updated_at', "更新时间")->display(function ($updated_at) {
            return Carbon::parse($updated_at)->format('Y-m-d H:i:s');
        });

        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            //$actions->disableDelete();
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }
    public function form()
    {
        return Form::make(new Stock(), function (Form $form) {
            //$id = $form->getKey();
            $form->display('id', 'ID');
            $form->text('name', "品类名称")->required();
        });
    }

}
