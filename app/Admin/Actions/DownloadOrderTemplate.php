<?php

namespace App\Admin\Actions;

use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;

/**
 * 下载导入模板
 * Class DownloadTemplate
 *
 * @package App\Admin\Actions
 */
class DownloadOrderTemplate extends Action
{
    /**
     * @return string
     */
    protected $title = '<button class="btn btn-primary"><i class="feather icon-download"></i> 下载导入模板</button>';


    /**
     * Handle the action request.
     *
     * @return Response
     */
    public function handle()
    {
        return $this->response()->download('你的导入模板.xlsx');
    }

}
