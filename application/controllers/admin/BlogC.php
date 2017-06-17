<?php
class BlogC extends CI_Controller 
{
	public function add()
	{
		/************* 先定义表单验证规则 *************/
		// 导入表单验证类
		$this->load->library('form_validation');
		// 定义规则 
		$this->form_validation->set_rules('title', '标题', 'required|max_length[150]');
		$this->form_validation->set_rules('content', '内容', 'required');
		/************* 验证表单 *************/
		if($this->form_validation->run() === FALSE)
			// 如果验证失败就显示表单，错误信息在表单中显示
			$this->load->view('admin/blogc/add');
		else 
		{
			// 生成日志模型
			$this->load->model('BlogM');
			$this->BlogM->add();
			// 跳转
			redirect(site_url('admin/blogc/lst'));
		}
	}
	public function save($id)
	{
		// 生成日志模型
		$this->load->model('BlogM');
		// 先取出要修改的记录的信息
		$info = $this->BlogM->find($id);
		/************* 先定义表单验证规则 *************/
		// 导入表单验证类
		$this->load->library('form_validation');
		// 定义规则 
		$this->form_validation->set_rules('title', '标题', 'required|max_length[150]');
		$this->form_validation->set_rules('content', '内容', 'required');
		/************* 验证表单 *************/
		if($this->form_validation->run() === FALSE)
			// 如果验证失败就显示表单，错误信息在表单中显示
			$this->load->view('admin/blogc/save', $info);
		else 
		{
			$this->BlogM->save();
			// 跳转
			redirect(site_url('admin/blogc/lst'));
		}
	}
	public function lst()
	{
		// 生成模型
		$this->load->model('BlogM', 'bm');
		$data = $this->bm->search(2);
		$this->load->view('admin/blogc/lst', $data);
	}
	public function delete($id)
	{
		$this->load->model('BlogM', 'bm');
		$data = $this->bm->delete($id);
		redirect(site_url('admin/blogc/lst'));
	}
}


















