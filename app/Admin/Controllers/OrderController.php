<?php

namespace App\Admin\Controllers;

use App\model\order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new order);

        $grid->order_id('Order id');
        $grid->order_no('Order no');
        $grid->order_amount('Order amount');
        $grid->pay_status('Pay status');
        $grid->user_id('User id');
        $grid->pay_type('Pay type');
        $grid->order_status('Order status');
        $grid->order_text('Order text');
        $grid->create_time('Create time');
        $grid->update_time('Update time');
        $grid->status('Status');
        $grid->pay_time('Pay time');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(order::findOrFail($id));

        $show->order_id('Order id');
        $show->order_no('Order no');
        $show->order_amount('Order amount');
        $show->pay_status('Pay status');
        $show->user_id('User id');
        $show->pay_type('Pay type');
        $show->order_status('Order status');
        $show->order_text('Order text');
        $show->create_time('Create time');
        $show->update_time('Update time');
        $show->status('Status');
        $show->pay_time('Pay time');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new order);

        $form->text('order_no', 'Order no');
        $form->decimal('order_amount', 'Order amount');
        $form->number('pay_status', 'Pay status')->default(1);
        $form->number('user_id', 'User id');
        $form->number('pay_type', 'Pay type');
        $form->number('order_status', 'Order status')->default(1);
        $form->text('order_text', 'Order text');
        $form->number('create_time', 'Create time');
        $form->number('update_time', 'Update time');
        $form->number('status', 'Status')->default(1);
        $form->number('pay_time', 'Pay time');

        return $form;
    }
}
