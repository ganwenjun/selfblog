<?php
class BlogM extends MY_Model 
{
	// 设置添加和修改时允许接收的表单中的字段
	protected $_insertFields = array('title','content','is_show');
	protected $_updateFields = array('title','content','is_show');
	// 定义这个模型对应的表名
	protected $_tableName = 'b39_blog';
	// 翻页、搜索、排序等功能
	public function search($perpage = 5)
	{
		$tableName = 'b39_blog';
		/****************** 搜索 -> 设置where 条件到 $this->db上 *****************/
		// 标题
		$title = $this->input->get('title');
		if($title)
			$this->db->like('title', $title);
		// 是否显示
		$isShow = $this->input->get('is_show');
		if($isShow == '是' || $isShow == '否')
			$this->db->where('is_show', $isShow);
			
		// 先设置将要操作的表名
		$this->db->from('b39_blog');
		/***************** 翻页 ******************/
		// 在前面设置的where的基础上取的总的记录数【取出总的记录数之后默认就把前面设置的所有的where条件都清空了,就会导致后面再取数据时搜索条件就不好使】
		// 第二个参数：是否清空之前设置的where条件,这里设置成FALSE：取总记录数之后前面的WHERE条件还保留，之后取数据时where也还在
		$count = $this->db->count_all_results('', FALSE);
		$this->load->library('pagination');  // 加载分页类
		// 构造配置的数组
		$config['base_url'] = site_url('admin/blogc/lst');
		// 总的记录数
		$config['total_rows'] = $count;
		$config['per_page'] = $perpage; 
		// 翻页时其他的变量继续传
		$config['reuse_query_string'] = TRUE; 
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		// 根据数组配置翻页类
		$this->pagination->initialize($config); 
		// 生成翻页字符串
		$pageString = $this->pagination->create_links();
		// 根据当前页计算偏移量
		$offset = (max(1, (int)$this->pagination->cur_page) - 1) * $perpage;
		
		/**************************************** 排序 ******************************/
		$this->db->order_by('id', 'desc'); 
		
		/****************** 取数据 *****************/
		// 取出日志的数据
		$data = $this->db->get('', $perpage, $offset);
		
		/*******************8 返回数据 **************/
		return array(
			'data' => $data,
			'page' => $pageString,
		);
	}
	protected function _before_insert(&$data)
	{
		$data['addtime'] = date('Y-m-d H:i:s');
	}
}






















