<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
	public function login($username, $password)
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where(array(
			'username' => $username,
			'password' => $password
		));
		return $this->db->get()->row();
	}

	public function ubah_password($data)
	{
		$query = $this->db->query("UPDATE tbl_user SET password='$data[pass1]', username='$data[newuser]' WHERE username='$data[user]'");
		if($query == TRUE) {
			echo "<script>
					alert('Password Berhasil diubah!');
					window.location.href='login';
				  </script>";
		}
	}
}
