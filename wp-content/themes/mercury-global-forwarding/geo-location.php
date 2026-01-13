<?php
/**
 * Geo Location Detection for Mercury GF
 * Определение геолокации по IP
 */

function mgf_get_user_geolocation() {
    // Проверяем кеш (1 час)
    $cache_key = 'mgf_user_geolocation_' . md5($_SERVER['REMOTE_ADDR']);
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    // Используем freegeoip.app или ipapi.co
    $api_url = "https://freegeoip.app/json/{$user_ip}";
    // Альтернатива: $api_url = "https://ipapi.co/{$user_ip}/json/";
    
    $response = wp_remote_get($api_url, array(
        'timeout' => 5,
        'sslverify' => false
    ));
    
    if (is_wp_error($response)) {
        // Фолбэк на определение по времени или другим методам
        return mgf_get_geolocation_fallback();
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || isset($data['error'])) {
        return mgf_get_geolocation_fallback();
    }
    
    $result = array(
        'country_code' => isset($data['country_code']) ? strtoupper($data['country_code']) : '',
        'country_name' => isset($data['country_name']) ? $data['country_name'] : '',
        'region_code' => isset($data['region_code']) ? $data['region_code'] : '',
        'region_name' => isset($data['region_name']) ? $data['region_name'] : '',
        'city' => isset($data['city']) ? $data['city'] : '',
        'timezone' => isset($data['time_zone']) ? $data['time_zone'] : '',
        'is_eu' => isset($data['country_code']) ? in_array(strtoupper($data['country_code']), mgf_get_eu_countries()) : false
    );
    
    // Кешируем на 1 час
    set_transient($cache_key, $result, HOUR_IN_SECONDS);
    
    return $result;
}

function mgf_get_eu_countries() {
    return array(
        'AT', // Austria
        'BE', // Belgium
        'BG', // Bulgaria
        'HR', // Croatia
        'CY', // Cyprus
        'CZ', // Czech Republic
        'DK', // Denmark
        'EE', // Estonia
        'FI', // Finland
        'FR', // France
        'DE', // Germany
        'GR', // Greece
        'HU', // Hungary
        'IE', // Ireland
        'IT', // Italy
        'LV', // Latvia
        'LT', // Lithuania
        'LU', // Luxembourg
        'MT', // Malta
        'NL', // Netherlands
        'PL', // Poland
        'PT', // Portugal
        'RO', // Romania
        'SK', // Slovakia
        'SI', // Slovenia
        'ES', // Spain
        'SE', // Sweden
    );
}

function mgf_get_us_canada_countries() {
    return array('US', 'CA');
}

function mgf_get_geolocation_fallback() {
    // Фолбэк: определяем по времени браузера
    $timezone = isset($_COOKIE['mgf_timezone']) ? $_COOKIE['mgf_timezone'] : '';
    
    $result = array(
        'country_code' => '',
        'country_name' => '',
        'region_code' => '',
        'region_name' => '',
        'city' => '',
        'timezone' => $timezone,
        'is_eu' => false
    );
    
    return $result;
}

// Функция проверки, нужно ли скрывать российские реквизиты
function mgf_should_hide_russian_details() {
    // Если уже определено в сессии/куки
    if (isset($_COOKIE['mgf_hide_russian'])) {
        return $_COOKIE['mgf_hide_russian'] === 'true';
    }
    
    $geolocation = mgf_get_user_geolocation();
    $country_code = $geolocation['country_code'];
    
    // Страны, для которых скрываем российские реквизиты
    $hide_for_countries = array_merge(
        mgf_get_eu_countries(),
        mgf_get_us_canada_countries(),
        array('GB', 'AU', 'NZ', 'JP', 'KR', 'SG') // Другие западные страны
    );
    
    $should_hide = in_array($country_code, $hide_for_countries);
    
    // Сохраняем в куки на 7 дней
    setcookie('mgf_hide_russian', $should_hide ? 'true' : 'false', 
        time() + (7 * 24 * 60 * 60), '/', '', false, true);
    
    return $should_hide;
}
?>