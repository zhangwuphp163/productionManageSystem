<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Location;
use App\Libraries\RouteServer;
use App\Models\LocationShelf;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LocationController extends AdminController
{
    use RouteServer;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Location(), function (Grid $grid) {
            $grid->model()->with(['locationShelf']);
            $grid->column('id')->sortable();
            $grid->column('code');
            $grid->column('location_shelf.code',trans('location-shelf.fields.code'));
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->quickEdit();
                $actions->disableEdit();
            });
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
        return Show::make($id, new Location(), function (Show $show) {
            $show->field('id');
            $show->field('code');
            $show->field('location_shelf_id');
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
        return Form::make(new Location(), function (Form $form) {
            $form->display('id');
            $form->text('code')->required();
            $form->select('location_shelf_id')->options(LocationShelf::query()->pluck('code','id')->toArray())->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
