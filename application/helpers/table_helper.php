<?php

function createViewTable(array $table)
{
    $CI = get_instance();

    // Initialize
    $pages = "";

    // Configure pagination
    if (is_array($table['data']) && count($table['data']))
    {
        $CI->load->library('pagination');

        $CI->config->load('pagination');
        $pagination_config = $CI->config->item('pagination');

        $pagination_config['base_url'] = $CI->config->item('base_url');
        if ($CI->subDir) {
            $pagination_config['base_url'] = $pagination_config['base_url'].$CI->subDir.'/';
            $pagination_config['uri_segment'] = 4;
        }

        $pagination_config['base_url'] = $pagination_config['base_url'].$CI->controller.'/'.$CI->method.'/';
        $pagination_config['total_rows'] = count($table['data']);
        
        $CI->pagination->initialize($pagination_config);
        $pages = $CI->pagination->create_links();

        $table['data'] = array_slice($table['data'], $CI->uri->segment($pagination_config['uri_segment'], 0), $pagination_config['per_page']);
    }

    // Render table
    $CI->load->library('tables', $table);

    return $pages;
}
