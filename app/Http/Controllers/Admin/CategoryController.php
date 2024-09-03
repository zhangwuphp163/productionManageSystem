<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Controllers\HasResourceActions;
use Dcat\Admin\Http\Repositories\Administrator;


class CategoryController extends AdminController
{
    use HasResourceActions;
    protected $title = "品类管理";
    protected function grid()
    {

        $grid = new Grid(new Category());
        /*$grid->selector(function (Grid\Tools\Selector $selector) {
            $selector->select('brand', '品牌', [
                1 => '华为',
                2 => '小米',
                3 => 'OPPO',
                4 => 'vivo',
            ]);
        });*/
        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', '品类名称');
        });
        $grid->column('id', 'ID')->sortable();
        $grid->column('name', "品类名称")->editable();
        /*$grid->column('name', trans('admin.name'));
        $grid->column('roles', trans('admin.roles'))->pluck('name')->label();*/
        $grid->column('created_at', "创建时间")->display(function ($created_at) {
            return Carbon::parse($created_at)->format('Y-m-d H:i:s');
        });
        $grid->column('updated_at', "更新时间")->display(function ($updated_at) {
            return Carbon::parse($updated_at)->format('Y-m-d H:i:s');
        });

        //$grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->quickEdit();
            //$actions->disableDelete();
        });
        $grid->enableDialogCreate();
        $grid->showColumnSelector();
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }
    public function form()
    {
        return Form::make(new Category(), function (Form $form) {
            //$id = $form->getKey();
            $form->display('id', 'ID');
            $form->text('name', "品类名称")->required();
        });
    }

}
