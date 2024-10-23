<?php

class MY_Model extends CI_Model {

    protected $table;
    protected $fields;
    protected $primaryKey;

    public function __construct($table)
    {
        parent::__construct();

        $this->table = $table;

        if ($fields = $this->db->field_data($this->table)) {
            foreach ($fields AS $field)
            {
                if ($field->primary_key) {
                    $this->primaryKey = $field->name;
                }

                $this->fields[$field->name] = array(
                    'type' => $field->type,
                    'max_length' => $field->max_length,
                    'default' => $field->default
                );
            }
        }

    }

    public function get($key)
    {
        if ($key) {
            $this->db->where($this->primaryKey, $key);
            return $this->getRow();
        }

        return FALSE;
    }

    public function getByFilter(Array $filters, $limit = 0)
    {
        foreach ($filters AS $key => $filter) {
            if (array_key_exists($key, $this->fields)) {
                $this->db->where($key, $filter);
            }
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->getRows();
    }

    public function getAll($limit = 0)
    {
        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->getRows();
    }

    public function getLast()
    {
        $this->db->order_by($this->primaryKey, 'DESC');
        $this->db->limit(1);

        return $this->getRow();
    }

    public function getLastFew($limit = 20)
    {
        $this->db->order_by($this->primaryKey, 'DESC');
        $this->db->limit($limit);

        return $this->getRows();
    }

    public function insert($data)
    {
        if (array_key_exists($this->primaryKey, $data)) {
            if (!$data[$this->primaryKey]) {
                $data[$this->primaryKey] = NULL;
            }
        }

        $data = $this->prepareColumns($data);

        if (count($data)) {
            if ($this->db->insert($this->table, $data)) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }

    public function replace($data)
    {
        $data = $this->prepareColumns($data);

        if (count($data)) {
            if ($this->db->replace($this->table, $data)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function update($key, $data)
    {
        if (array_key_exists($this->primaryKey, $data)) {
            unset($data[$this->primaryKey]);
        }

        $data = $this->prepareColumns($data);

        if (count($data))
        {
            $this->db->where($this->primaryKey, $key);

            if ($this->db->update($this->table, $data)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function updateAll($data)
    {
        if (array_key_exists($this->primaryKey, $data)) {
            unset($data[$this->primaryKey]);
        }

        $data = $this->prepareColumns($data);

        if (count($data)) {
            if ($this->db->update($this->table, $data)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function delete($key)
    {
        $this->db->where($this->primaryKey, $key);

        if ($this->db->delete($this->table)) {
            return TRUE;
        }

        return FALSE;
    }

    public function truncate()
    {
        if ($this->db->truncate($this->table)) {
            return TRUE;
        }

        return FALSE;
    }

    public function getRow()
    {
        $this->db->from($this->table);

        if ($query = $this->db->get()) {
            return $query->row_array();
        }

        return FALSE;
    }

    public function getRows()
    {
        $this->db->from($this->table);

        if ($query = $this->db->get()) {
            if (count($query->result_array())) {
                return $query->result_array();
            }
        }

        return FALSE;
    }

    public function setResultKey($rows, $keyField)
    {
        $result = array();

        foreach ($rows AS $row) {
            $result[$row[$keyField]] = $row;
        }

        return $result;
    }
    
    public function prepareColumns($data)
    {
        $result = array();

        if (is_array($data) && count($data)) {
            foreach ($data AS $name => $value) {
                if (array_key_exists($name, $this->fields)) {
                    if ($value) {
                        if (is_array($value)) {
                            $result[$name] = json_encode($value);
                        } else {
                            $result[$name] = trim($value);
                        }
                    } else {
                        $result[$name] = $value;
                    }
                }
            }
        }

        return $result;
    }

    public function buildSelect($columns = array())
    {
        $select = FALSE;

        if (is_array($columns) && count($columns))
        {
            $select = $this->primaryKey.', ';

            foreach ($columns AS $column) {
                if (array_key_exists($column, $this->fields) && $column != $this->primaryKey) {
                    $select .= $column . ', ';
                }
            }

            $select = substr($select, 0, -2);
        }

        return $select;
    }

}
