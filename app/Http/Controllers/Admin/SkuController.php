<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Extendsions\Tools\BatchAddStock;
use App\Admin\Renderable\StockTable;
use App\Models\Category;
use App\Models\Sku;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Controllers\HasResourceActions;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Checkbox;
use Dcat\Admin\Widgets\Modal;

class SkuController extends AdminController
{
    use HasResourceActions;
    protected $title = "商品管理";
    public function index(Content $content)
    {
        $modal = Modal::make()->body("debug");
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description("商品列表")
            ->body($this->grid())
            ->view("admin.sku.index")->with('modal',$modal);
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
        /*$grid->disableRowSelector();
        $grid->rowSelector(function(Grid\Tools\RowSelector $selector){
            return "debug";
        });
        $grid->column('custom_checkbox', '<div class="vs-checkbox-con vs-checkbox-primary checkbox-grid checkbox-grid-header">
    <input type="checkbox" class="select-all grid-select-all">
    <span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span>
</div>')->display(function () {

return  '<div class="vs-checkbox-con vs-checkbox-primary checkbox-grid checkbox-grid-column">
    <input type="checkbox" class="grid-row-checkbox" data-id="'.$this->id.'" data-label="'.$this->name.'">
    <span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span>
</div>';



        })->style('width: 50px;'); // 设置列宽*/
        //$grid->rowSelector()->titleColumn("name");
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
        })->modal('库存详情',function($modal){
            return StockTable::make()->payload(['sku_id' => $modal->getKey()]);
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
                //$actions->add(new BatchAddStock("批量库存操作"));
                $actions->disable(false);
            });
        });

        //$grid->tools("<span class='btn btn-outline-primary create-form'> &nbsp;&nbsp;&nbsp;批量库存操作&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;");
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary batch-edit" data-batch-type="inbound" data-title="批量入库操作">&nbsp;&nbsp;&nbsp;<i class="fa fa-opera"></i> 批量入库操作&nbsp;&nbsp;&nbsp;</a>');
            $tools->append('<a href="javascript:void(0);" class="btn btn-outline-danger batch-edit" data-batch-type="outbound" data-title="批量出库操作">&nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i> 批量出库操作&nbsp;&nbsp;&nbsp;</a>');
        });


        /*$grid->script('init', "
            $('.batch-edit').on('click', function () {
            alert(213);
                var ids = [];
                $('.grid-row-checkbox.checked').each(function () {
                    ids.push($(this).data('id'));
                });

                // 使用ids进行进一步操作，如打开模态框并显示这些ID
                console.log(ids);
                // 示例：打开模态框，并传递ids到模态框中
                // $('#myModal').modal('show').find('#selected-ids').val(ids.join(','));
            });
        ");*/
        $grid->filter(function($filter){
            // 展开过滤器
            //$filter->expand(false);
            //$filter->rightSide();
            $filter->panel();
            $filter->like('name', '商品名称')->width(3);
        });
        $grid->tableCollapse(false);
        //$grid->simplePaginate();

        //Form::make()
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
