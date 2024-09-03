<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Forms\InboundForm;
use App\Models\Category;
use App\Models\Sku;
use App\Models\Stock;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Controllers\HasResourceActions;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
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
        $grid = Grid::make(new Sku(),function (Grid $grid){
            $grid->model()->with('category');
        });
        $grid->selector(function (Grid\Tools\Selector $selector) {
            $selector->select('category_id', '品类', Category::query()->pluck('name','id')->toArray());
        });
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
        $grid->stocks("在库数量")->display(function ($stocks){
            return $stocks->where('type','inbound')->sum('qty') - $stocks->where('type','outbound')->sum('qty');
        });

        $grid->column('created_at', "创建时间")->display(function ($created_at) {
            return Carbon::parse($created_at)->format('Y-m-d H:i:s');
        });
        $grid->column('updated_at', "更新时间")->display(function ($updated_at) {
            return Carbon::parse($updated_at)->format('Y-m-d H:i:s');
        });

        //$grid->disableCreateButton();
        $grid->enableDialogCreate();
        $grid->showColumnSelector();

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->quickEdit();
            //$actions->disableDelete();
            $actions->disableEdit();
            $actions->append(new \App\Admin\Actions\Grid\Stock());
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        $grid->filter(function($filter){
            // 展开过滤器
            //$filter->expand(false);
            //$filter->rightSide();
            $filter->panel();
            $filter->like('name', '商品名称')->width(3);
        });


        return $grid;
    }
    public function form()
    {
        return Form::make(new Sku(), function (Form $form) {
            //$id = $form->getKey();
            $form->display('id', 'ID');
            $form->text('name', "商品名称")->required();
            $form->select('category_id','品类')->options(Category::query()->pluck('name','id'))->required();
        });
    }
    protected function detail($id)
    {
        return Show::make($id, Sku::with(['category']), function (Show $show) {
            $show->field('id');
            $show->field('category.name');
            $show->field('name');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }
}
