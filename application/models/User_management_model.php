<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management_model extends CI_Model {

	public $db_tabel 	= 'user';
    public $per_halaman = 3;
    public $offset      = 0;

    public function __construct()
	{
        parent::__construct();
	}

	public function load_form_rules_tambah()
    {
    	$form_rules = array(
    		array(
    			'field' => 'id_user',
    			'label' => 'User ID',
    			'rules' => "required|numeric|exact_length[2]|is_unique[$this->db_tabel.id_user]"
    			),
            array(
            	'field' => 'id_employee',
            	'label' => 'Name',
            	'rules' => 'required'
            	),
            array(
            	'field' => 'username',
            	'label' => 'User Name',
            	'rules' => 'required'
            	),
            array(
            	'field' => 'password',
            	'label' => 'Password',
            	'rules' => 'required'
            	),
            array(
            	'field' => 'level',
            	'label' => 'Level',
            	'rules' => 'required'
            	),
        );
        return $form_rules;
    }

    public function validasi_tambah()
    {
        $form = $this->load_form_rules_tambah();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function load_form_rules_edit()
    {
        $form_rules = array(
            array(
    			'field' => 'id_user',
    			'label' => 'User ID',
    			'rules' => "required|max_length[32]|callback_is_id_user_exist"
    			),
            array(
            	'field' => 'id_employee',
            	'label' => 'Name',
            	'rules' => 'required|max_length[32]|callback_is_user_exist'
            	),
            array(
            	'field' => 'username',
            	'label' => 'User Name',
            	'rules' => 'required'
            	),
            array(
            	'field' => 'password',
            	'label' => 'Password',
            	'rules' => 'required'
            	),
            array(
            	'field' => 'level',
            	'label' => 'Level',
            	'rules' => 'required'
            	),
        );
        return $form_rules;
    }

    public function validasi_edit()
    {
        $form = $this->load_form_rules_edit();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }



	public function cari_semua($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }
        // $offset end

        return $this->db->select('user.id_user, employee.name, user.username, user.password, user.level')
                        ->from($this->db_tabel)
                        ->join('employee', 'user.id_employee = employee.id_employee')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('id_user', 'ASC')
                        ->get()
                        ->result();
	}

	public function cari($id_user)
	{
		return $this->db->where('id_user', $id_user)
						->limit(1)
						->get($this->db_tabel)
						->row();
	}

	public function buat_tabel($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array(  'table_open'            => '<table class="table table-bordered table-hover" style="width:100%">',
                        'thead_open'            => '<thead>',
                        'thead_close'           => '</thead>',

                        'heading_row_start'     => '<tr>',
                        'heading_row_end'       => '</tr>',
                        'heading_cell_start'    => '<th>',
                        'heading_cell_end'      => '</th>',

                        'tbody_open'            => '<tbody>',
                        'tbody_close'           => '</tbody>',

                        'row_start'             => '<tr>',
                        'row_end'               => '</tr>',
                        'cell_start'            => '<td>',
                        'cell_end'              => '</td>',

                        'row_alt_start'         => '<tr>',
                        'row_alt_end'           => '</tr>',
                        'cell_alt_start'        => '<td>',
                        'cell_alt_end'          => '</td>',
                        'table_close'           => '</table>');
        $this->table->set_template($tmpl);

        /// heading tabel
        $no_col             = array('data' => 'No', 'class' => 'text-center td_no');
        $user_id_user_col   = array('data' => 'ID User', 'class' => 'text-center td_id_user');
        $user_name_col    	= array('data' => 'Name', 'class' => 'text-center td_name');
        $user_username_col  = array('data' => 'User Name', 'class' => 'text-center td_username');
        $user_password_col 	= array('data' => 'Password(MD5)', 'class' => 'text-center');
        $user_level_col    	= array('data' => 'Level', 'class' => 'text-center');
        $action_col         = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 2);
        $this->table->set_heading($no_col, $user_id_user_col, $user_name_col, $user_username_col, $user_password_col, $user_level_col, $action_col);
        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_user,
                $row->name,
                $row->username,
                $row->password,
                $row->level,
                anchor('user_management/edit/'.$row->id_user,'&nbsp;Edit&nbsp;',array('class' => 'btn btn-warning btn-xs btn-flat center-block')),
                anchor('user_management/delete/'.$row->id_user,'Delete',array('class'=> 'btn btn-danger btn-xs btn-flat center-block','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

    public function paging($base_url)
    {
        $this->load->library('pagination');
        $config = array(
            'base_url'          => $base_url,
            'total_rows'        => $this->hitung_semua(),
            'per_page'          => $this->per_halaman,
            'num_links'         => 4,
            'use_page_numbers'  => TRUE,
            'full_tag_open'     => '<ul class="pagination pagination-sm no-margin pull-right">',
            'prev_link'         =>  '&laquo; Prev',
            'prev_tag_open'     => '<li>',
            'prev_tag_close'    => '</li>',
            'first_link'        => 'First',
            'first_tag_open'    => '<li>',
            'first_tag_close'   => '</li>',
            'cur_tag_open'      => '<li class="active"><a>',
            'cur_tag_close'     => '</a></li>',
            'num_tag_open'      => '<li>',
            'num_tag_close'     => '</li>',
            'next_link'         =>  'Next &raquo;',
            'next_tag_open'     => '<li>',
            'next_tag_close'    => '</li>',
            'last_tag_open'     => '<li>',
            'last_tag_close'    => '</li>',
            'full_tag_close'    => '</ul>',
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    public function hitung_semua()
    {
        return $this->db->count_all($this->db_tabel);
    }

    public function tambah()
    {
        $user_management = array(
                      'id_user' => $this->input->post('id_user'),
                      'id_employee' => $this->input->post('id_employee'),
                      'username' => $this->input->post('username'),
                      'password' => md5($this->input->post('password')),
                      'level' => $this->input->post('level'),
                      );
        $this->db->insert($this->db_tabel, $user_management);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit($id_user)
    {
        $user_management = array(
                      'id_user' => $this->input->post('id_user'),
                      'id_employee' => $this->input->post('id_employee'),
                      'username' => $this->input->post('username'),
                      'password' => md5($this->input->post('password')),
                      'level' => $this->input->post('level'),
                      );

        // update db
        $this->db->where('id_user', $id_user);
		$this->db->update($this->db_tabel, $user_management);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($id_user)
    {
        $this->db->where('id_user', $id_user)->delete($this->db_tabel);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}

/* End of file User_management_model.php */
/* Location: ./application/models/User_management_model.php */