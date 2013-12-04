<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create a message box with all messages from a specific user, project or product
*/
class Message
{
    /**
     * Gives access to the Code Igniter instances, so you could load libraries, helpers, etc
     *
     * @access protected
     * @var object
     */
    protected $ci;

    /**
     * Title of message box
     *
     * @access private
     * @var string
     */
    private $title = 'Mensagens e reviews';

    /**
     * Object to be used to create the messages markup
     *
     * @access private
     * @var object
     */
    private $object;

    /**
     * Define object controller name
     *
     * @access private
     * @var string
     */
    private $controller;

    /**
     * Define owner ID
     *
     * @access private
     * @var integer
     */
    private $owner_id;

    /**
     * Initial actions
     */
    public function __construct()
    {
        // Define Code Igniterinstance
        $this->ci =& get_instance();
    }

    /**
     * Initial definitions to mounte the HTML markup
     *
     * @access public
     * @param    string    $type         Name of the
     * @param    integer $owner_id ID of the project, product, etc
     * @param    string $title         Custom title to be used
     * @return void
     */
    public function define($type, $owner_id, $title = false)
    {
        // Check if some custom title was defined
        if($title) $this->title = $title;

        // Actions for specific type of object
        switch ($type) {

            // Project
            case 'project':

                // Define object
                $object = new Item_Message();
                $object->where('item_id', $owner_id);

                // Define controller name
                $controller = 'items';
                break;

            // Product
            case 'product':
                $object = new Item_Message();
                $object->where('item_id', $owner_id);

                $controller = 'items';
                break;

            // Profile
            case 'profile':
                $object = new User_Message();
                $object->where('user_id', $owner_id);

                $controller = 'users';
                break;
        }

        $object->where('status', 1)->order_by('create_date', 'DESC')->get();

        // Define object
        $this->object = $object;

        // Define owner ID
        $this->controller = $controller;

        // Define owner ID
        $this->owner_id = $owner_id;
    }

    /**
     * Create all necessary mark up for message form
     *
     * @access public
     * @return string HTML mark up
     */
    public function get()
    {

        // The user is logged in?
        if ( $this->ci->session->userdata('id') ) {

            // Main input mark up
            $input = <<<HTML
                <!-- write a message -->
                <li>
                    <input class="message-input main feed-msg" type="text" placeholder="Escreva uma mensagem...">
                    <input class="message-submit post-cmt btn-submit" type="button" value="button">
                </li>
HTML;

        }else{
            $input = <<<HTML
                <li>Fa&ccedil;a o <a href="/login">login</a> para poder deixar mensagens</li>
HTML;
        }

        // Create final mark up
        $html = <<<HTML

                <!-- title -->
                <h2>{$this->title}</h2>

                <!-- message box -->
                <article class="post-block blog-box review msg-review">
                    <ul id="message" data-controller="{$this->controller}" data-owner-id="{$this->owner_id}">
                        {$input}
                        {$this->mount_message_list()}
                    </ul>
                </article> <!-- /message box -->

HTML;

        // Return all HTML markup
        return $html;
    }

    /**
     * Create all messages mark up
     *
     * @access private
     * @return string HTML mark up
     */
    private function mount_message_list()
    {

        // Collect all messages and convert to an array
        $messages = $this->object->all_to_array( array('id', 'sender_id', 'message', 'parent_id', 'create_date') );

        // Define default markup
        $message_markup = '';

        // Any message exists?
        if($messages) {

            // Mount all messages markup
            foreach($messages as $message) {

                // Check if the message is a parent message
                if($message['parent_id'] == 0) {

                    // Mount parent message mark up
                    $message_markup .= $this->message_list($message);

                    // Define children message count
                    $children_count = 0;

                    // Mount parent children message mark up
                    foreach($messages as $key => $message_children) {

                        // Check if the children message have message as a parent
                        if($message_children['parent_id'] == $message['id']) {
                            $message_markup .= $this->message_list($message_children, true);
                            $children_count++;
                        }

                    }

                    // Check if is necessary add a response form
                    if($children_count > 0) $message_markup .= $this->add_form();

                }

            }

        }

        // Return all mark up to be used at message
        return $message_markup;

    }

    /**
     * Create a single message mark up
     *
     * @access private
     * @param  string  $message       Message configs
     * @param  boolean $have_response Define if the mark up needs to have the response items
     * @return string                 HTML markup
     */
    private function message_list($message, $have_response = false)
    {
        // Load helper
        $this->ci->load->helper('message_date');

        // Formate date and time
        $message['create_date'] = message_date($message['create_date']);

        // Check if the message is from it's owner
        if( $this->ci->session->userdata('id') and $this->ci->session->userdata('id') == $message['sender_id'] ):
            $owner_markup = sprintf('<a href="%s" class="cls">&nbsp;</a>', $message['id']);
        else:
            $owner_markup = '';
        endif;

        // Check if the message needs to have a response button
        if($have_response) {
            $response['button'] = '';
            $response['class']    = 'custom-list-width';
        }else{
            $response['button'] = $this->ci->session->userdata('id') ? '<a href="#" class="btn-submit btn-reply">&nbsp;</a>' : '';
            $response['class']    = 'parent-list';
        }

        // Define if the message is for profile area
        if($this->controller == 'users') $response['class'] .= ' profile';

        // Define whos is the sender
        $sender_data = new User($message['sender_id']);

        // Profile link address
        $profile_address = base_url("site/users/profile/{$sender_data->username}");

        // Create a single message mark up
        $message_markup = <<<HTML

            <li id="{$message['id']}" class="{$response['class']}">

                <a href="$profile_address" >
                    {$sender_data->name}
                </a>{$message['message']}

                <div class="time-detail">

                    $owner_markup
                    {$response['button']}

                    <!-- date and time -->
                    <span>{$message['create_date']}</span>
                </div>

            </li>

HTML;

        return $message_markup;

    }

    /**
     * Add a message form markup
     *
     * @access private
     * @return string HTML mark up
     */
    private function add_form()
    {
        $class = 'custom-list-width';

        // Define if the message is for profile area
        if($this->controller == 'users') $class .= ' profile';

        $form_markup = <<<HTML
            <li class="message-form $class">
                <input class="message-input feed-msg" type="text" placeholder="Escreva uma resposta...">
                <input class="message-submit post-cmt btn-submit" type="button" value="button">
            </li>
HTML;

        // return the mark up
        return $form_markup;

    }

}

/* End of file message.php */
/* Location: ./application/libraries/message.php */
