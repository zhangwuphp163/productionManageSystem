<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Store;
use App\Libraries\RouteServer;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class StoreController extends AdminController
{
    use RouteServer;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Store(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('country','国家');
            $grid->column('name');
            //$grid->column('code','店铺代码');
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
        return Show::make($id, new Store(), function (Show $show) {
            $show->field('id');
            $show->field('country');
            $show->field('name');
            //$show->field('code');
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
        return Form::make(new Store(), function (Form $form) {
            $form->display('id');
            $form->text('country');
            $form->text('name');
            //$form->text('code');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
