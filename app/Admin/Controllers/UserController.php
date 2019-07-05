<?php

namespace App\Admin\Controllers;

use App\model\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
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
        $grid = new Grid(new User);

        $grid->user_id('User id');
        $grid->user_email('User email');
        $grid->user_code('User code');
        $grid->user_pwd('User pwd');
        $grid->user_tel('User tel');
        $grid->create_time('Create time');
        $grid->user_pwd1('User pwd1');
        $grid->user_error_time('User error time');
        $grid->user_error_num('User error num');
        $grid->user_name('User name');

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
        $show = new Show(User::findOrFail($id));

        $show->user_id('User id');
        $show->user_email('User email');
        $show->user_code('User code');
        $show->user_pwd('User pwd');
        $show->user_tel('User tel');
        $show->create_time('Create time');
        $show->user_pwd1('User pwd1');
        $show->user_error_time('User error time');
        $show->user_error_num('User error num');
        $show->user_name('User name');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('user_email', 'User email');
        $form->number('user_code', 'User code');
        $form->text('user_pwd', 'User pwd');
        $form->text('user_tel', 'User tel');
        $form->number('create_time', 'Create time');
        $form->text('user_pwd1', 'User pwd1');
        $form->number('user_error_time', 'User error time');
        $form->number('user_error_num', 'User error num');
        $form->text('user_name', 'User name');

        return $form;
    }
}
