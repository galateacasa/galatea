<?
if ( ! function_exists('address_search'))
{
    function address_search($zip){

        $zip = str_replace('.', '', $zip);
        $zip = str_replace('-', '', $zip);

        $url = 'http://republicavirtual.com.br/web_cep.php?cep='.urlencode($zip).'&formato=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 0);

        $result = curl_exec($ch);
        curl_close($ch);

        if( ! $result)
            //$result = "&result=0&resultado_txt=erro+ao+buscar+cep";

        // $result = urldecode($result);
        // $result = utf8_encode($result);
        // parse_str( $result, $return);
        return $return;
    }
}
?>