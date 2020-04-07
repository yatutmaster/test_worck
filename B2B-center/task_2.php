<?

function change_url ($url,$exclude = null) {
    
    $data = parse_url($url);
    $result = '';
    
    parse_str($data['query']??'', $output);
    
    if($exclude)
        foreach($output as $k => $val)
            if($val == $exclude) unset($output[$k]);
    
    asort($output);
    
    if($data['path']??0)
        $output['url'] = $data['path'];
    
    if($data['scheme']??0)
        $result = $data['scheme'].'://';
    
    if($data['host']??0)
        $result .= $data['host'].'/';
    
    return $result.'?'.http_build_query($output);
    
    
}


$val = 'https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3';

    
echo change_url ($val,3);
