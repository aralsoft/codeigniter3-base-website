<?php

function prepareInputForDatabase(array $fields, array $input)
{
    $result = $input;

    foreach ($fields AS $name => $field) {
        if ($field['type'] == 'checkbox') {
            if (!isset($input[$name])) {
                $result[$name] = 0;
            }
        }
    }

    return $result;
}

function prepareGoogleCaptcha()
{
    $CI = get_instance();

    if ($CI->config->item('g-recaptcha-sitekey') && $CI->isLive) {
        $verify = file_get_contents($CI->config->item('g-recaptcha-url') . '?secret=' . $CI->config->item('g-recaptcha-secret') . '&response=' . $CI->input->post('g-recaptcha-response'));
        $captcha_success = json_decode($verify);
        return $captcha_success->success;
    }

    return TRUE;
}

function setFilters()
{
    $CI = get_instance();

    $filters = array();

    if ($CI->input->post('clear')) {
        $CI->session->unset_userdata('filters');
    }

    if ($CI->input->post('submit')) {
        $filters = $CI->input->post();
    } else if ($CI->session->userdata('filters')) {
        $filters = $CI->session->userdata('filters');
    }

    $CI->session->set_userdata('filters', $filters);

    return $filters;
}

function getPresetDates()
{
    return array(
        'yesterday' => 'Yesterday',
        'last7days' => 'Last 7 Days',
        'last30days' => 'Last 30 Days',
        'last90days' => 'Last 90 Days',
        'last365days' => 'Last 365 Days'
    );
}

function applyPresetDates($filters)
{
    if (isset($filters['period']) && $filters['period'])
    {
        switch($filters['period'])
        {
            case 'yesterday' :
                $filters['fromDate'] = date("Y-m-d", strtotime('-1 day'));
                break;

            case 'last7days' :
                $filters['fromDate'] = date("Y-m-d", strtotime('-7 days'));
                break;

            case 'last30days' :
                $filters['fromDate'] = date("Y-m-d", strtotime('-30 days'));
                break;

            case 'last90days' :
                $filters['fromDate'] = date("Y-m-d", strtotime('-90 days'));
                break;

            case 'last365days' :
                $filters['fromDate'] = date("Y-m-d", strtotime('-365 days'));
                break;
                
        }

        $filters['toDate'] = date("Y-m-d", strtotime('-1 day'));
    }

    return $filters;
}
