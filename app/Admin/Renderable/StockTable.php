<?php

namespace App\Admin\Renderable;

use Carbon\Carbon;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class StockTable extends LazyRenderable
{

    public function grid(): Grid
    {
        return Grid::make(new \App\Models\Stock(['sku']), function (Grid $grid) {
            $grid->model()->where('sku_id',$this->payload['sku_id']);
            $grid->column('id');
            $grid->column('sku.name');
            $grid->column('sku.name', "商品名称")->filter(
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
            $grid->column('created_at', "创建时间")->display(function ($created_at) {
                return Carbon::parse($created_at)->format('Y-m-d H:i:s');
            });
            $grid->column('updated_at', "更新时间")->display(function ($updated_at) {
                return Carbon::parse($updated_at)->format('Y-m-d H:i:s');
            });



            $grid->paginate(5);
            $grid->disableActions();

            $grid->filter(function($filter){
                // 展开过滤器
                //$filter->expand(false);
                //$filter->rightSide();
                $filter->panel();
                $filter->like('sku.name', '商品名称')->width(3);
                $filter->in('type')->multipleSelect(['inbound' => '入库','outbound' => '出库'])->width(3);;

            });
        });
    }
}
