<?php

class Tables
{
    // Object properties
    public $attributes = array("class" => "table");
    public $columns = array();
    public $data = array();
    public $actions = array();
    
    // CodeIgniter super-object
    protected $CI;
    
    // Constructor function
    public function __construct(array $parameters = array())
    {
        $this->CI =& get_instance();

        $this->CI->load->helper(array('array'));

        $columns = array();
        $data = array();

        if (array_key_exists('attributes', $parameters)) {
            $this->attributes = $parameters['attributes'];
        }

        if (array_key_exists('columns', $parameters)) {
            $columns = $parameters['columns'];
        }

        if (array_key_exists('data', $parameters)) {
            $data = $parameters['data'];
        }

        if (array_key_exists('actions', $parameters)) {
            $this->actions = $parameters['actions'];
        }

        if (is_array($data) && count($data))
        {
            $firstRow = reset($data);

            if (is_array($columns) && count($columns))
            {
                foreach ($columns AS $key => $value)
                {
                    if (is_array($value)) {
                        $this->columns[$key] = $value;
                    } else {
                        $this->columns[$key] = array();
                    }

                    if (!isset($value['title'])) {
                        $this->columns[$key]['title'] = $key;
                    }

                    if (!isset($value['format'])) {
                        $this->columns[$key]['format'] = 'text';
                    }
                }
            } else {
                foreach ($firstRow AS $key => $value) {
                    $this->columns[$key] = array('title' => $key, 'format' => 'text');
                }
            }

            if (keys_are_equal($firstRow, $this->columns)) {
                foreach ($data as $rowNum => $row) {
                    $this->data[$rowNum] = $row;
                }
            } else {
                foreach ($data as $rowNum => $row) {
                    foreach ($this->columns as $key => $column) {
                        $this->data[$rowNum][$key] = $row[$key];
                    }
                }
            }

        }

    }

    // Output function
    public function render()
    {
        $result = $this->getTableHeader();

        if (count($this->columns))
        {
            $totals = array();

            $result = $this->getRowHeader($result);

            foreach ($this->data AS $dataRow)
            {
                $id = 0;

                $result .= '<tr>';

                foreach ($dataRow AS $key => $value)
                {
                    if ($value)
                    {
                        switch ($this->columns[$key]['format'])
                        {
                            case 'date' :
                                $dateFormat = 'd-m-y';
                                if (isset($this->columns[$key]['date_format'])) {
                                    $dateFormat = $this->columns[$key]['date_format'];
                                }

                                $result .= '<td>' . date($dateFormat, strtotime($value)) . '</td>';
                                break;

                            case 'number' :
                            case 'currency' :
                            case 'crypto' :
                            case 'percentage' :
                                $result .= '<td>' . formatNumber($value, $this->columns[$key]) . '</td>';
                                break;

                            case 'image' :
                                $images = explode('|', $value);
                                $result .= '<td><img src="' . reset($images) . '" width="75" height="75"></td>';
                                break;

                            case 'function' :
                                $result .= '<td>'.$this->executeFunction($key, $value).'</td>';
                                break;

                            default:
                                $result .= '<td>' . $value . '</td>';
                        }

                        if ($key == 'id') {
                            $id = strtolower($value);
                        }
                    }
                    else
                    {
                        switch ($this->columns[$key]['format'])
                        {
                            case 'number' :
                            case 'currency' :
                            case 'crypto' :
                            case 'percentage' :
                                $result .= '<td>' . formatNumber(0, $this->columns[$key]) . '</td>';
                                break;

                            case 'function' :
                                $result .= '<td>'.$this->executeFunction($key, $value).'</td>';
                                break;

                            default:
                                $result .= '<td>&nbsp;</td>';
                        }
                    }

                    if (isset($this->columns[$key]['total'])) {
                        $totals[$key] += $value;
                    }
                }

                $result .= $this->getActions($id, $dataRow);

                $result .= '</tr>';
            }

            if (count($totals))
            {
                $result .= '<tr>';

                $firstRow = reset($this->data);

                foreach ($firstRow AS $key => $value) {
                    if ($this->columns[$key]['total']) {
                        $result .= '<td>' . formatNumber($totals[$key], $this->columns[$key]) . '</td>';
                    } else {
                        $result .= '<td>&nbsp;</td>';
                    }
                }

                if (count($this->actions)) {
                    $result .= '<td>&nbsp;</td>';
                }

                $result .= '</tr>';
            }

            $result .= "</tbody>";
        }
        else {
            $result .= '<tr><td>No Data Found...</td></tr>';
        }

        $result .= '</table>';

        return $result;
    }

    public function getActions($id, $dataRow)
    {
        $result = '';

        if (count($this->actions))
        {
            $result .= '<td NOWRAP>';

            foreach ($this->actions AS $action)
            {
                $showAction = TRUE;

                if (array_key_exists('conditions', $action)) {
                    if (is_array($action['conditions']) && count($action['conditions'])) {
                        foreach ($action['conditions'] AS $conditionKey => $condition) {
                            if ($condition != $dataRow[$conditionKey]) {
                                $showAction = FALSE;
                                break;
                            }
                        }
                    }
                }

                if ($showAction ) {
                    $result .= '<a class="btn btn-' . $action['class'] . ' mr-2" href="' . $action['link'] . '/' . $id . '">' . $this->CI->getLanguageText($action['text']) . '</a>';
                }
            }

            $result .= '</td>';
        }

        return $result;
    }

    public function executeFunction($key, $value)
    {
        $functionName = $this->columns[$key]['function_name'];
        return $functionName($value);
    }

    public function getTableHeader()
    {
        $result = '<table';

        foreach($this->attributes AS $key => $val) {
            $result .= ' '.$key.'="'.$val.'"';
        }

        $result .= '>';

        return $result;
    }

    public function getRowHeader($result)
    {
        $result .= "<thead class='thead-light'>
            <tr>";

        foreach ($this->columns AS $column) {
            $result .= '<th>' . $this->CI->getLanguageText($column['title']) . '</th>';
        }

        if (count($this->actions)) {
            $result .= '<th>' . $this->CI->getLanguageText('actions') . '</th>';
        }

        $result .= "</tr>
            </thead>
            <tbody>";

        return $result;
    }

}