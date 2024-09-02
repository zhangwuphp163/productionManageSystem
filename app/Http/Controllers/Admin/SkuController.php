<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Forms\InboundForm;
use App\Models\Category;
use App\Models\Sku;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Controllers\HasResourceActions;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Modal;

class SkuController extends AdminController
{
    use HasResourceActions;
    protected $title = "商品管理";
    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description("商品列表")
            ->body($this->grid())
            ->view("admin.sku.index");
    }

    protected function grid()
    {

        $grid = new Grid(new Sku());
        $grid->selector(function (Grid\Tools\Selector $selector) {
            $selector->select('category_id', '品类', Category::query()->pluck('name','id')->toArray());
        });
        //$grid->quickSearch();
        $grid->quickSearch(function ($model, $query) {
            $model->where('name', 'like', "%{$query}%");
        });
        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->select('category_id', '品类')->options(Category::query()->pluck('name','id')->toArray());
            $create->text('name', '商品名称');
            $create->text('barcode', '商品条码');
        });
        $grid->column('id', 'ID')->sortable();
        $grid->column('category.name', "品类名称");//->select(Category::query()->pluck('name','id')->toArray());
        $grid->column('name', "商品名称")->editable();
        /*$grid->column('name', trans('admin.name'));
        $grid->column('roles', trans('admin.roles'))->pluck('name')->label();*/
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
            $actions->disableDelete();
            $actions->append(new \App\Admin\Actions\Grid\Inbound());
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
        return Form::make(new Sku(), function (Form $form) {
            //$id = $form->getKey();
            $form->display('id', 'ID');
            $form->text('name', "商品名称")->required();
            $form->selectTable('category_id', Category::query()->pluck('name','id'))->required();
        });
    }
}
