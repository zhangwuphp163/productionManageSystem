<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Inventory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class InventoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Inventory(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('sku_id');
            $grid->column('asn_id');
            $grid->column('asn_item_id');
            $grid->column('order_id');
            $grid->column('location_id');
            $grid->column('condition');
            $grid->column('receive_at');
            $grid->column('put_away_at');
            $grid->column('confirm_at');
            $grid->column('allocate_at');
            $grid->column('pick_wave_at');
            $grid->column('pick_at');
            $grid->column('pack_at');
            $grid->column('sorting_at');
            $grid->column('second_sort_at');
            $grid->column('handover_at');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Inventory(), function (Show $show) {
            $show->field('id');
            $show->field('sku_id');
            $show->field('asn_id');
            $show->field('asn_item_id');
            $show->field('order_id');
            $show->field('location_id');
            $show->field('condition');
            $show->field('receive_at');
            $show->field('put_away_at');
            $show->field('confirm_at');
            $show->field('allocate_at');
            $show->field('pick_wave_at');
            $show->field('pick_at');
            $show->field('pack_at');
            $show->field('sorting_at');
            $show->field('second_sort_at');
            $show->field('handover_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Inventory(), function (Form $form) {
            $form->display('id');
            $form->text('sku_id');
            $form->text('asn_id');
            $form->text('asn_item_id');
            $form->text('order_id');
            $form->text('location_id');
            $form->text('condition');
            $form->text('receive_at');
            $form->text('put_away_at');
            $form->text('confirm_at');
            $form->text('allocate_at');
            $form->text('pick_wave_at');
            $form->text('pick_at');
            $form->text('pack_at');
            $form->text('sorting_at');
            $form->text('second_sort_at');
            $form->text('handover_at');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
