<?php
class Search_Model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	

	public function record_count()
	{
		return $this->db->count_all('Country');
	}
	
	public function search_record_count($searchterm)
	{
		$sql = "SELECT COUNT(*) As cnt FROM Country WHERE Continent LIKE '%" . $searchterm . "%'";
		$q = $this->db->query($sql);
		$row = $q->row(); 
		return $row->cnt;
	}
	
	public function search($searchterm,$limit)
	{
		$sql = "SELECT * FROM Country 
				WHERE Continent LIKE '%" . $searchterm . "%' LIMIT " .$limit . ",20";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		else
		{
			return 0;
		}
	}

	public function fetch_countries($limit,$start)
	{
		$this->db->limit($limit,$start);
		$query = $this->db->get('Country');
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}

			return $data;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function searchterm_handler($searchterm)
	{
		if($searchterm)
		{
			$this->session->set_userdata('searchterm', $searchterm);
			return $searchterm;
		}
		elseif($this->session->userdata('searchterm'))
		{
			$searchterm = $this->session->userdata('searchterm');
			return $searchterm;
		}
		else
		{
			$searchterm ="";
			return $searchterm;
		}
	}
	
}
?>