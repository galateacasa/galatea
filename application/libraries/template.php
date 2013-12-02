<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template {

    public $template_data = array();
    public $template_scripts = '';
    public $template_styles = '';
    public $template_metas = '';
    public $template_title = 'Galatea';
    public $template_breadcrumb = '';

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function set_title($title = ''){
        if(!empty($title)){
            $this->template_title = $title;
        }
    }

    function set_script($path = '',$script = ''){
        if(!empty($path)){
            $script_body = '<script src="'.$path.'" type="text/javascript"></script>';
            $this->template_scripts .= $script_body;
        }
        if(!empty($script)){
            $script_body = '<script type="text/javascript">';
            $script_body .= $script;
            $script_body .= '</script>';

            $this->template_scripts .= $script_body;
        }
    }

    /**
     * Set multiple scripts as once
     * @param array $scripts Array with all scripts
     */
    public function set_sripts($scripts){
        foreach($scripts as $script) $this->set_script($script);
    }

    function set_style($path = '',$style = ''){
        if(!empty($path)){
            $style_body = '<link rel="stylesheet" href="'.$path.'" type="text/css" />';
            $this->template_styles .= $style_body;
        }
        if(!empty($style)){
            $style_body = '<style>';
            $style_body .= $style;
            $style_body .= '</style>';

            $this->template_styles .= $style_body;
        }
    }

    function set_meta($name = '',$content = ''){
        $meta_body = '<meta name="'.$name.'" content="'.$content.'">';

        $this->template_metas .= $meta_body;
    }

    function set_breadcrumb($links = array()){
        $breadcrumb = "
        <div>
        <ul class='breadcrumb'>";
        foreach ($links as $key => $value) {
            $breadcrumb .= "
            <li>
            <a href='$value'>$key</a>
            <span class='divider'>/</span>
            </li>
            ";
        }
        $breadcrumb .= "
        </ul>
        </div>";
        $this->template_breadcrumb = $breadcrumb;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        $this->CI = & get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('scripts', $this->template_scripts);
        $this->set('styles', $this->template_styles);
        $this->set('metas', $this->template_metas);
        $this->set('title', $this->template_title);
        $this->set('breadcrumb', $this->template_breadcrumb);
        return $this->CI->load->view("templates/" . $template, $this->template_data, $return);
    }


}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
