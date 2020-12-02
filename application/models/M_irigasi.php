<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_irigasi extends CI_Model
{
	public function add($data)
	{
		$this->db->insert('tbl_irigasi', $data);
	}

	public function get_all_data()
	{
		$this->db->select('*');
		$this->db->from('tbl_irigasi');
		$this->db->order_by('id_irigasi', 'desc');
		return $this->db->get()->result();
	}

	public function detail($id_irigasi)
	{
		$this->db->select('*');
		$this->db->from('tbl_irigasi');
		$this->db->where('id_irigasi', $id_irigasi);
		return $this->db->get()->row();
	}

	public function edit($data)
	{
		$this->db->where('id_irigasi', $data['id_irigasi']);
		$this->db->update('tbl_irigasi', $data);
	}

	public function delete($data)
	{
		$this->db->where('id_irigasi', $data['id_irigasi']);
		$this->db->delete('tbl_irigasi', $data);
	}
	//galleri
	public function get_all_galleri()
	{
		$this->db->select('tbl_irigasi.*,count(tbl_galeri_irigasi.id_irigasi) as total_foto');
		$this->db->from('tbl_irigasi');
		$this->db->join('tbl_galeri_irigasi', 'tbl_galeri_irigasi.id_irigasi = tbl_irigasi.id_irigasi', 'left');
		$this->db->group_by('tbl_irigasi.id_irigasi');
		$this->db->order_by('id_irigasi', 'desc');
		return $this->db->get()->result();
	}
	public function detail_galleri($id_irigasi)
	{
		$this->db->select('*');
		$this->db->from('tbl_galeri_irigasi');
		$this->db->where('id_irigasi', $id_irigasi);
		$this->db->order_by('id_irigasi', 'desc');
		return $this->db->get()->result();
	}
	public function delete_foto($data)
	{
		$this->db->where('id_galeri_irigasi', $data['id_galeri_irigasi']);
		$this->db->delete('tbl_galeri_irigasi', $data);
	}
	public function add_foto($data)
	{
		$this->db->insert('tbl_galeri_irigasi', $data);
	}
	public function grafik_irigasi() {
		$this->db->select('nama_irigasi, panjang_jalur');
		$this->db->from('tbl_irigasi');
		return $this->db->get()->result();
	}

}

/* End of file M_lahan.php */

