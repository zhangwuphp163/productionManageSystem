<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Asn;
use App\Models\AsnItem;
use App\Models\Sku;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Psy\Util\Str;

class AsnController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Asn(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('asn_number');
            $grid->column('status');
            $grid->column('eta_at');
            $grid->column('ata_at');
            $grid->column('remarks');
            $grid->column('sign_in_at');
            $grid->column('start_receive_at');
            $grid->column('invoice_tax_number');
            $grid->column('confirm_at');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            //$grid->enableDialogCreate();

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
        return Show::make($id, new Asn(), function (Show $show) {
            $show->field('id');
            $show->field('asn_number');
            $show->field('status');
            $show->field('eta_at');
            $show->field('ata_at');
            $show->field('remarks');
            $show->field('sign_in_at');
            $show->field('start_receive_at');
            $show->field('invoice_tax_number');
            $show->field('confirm_at');
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
        return Form::make(Asn::with(['items']), function (Form $form) {
            $form->display('id');
            $form->text('asn_number');
            //$form->text('status');
            $form->date('eta_at');
            //$form->text('ata_at');
            $form->text('remarks');
            //$form->text('sign_in_at');
           // $form->text('start_receive_at');
            $form->text('invoice_tax_number');
            //$form->text('confirm_at');
            $form->display('created_at');
            $form->display('updated_at');
            //$form->keyValue("debug");
            $form->table('items', function ($table) {
                $table->select('sku_id','商品')->options(function () {
                    return Sku::query()->pluck('code','id')->toArray();
                })->default(1);
                $table->number('estimated_qty','数量');
                $table->hide('uuid','数量');
            });
        })->saving(function (Form $form) {
            $asnItems = [];
            foreach ($form->input('items')??[] as $item) {
                $asnItems[] = ['sku_id' => $item['sku_id'], 'estimated_qty' => $item['estimated_qty']];
            }
            //$asnItems = collect($asnItems);

            $form->model()->items()->delete();

            /*foreach ($asnItems as $item) {
                $asnItem = new AsnItem();
                $asnItem->asn_id = $form->model()->id; // 假设ASN已经保存并有了ID
                $asnItem->sku_id = $item['sku_id'];
                $asnItem->estimated_qty = $item['estimated_qty'];
                $asnItem->uuid = \Illuminate\Support\Str::uuid();
                $asnItem->save();
            }*/
        });
    }
}
