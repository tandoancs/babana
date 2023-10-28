<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class BillModel extends Model
{
    protected $db;
    protected $table      = 'bill';
    protected $builder;

    protected $primaryKey = 'bill_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['bill_id', 'date_check_in', 'date_check_out', 'total', 'status', 'table_id', 'promotion_id', 'note', 'count_orders', 'sum_orders', 'money_received', 'money_refund' ];
    protected $fields = 'bill_id, date_check_in, date_check_out, total, status, table_id, promotion_id, note, count_orders, sum_orders, money_received, money_refund';

    private $_insertBatch;

    public function __construct(ConnectionInterface &$db)
    {
        // Truyền vào database
        $this->db =& $db;
        // khởi tạo builder lấy bảng mặc định trong model
        $this->builder = $this->db->table($this->table);

    }

    public function setInsertBatch($insertBatch) 
    {
        $this->_insertBatch = $insertBatch;
    }

    public function countAll()
    {
        return $this->builder->countAll();
    }

    public function countOptions($col, $where)
    {
        $count = "COUNT($col) as $col";
        $this->builder->select($count);
        $this->builder->where($where);
        return $this->builder->get()->getResult()[0]->{$col}; 
    }

    public function sumOptions($col, $where, $order = null)
    {
        $sum = "SUM($col) as $col";
        $this->builder->select($sum);
        $this->builder->where($where);
        if ($order != null) 
            $this->builder->orderBy($order, 'asc');
        return $this->builder->get()->getResult()[0]->{$col}; 
    }

    public function readAll($col=null) 
    {
        // get: Lấy tất cả thông tin liên quan truy vấn database
        // getResult: trả về kết quả truy vấn
        if ($col != null) 
            $this->builder->orderBy($col, 'asc');
            
        return $this->builder->select($this->fields)->get()->getResult();
    }
    
    public function readLastItem() 
    {
        $this->builder->select('*');
        $this->builder->orderBy('bill_id', 'desc');
        return $this->builder->get()->getResult()[0];
    }
    public function readItem($where) 
    {
        $this->builder->select('*');
        $this->builder->where($where);
        return $this->builder->get()->getResult()[0];
    }

    public function readOptionsIn($col, $where, $order = null, $sort = null) 
    {
        $this->builder->select('*');
        $this->builder->whereIn($col, $where);
        if ($order != null) {
            if ($sort != null) 
                $this->builder->orderBy($order, $sort);
            else 
                $this->builder->orderBy($order, 'asc');
        }
            
        return $this->builder->get()->getResult();
    }

    

    public function readOptions($where, $col = null) 
    {
        $this->builder->where($where);
        if ($col != null) 
            $this->builder->orderBy($col, 'asc');
        return $this->builder->get()->getResult();
    }

    public function create($data)
    {
        // Cách 1: Có thể truyền dữ liệu bằng phương thức: $this->builder->set('name', $name); Sau đó sử dụng $this->builder->insert();
        // cách 2: truyền vào mảng data cần insert
        return $this->builder->insert($data);
    
    }

    public function createMulti()
    {
        $data = $this->_insertBatch;
        return $this->builder->insertBatch($data);
    }

    public function edit($where, $data)
    {
        $this->builder->where($where);
        return $this->builder->update($data);
    }

    public function del($where)
    {
        $this->builder->where($where);
        return $this->builder->delete();        
    }

    public function isAlreadyExist($where)
    {
        $this->builder->selectCount('bill_id');
        $this->builder->where($where);
        return (($this->builder->get()->getResult()[0]->bill_id) > 0) ? true : false;   
    }



}
