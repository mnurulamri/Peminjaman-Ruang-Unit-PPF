<?/*php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (! function_exists('secure_base_url'))
{
    function secure_base_url()
    {
        if ($_SERVER["SERVER_PORT"] != 443)
        {
            return str_replace("http://", "https://" , base_url());
        }
    }
}


 End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */