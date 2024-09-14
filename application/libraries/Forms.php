<?php

class Forms
{
    // Object properties
    public $form = '';
    public $mode = '';
    public $elements = array();

    public $formFieldTypes = array(
        'text',
        'number',
        'password',
        'hidden',
        'select',
        'checkbox',
        'radio',
        'file',
        'textarea',
        'g-recaptcha',
        'date',
        'sub-title'
    );

    public $formAttrs = array(
        'class' => '',
        'method' => 'post',
        'accept-charset' => 'utf-8',
    );

    public $formFieldAttrs = array(
        'size' => '',
    );

    // CodeIgniter super-object
    protected $CI;

    // Constructor function
    public function __construct(array $form)
    {
        $this->CI =& get_instance();

        $this->CI->load->library('form_validation');

        $this->form = $form;

        if (isset($this->form['mode'])) {
            $this->mode = $this->form['mode'];
        }

        if ($this->mode == 'inline') {
            $this->formAttrs['class'] = 'form-inline mb-3';
        }

        if (!isset($this->form['cols']) && $this->mode != 'inline') {
            $this->form['cols'] = array('sm' => 12, 'md' => 8, 'lg' => 6);
        }

        $this->formAttrs['action'] = '/'.$this->CI->controller.'/'.$this->CI->method;

        if ($this->CI->subDir) {
            $this->formAttrs['action'] = '/'.$this->CI->subDir.$this->formAttrs['action'];
        }

        if (isset($this->form['attrs']) && is_array($this->form['attrs'])) {
            foreach ($this->form['attrs'] as $attrKey => $attrVal) {
                $this->formAttrs[$attrKey] = $attrVal;
            }
        }

        if (isset($this->form['fieldAttrs']) && is_array($this->form['fieldAttrs'])) {
            foreach ($this->form['fieldAttrs'] as $attrKey => $attrVal) {
                $this->formFieldAttrs[$attrKey] = $attrVal;
            }
        }

    }

    // Add elements
    public function addElements($data = array())
    {
        $this->elements = array();

        foreach ($this->form['fields'] AS $name => $values)
        {
            if (!in_array($values['type'], $this->formFieldTypes)) {
                continue;
            }

            $this->elements[$name] = array(
                'type' => $values['type'],
                'id' => $name.'_id',
                'value' => '',
            );

            if (isset($values['validation']) && $values['validation']) {
                $this->CI->form_validation->set_rules($name, $this->CI->getLanguageText($name), $values['validation']);
            }

            if (isset($values['attrs']) && is_array($values['attrs'])) {
                foreach ($values['attrs'] as $attrKey => $attrVal) {
                    $this->elements[$name][$attrKey] = $attrVal;
                }
            }

            if (isset($this->elements[$name]['default'])) {
                $this->elements[$name]['value'] = $this->elements[$name]['default'];
            }

            if (isset($data[$name])) {
                $this->elements[$name]['value'] = $data[$name];
            }
        }

    }

    // Render elements
    public function render()
    {
        $result = '';

        if (count($this->elements))
        {
            $hiddenFields = '';
            $g_recaptcha = FALSE;

            $result = $this->getFormHeader();

            foreach ($this->elements as $name => $element)
            {
                if ($element['type'] == 'hidden') {
                    $hiddenFields .= '<input type="hidden" name="'.$name.'" id="'.$element['id'].'" value="'.$element['value'].'">';
                    continue;
                }

                if ($element['type'] == 'g-recaptcha') {
                    $g_recaptcha = TRUE;
                    continue;
                }

                $result .= $this->getElementCode($name, $element);
            }

            if ($g_recaptcha) {
                $result .= $this->insertGoogleCaptcha();
            }

            $result .= $this->getFormFooter($hiddenFields);
        }

        return $result;
    }

    public function getElementCode($name, array $element)
    {
        $formGroupClass = $this->getFormGroupClass($element);
        $labelClass = $this->getLabelClass($element['type']);
        $class = $this->getInputClass($element['type']);
        $label = $this->CI->getLanguageText($name);

        $result = '<div class="'.$formGroupClass.'">';

        switch ($element['type'])
        {
            case 'text' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<input class="'.$class.'" type="'.$element['type'].'" id="'.$element['id'].'" placeholder="'.$label.'" name="'.$name.'" value = "'.$element['value'].'"';

                if (isset($element['disabled'])) {
                    $result .= ' disabled';
                }

                $result .= '>';
                break;

            case 'number' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<input class="'.$class.'" type="'.$element['type'].'" id="'.$element['id'].'" placeholder="'.$element['default'].'" name="'.$name.'" value = "'.$element['value'].'" min="'.$element['min'].'" max="'.$element['max'].'">';
                break;

            case 'date' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<input class="'.$class.'" type="'.$element['type'].'" id="'.$element['id'].'" name="'.$name.'" value = "'.$element['value'].'">';
                break;

            case 'select' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<select class="'.$class.'" id="'.$element['id'].'" name="'.$name.'">';
                $result .= $this->getSelectBoxOptions($element);
                $result .= '</select>';
                break;

            case 'textarea' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<textarea rows="'.$element['rows'].'" class="'.$class.'" id="'.$element['id'].'" placeholder="'.$label.'" name="'.$name.'">'.$element['value'].'</textarea>';
                break;

            case 'file' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<input class="'.$class.'" type="file" name="'.$name.'" />';
                break;

            case 'checkbox' :
                $result .= '<input type="checkbox" class="'.$class.'" id="'.$element['id'].'" name="'.$name.'" value="1"';
                if ($element['value'])
                    $result .= ' checked';
                $result .= '><label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.'</label>';
                break;

            case 'radio' :
                $result .= '<label class="form-label"><strong>'.$label.':&nbsp;</strong></label>';
                $result .= $this->getRadioButtonOptions($name, $element, $class, $labelClass);
                break;

            case 'password' :
                $result .= '<label class="'.$labelClass.'" for="'.$element['id'].'">'.$label.':&nbsp;</label>';
                $result .= '<input class="'.$class.'" type="'.$element['type'].'" id="'.$element['id'].'" placeholder="'.$label.'" name="'.$name.'" value = "'.$element['value'].'">';
                break;

            case 'sub-title' :
                $result .= '<h5>'.$this->CI->getLanguageText($name).'</h5>';
                break;
        }

        if (isset($element['suffixText']) && $element['suffixText']) {
            $result .= '<small class="form-text text-muted">'.$this->CI->getLanguageText($element['suffixText'].'_suffix').'</small>';
        }

        $result .= '</div>';

        return $result;
    }

    public function getSelectBoxOptions(array $element)
    {
        $result = '';

        if (isset($element['firstOption'])) {
            $result .= '<option value="0">' . $this->CI->getLanguageText($element['firstOption']) . '</option>';
        }

        if (isset($element['options'])) {
            foreach ($element['options'] as $key => $val)
            {
                $result .= '<option value="' . $key . '"';

                if ($element['value'] == $key) {
                    $result .= ' SELECTED';
                }

                $result .= '>' . $this->CI->getLanguageText($val) . '</option>';
            }
        }

        return $result;
    }

    public function getRadioButtonOptions($name, array $element, $class, $labelClass)
    {
        $result = '';

        foreach ($element['options'] AS $key => $val)
        {
            $result .= '<div class="form-check">';
            $result .= '<input type="radio" class="'.$class.'" id="'.$element['id'].'_'.$key.'" name="'.$name.'" value="'.$key.'"';

            if ($element['value'] == $key)
                $result .= ' checked';

            $result .= '><label class="'.$labelClass.'" for="'.$element['id'].'_'.$key.'">'.$val.'</label>';
            $result .= '</div>';
        }

        return $result;
    }

    public function getFormGroupClass($element)
    {
        switch ($element['type'])
        {
            case 'button' :
                if ($this->mode == 'inline') {
                    return 'form-group';
                }

                return 'form-group mt-4';

            case 'checkbox' :

                if (isset($element['orientation']) && $element['orientation'] == 'vertical') {
                    return 'form-group form-check form-check-inline';
                }

                return 'form-group form-check';

            default :
                return 'form-group';
        }

    }

    public function getInputClass($type, $buttonLinkClass = 'btn-danger')
    {
        switch ($type)
        {
            case 'checkbox' :
            case 'radio' :
                $result = 'form-check-input';
                break;

            case 'file' :
                $result = 'form-control-file';
                if ($this->formFieldAttrs['size']) {
                    $result .= ' form-control-'.$this->formFieldAttrs['size'];
                }
                break;

            case 'submitButton' :
                $result = 'btn btn-primary';
                if ($this->formFieldAttrs['size']) {
                    $result .= ' btn-'.$this->formFieldAttrs['size'];
                }
                break;

            case 'clearButton' :
                $result = 'btn btn-warning';
                if ($this->formFieldAttrs['size']) {
                    $result .= ' btn-'.$this->formFieldAttrs['size'];
                }
                break;

            case 'buttonLink' :
                $result = 'btn '.$buttonLinkClass;
                if ($this->formFieldAttrs['size']) {
                    $result .= ' btn-'.$this->formFieldAttrs['size'];
                }
                break;

            default :
                $result = 'form-control';

                if ($this->mode == 'inline') {
                    $result .= ' mr-3';
                }

                if ($this->formFieldAttrs['size']) {
                    $result .= ' form-control-'.$this->formFieldAttrs['size'];
                }
        }

        return $result;
    }

    public function getLabelClass($type)
    {
        switch ($type)
        {
            case 'checkbox' :
            case 'radio' :
                $result = 'form-check-label';
                break;

            default :
                $result = 'form-label';
                if ($this->formFieldAttrs['size']) {
                    $result .= ' col-form-label-'.$this->formFieldAttrs['size'];
                }
        }

        return $result;
    }

    public function getFormHeader()
    {
        $result = '<div class="row">
        <div class="';

        if (is_array($this->form['cols']) && count($this->form['cols'])) {
            foreach ($this->form['cols'] AS $size => $columns) {
                $result .= ' col-' . $size . '-' . $columns;
            }
        } else if ($this->form['cols']) {
            $result .= 'col-md-'.$this->form['cols'];
        } else {
            $result .= 'col-md-12';
        }

        $result .= '">';
        $result .= '<form';

        foreach ($this->formAttrs as $key => $val) {
            $result .= ' '.$key.'="'.$val.'"';
        }

        $result .= '>';

        return $result;
    }

    public function getFormFooter($hiddenFields)
    {
        // Open footer group
        $formGroupClass = $this->getFormGroupClass(array('type' => 'button'));
        $result = '<div class="'.$formGroupClass.'">';

        // Add hidden input.
        $result .= $hiddenFields;

        // Insert buttons
        foreach ($this->form['buttons'] AS $buttonName => $buttonValue) {
            if ($buttonName == 'submit') {
                $buttonClass = $this->getInputClass('submitButton');
                $result .= '<button type="submit" name="submit" value="1" class="'.$buttonClass.' mr-3">'.$this->CI->getLanguageText($buttonValue).'</button>';
            }
            else if ($buttonName == 'clear') {
                $buttonClass = $this->getInputClass('clearButton');
                $result .= '<button type="submit" name="clear" value="1" class="'.$buttonClass.' mr-3">'.$this->CI->getLanguageText($buttonValue).'</button>';
            }
            else {
                $buttonClass = $this->getInputClass('buttonLink');
                $result .= $this->insertButtonLink($buttonValue, $buttonClass);
            }
        }

        // Close footer group & form
        $result .= '</div></form></div></div>';

        return $result;
    }

    public function insertGoogleCaptcha()
    {
        $result = '';

        $formGroupClass = $this->getFormGroupClass(array('type' => 'g-recaptcha'));

        if ($this->CI->showCaptcha) {
            $result .= '<div class="'.$formGroupClass.'">';
            $result .= '<div class="g-recaptcha" data-sitekey="'.$this->CI->config->item('g-recaptcha-sitekey').'"></div>';
            $result .= '</div>';
        }

        return $result;
    }

    public function insertButtonLink($button, $class)
    {
        if (is_array($button)) {
            $link = '/' . $this->CI->previousController . '/' . $button['method'];
            $text = $this->CI->getLanguageText($button['text']);
        } else {
            $link = $this->CI->goBackLink;
            $text = $this->CI->getLanguageText($button);
        }

        return '<a href="'.$link.'" class="'.$class.' mr-3">'.$text.'</a>';
    }
    
}
