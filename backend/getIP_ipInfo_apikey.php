/**
 * @param string $ip
 *
 * @return array|null
 */
function getIspInfo($ip)
{
    global $IPINFO_APIKEY;

    // Check if API key is defined and not empty
    if (!isset($IPINFO_APIKEY) || empty($IPINFO_APIKEY)) {
        return null; // or handle the case where API key is missing
    }

    $json = file_get_contents('https://ipinfo.io/' . $ip . '/json' . getIpInfoTokenString());
    if (!is_string($json)) {
        return null;
    }

    $data = json_decode($json, true);
    if (!is_array($data)) {
        return null;
    }

    return $data;
}
