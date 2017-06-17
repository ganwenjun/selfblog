<?php
class MY_Model extends CI_Model 
{
	protected $_tableName;
	protected $_insertFieds;
	protected $_updateFieds;
	public function find($id)
	{
		$this->db->from($this->_tableName);
		$this->db->where('id', $id);
		$data = $this->db->get();
		// 转化成二维数组
		$data = $data->result('array');
		return $data[0];
	}
	public function delete($id)
	{
		// 判断子类中是否定义了 _before_delete 方法
		if(method_exists($this, '_before_delete'))
		{
			if($this->_before_delete($id) === FALSE)
				return FALSE;
		}
		return $this->db->delete($this->_tableName, array('id' => $id)); 
	}
	public function add()
	{
		// 接收表单
		$data = array();
		foreach ($this->_insertFields as $v)
			$data[$v] = $this->input->post($v, TRUE);
		// 添加前的钩子函数
		if(method_exists($this, '_before_insert'))
			if($this->_before_insert($data) === FALSE)
				return FALSE;
		// 插入数据库
		$this->db->insert($this->_tableName, $data);
		// 获取新插入的记录的ID
		$data['id'] = $this->db->insert_id();
		// 添加后的钩子函数
		if(method_exists($this, '_after_insert'))
			$this->_after_insert($data);
		return $data['id'];
	}
	public function save()
	{
		// 接收表单中的隐藏域id来修改
		$this->db->where('id', $this->input->post('id'));
		// 接收表单
		$data = array();
		foreach ($this->_updateFields as $v)
			$data[$v] = $this->input->post($v, TRUE);
		// 添加前的钩子函数
		if(method_exists($this, '_before_update'))
			if($this->_before_update($data) === FALSE)
				return FALSE;
		// 更新数据库
		$ret = $this->db->update($this->_tableName, $data);
		// 添加后的钩子函数
		if(method_exists($this, '_after_update'))
			$this->_after_update($data);
		return $ret;
	}
}