<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LocationShelf;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LocationShelfController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LocationShelf(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('code');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->quickEdit();
                $actions->disableEdit();
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
        return Show::make($id, new LocationShelf(), function (Show $show) {
            $show->field('id');
            $show->field('code');
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
        return Form::make(new LocationShelf(), function (Form $form) {
            $form->display('id');
            $form->text('code')->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
