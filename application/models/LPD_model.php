<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * LPD Model Class.
 *
 * @author alfian purnomo <alfian.pacul@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class LPD_model extends CI_Model
{
    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    function GetDivision()
    {
        $data = $this->db
                ->select('a.*,CONCAT("b.firtsname"," "," b.lastname") as head_of_division_name')
                ->join('master_employee b','a.head_of_division=b.employeeid')
                ->get('master_division a')
                ->result_array();
                // echo $this->db->last_query();
                // die();
        return $data;
    }



    function GetEmployee()
    {
        $data = $this->db
                ->select('a.*,b.nik as f_nik,b.employeeid,b.jobsid')
                ->join('master_employee b','a.id=b.userid')
                ->get('t_data_user a')->result_array();
                
        return $data;
    }

    

    /**
     * Get all admin data.
     *
     * @param array $param
     *
     * @return array|bool $data
     */
    function GetAllData($param = [])
    {
        
        if(is_superadmin() || id_auth_group()==2 ){
            
        }else{
            $employeeid = employeeid();
            $this->db->where('employeeid',$employeeid);
        }
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i = 0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i == 0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'], $param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'], $param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'], 'desc');
            }
        } else {
            $this->db->order_by('id', 'desc');
        }
        $data = $this->db
                ->select('view_travel_bill.*,view_travel_bill.id_travel_bill as id')
                //->where('is_delete',0)
                ->get('view_travel_bill')
                ->result_array();
        
        return $data;
    }

    /**
     * Count records.
     *
     * @param array $param
     *
     * @return int $total_records total records
     */
    function CountAllData($param = [])
    {
        if(is_superadmin() || id_auth_group()==2 ){
            
        }else{
            $employeeid = employeeid();
            $this->db->where('employeeid',$employeeid);
        }
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i = 0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i == 0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->from('view_travel_bill')
                //->where('is_delete',0)
                #->join('master_employee', 'master_employee.employeeid = master_department.head_of_department', 'left')
                
                ->count_all_results();

        return $total_records;
    }

    /**
     * Get admin user detail by id.
     *
     * @param int $id
     *
     * @return array|bool $data
     */
    function GetLPD($id)
    {
        $data = $this->db
                ->where('id_travel_bill',$id)
                ->get('view_travel_bill')
                ->row_array();
        if($data){
            
            $data['detailTravelBill'] = $this->db
                                    ->where('id_travel_bill',$data['id_travel_bill'])
                                    ->where('is_delete',0)
                                    ->get('detail_travel_bill')
                                    ->result_array();
            
               
            
            
        }
                // echo $this->db->last_query();
                // die();
        return $data;
    }

    /**
     * Insert new record.
     *
     * @param array $param
     *
     * @return int $last_id last inserted id
     */
    function InsertRecord($param)
    {
        $this->db->insert('spj_online', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    function InsertTravelBill($param){
        $this->db->insert('travel_bill',$param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    

    /**
     * Update record admin user.
     *
     * @param int   $id
     * @param array $param
     */
    function UpdateRecord($id, $param)
    {
        $this->db
            ->where('id_master_department', $id)
            ->update('master_department', $param);
    }

    /**
     * Delete record.
     *
     * @param int $id
     */
    function DeleteRecord($id)
    {
        
        $this->db
            ->where('id_travel_bill', $id)
            ->update('travel_bill',['is_delete'=>1]);
        
    }

    /**
     * Check exist email.
     *
     * @param string $email
     * @param int    $id
     *
     * @return bool true/false
     */
    function checkExistsLPDName($email, $id = 0)
    {
        if ($id != '' && $id != 0) {
            $this->db->where('id_master_department !=', $id);
        }
        $count_records = $this->db
                ->from('master_department')
                ->where('LCASE(department_name)', strtolower($email))
                ->count_all_results();
        if ($count_records > 0) {
            return false;
        }

        return true;
    }
	
}
/* End of file LPD_model.php */
/* Location: ./application/models/LPD_model.php */
