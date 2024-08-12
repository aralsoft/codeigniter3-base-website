<?php

class Tables
{
    // Object properties
    public $attributes = array("class" => "table");
    public $columns = array();
    public $data = array();
    public $firstDataRow = array();
    public $actions = array();
    
    // CodeIgniter super-object
    protected $CI;
    
    // Constructor function
    public function __construct(array $parameters = array())
    {
        $this->CI =& get_instance();

        if (isset($parameters['attributes']) && is_array($parameters['attributes'])) {
            $this->attributes = array_merge($this->attributes, $parameters['attributes']);
        }

        if (isset($parameters['columns']) && is_array($parameters['columns'])) {
            $this->columns = $parameters['columns'];
        }

        if (isset($parameters['data']) && is_array($parameters['data']) && count($parameters['data'])) {
            $this->data = $parameters['data'];
            $this->firstDataRow = reset($this->data);
        }

        if (isset($parameters['actions']) && is_array($parameters['actions'])) {
            $this->actions = $parameters['actions'];
        }

        if (count($this->columns))
        {
            foreach ($this->columns as $key => $value)
            {
                if (!is_array($value)) {
                    $this->columns[$key] = array('title' => $key, 'format' => 'text');
                    continue;
                }

                if (!isset($value['title'])) {
                    $this->columns[$key]['title'] = $key;
                }

                if (!isset($value['format'])) {
                    $this->columns[$key]['format'] = 'text';
                }
            }
        }
        else
        {
            foreach ($this->firstDataRow as $key => $value) {
                $this->columns[$key] = array('title' => $key, 'format' => 'text');
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

            $result .= $this->getRowHeader();

            if (count($this->data)) {
                foreach ($this->data as $dataRow)
                {
                    $id = 0;
                    $result .= '<tr>';

                    foreach ($dataRow as $key => $value) {
                        if (isset($this->columns[$key]))
                        {
                            $result .= '<td>';

                            switch ($this->columns[$key]['format'])
                            {
                                case 'date' :
                                    $dateFormat = 'd-m-y';
                                    if (isset($this->columns[$key]['date_format'])) {
                                        $dateFormat = $this->columns[$key]['date_format'];
                                    }
                                    $result .= date($dateFormat, strtotime($value));
                                    break;

                                case 'number' :
                                case 'currency' :
                                case 'crypto' :
                                case 'percentage' :
                                    $result .= formatNumber($value, $this->columns[$key]);
                                    break;

                                case 'image' :
                                    $images = explode('|', $value);
                                    if (is_array($images) && count($images)) {
                                        $result .= '<img src="' . reset($images) . '" width="75" height="75">';
                                    }
                                    break;

                                case 'function' :
                                    $result .= $this->executeFunction($key, $value);
                                    break;

                                default:
                                    $result .= $value;
                            }

                            $result .= '</td>';

                            if (isset($this->columns[$key]['total'])) {
                                $totals[$key] += $value;
                            }

                        }

                        if ($key == 'id') {
                            $id = strtolower($value);
                        }

                    }

                    $result .= $this->getActions($id, $dataRow);
                    $result .= '</tr>';
                }

                $result .= $this->getTotalsRow($totals);
            }
            else {
                $result .= $this->getNoDataRow();
            }

            $result .= "</tbody>";
        }
        else {
            $result .= $this->getNoDataRow();
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
                if (isset($action['conditions']) && is_array($action['conditions'])) {
                    foreach ($action['conditions'] AS $conditionKey => $condition) {
                        if ($condition != $dataRow[$conditionKey]) {
                            continue 2;
                        }
                    }
                }

                $confirmClick = '';

                if (isset($action['parameters']) && is_array($action['parameters']))
                {
                    $parameters = $action['parameters'];

                    if (isset($parameters['omitID']) && $parameters['omitID']) {
                        $id = '';
                    }

                    if (isset($parameters['confirm']) && $parameters['confirm'])
                    {
                        $confirmText = 'are_you_sure';
                        if (isset($parameters['confirmText']) && $parameters['confirmText']) {
                            $confirmText = $parameters['confirmText'];
                        }

                        $confirmClick = ' onclick="return confirm(\''.$this->CI->getLanguageText($confirmText).'\');"';
                    }

                }

                $result .= '<a class="btn btn-' . $action['class'] . ' mr-2" href="' . $action['link'] . '/' . $id . '"' . $confirmClick . '>' . $this->CI->getLanguageText($action['text']) . '</a>';
            }

            $result .= '</td>';
        }

        return $result;
    }

    public function getTotalsRow($totals)
    {
        $result = '';

        if (count($totals))
        {
            $result .= '<tr>';

            foreach ($this->columns as $key => $value) {
                if (isset($this->columns[$key]['total'])) {
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

        return $result;
    }

    public function getNoDataRow()
    {
        $colspan = '';

        if ($numberOfColumns = count($this->columns))
        {
            if (count($this->actions)) {
                $numberOfColumns += 1;
            }

            $colspan = ' colspan="'.$numberOfColumns.'"';
        }

        return '<tr><td'.$colspan.'>'.$this->CI->getLanguageText('no_data').'</td></tr>';
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

    public function getRowHeader()
    {
        $result = "<thead class='thead-light'><tr>";

        foreach ($this->columns AS $column) {
            $result .= '<th>' . $this->CI->getLanguageText($column['title']) . '</th>';
        }

        if (count($this->actions)) {
            $result .= '<th>' . $this->CI->getLanguageText('actions') . '</th>';
        }

        $result .= "</tr></thead><tbody>";

        return $result;
    }

}