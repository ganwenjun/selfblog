<?php
class IndexC extends CI_Controller 
{
	public function index($name='', $age='')
	{
		$this->input->post('content', TRUE);   // 第二个参数传TRUE就是进行xss过滤 
		// 生成商品模型
		$this->load->model('GoodsM', 'gm');
		$this->gm->getAll();
		// 显示页面
		$this->load->view('indexc/add.html', array(
			'today' => date('Y-m-d H:i:s'),
			'title' => 'php',
		));
	}
}