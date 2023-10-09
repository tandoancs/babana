<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class TransModel extends Model
{
    protected $db;
    protected $table      = 'trans';
    protected $builder;

    protected $primaryKey = 'trans_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['trans_id', 'trans_type', 'trans_name', 'trans_form', 'money', 'status', 'description'];
    protected $fields = 'trans_id, trans_type, trans_name, trans_form, money, status, description';

    private $_insertBatch;

    public function __construct(ConnectionInterface &$db)
    {
        // Truyền vào database
        $this->db = &$db;
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

    public function readAll($col = null, $order = null)
    {
        // get: Lấy tất cả thông tin liên quan truy vấn database
        // getResult: trả về kết quả truy vấn
        if ($col != null)
            if ($order != null) {
                $this->builder->orderBy($col, $order);
            } else {
                $this->builder->orderBy($col, 'desc');
            }

        return $this->builder->select($this->fields)->get()->getResult();
    }

    public function readDistince($col, $order = null)
    {
        // $this->builder->select($col);

        if ($order != null) {
            $this->builder->orderBy($col, $order);
        } else {
            $this->builder->orderBy($col, 'desc');
        }

        // $this->builder->distinct();

        return $this->builder->select($this->fields)->distinct()->get()->getResult();
    }

    public function readItem($where)
    {
        $this->builder->select('*');
        $this->builder->where($where);
        return $this->builder->get()->getResult()[0];
    }

    public function readOptions($where, $col = null)
    {
        $this->builder->where($where);
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
        $this->builder->selectCount('trans_id');
        $this->builder->where($where);
        return (($this->builder->get()->getResult()[0]->trans_id) > 0) ? true : false;
    }
}
