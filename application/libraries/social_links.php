<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create social network icon with specific link addresses
 *
 * PHP 5.3+
 *
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @package Libraries
 * @category Galatea
 */
class Social_Links
{
    /**
     * Code Igniter instance
     *
     * @access protected
     * @var Object
     */
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    /**
     * Create HTML markup
     *
     * @access public
     * @param  string | boolean $title The title that will be used into the social network
     * @param  string | boolean $text  Text to be used as a description into social network
     * @param  string | boolean $image URL source to the image
     * @param  string | boolean $url   URL to be shared
     * @return string                  HTML markup
     */
    public function get($title = FALSE, $text = FALSE, $image = FALSE, $url = FALSE)
    {

        // Create HTML markup
        $html = <<<HTML

            <ul class="social-icon">

                <!-- facebook -->
                <li>
                    <a data-url="https://www.facebook.com/sharer/sharer.php?s=100&p[title]={$title}&p[summary]={$text}&p[url]={$url}&p[images][0]={$image}">facebook</a>
                </li>

                <!-- twitter -->
                <li>
                    <a class="twit" name="Compartilhe no Twitter" data-url="https://twitter.com/intent/tweet?text={$title} url={$url}">twitter</a>
                </li>

                <!-- pinterest -->
                <li class="third">
                    <a class="third" data-url="http://pinterest.com/pin/create/button/?url={$url}&media={$image}&description={$title}">third</a>
                </li>

                <!-- link address -->
                <li>
                    <a class="fourth" data-alert="true" data-url="Compartilhe o link: {$url}">fourth</a>
                </li>
            </ul>

HTML;

        // Return HTML markup
        return $html;
    }
}

/* End of file social_links.php */
/* Location: ./application/libraries/social_links.php */
?>