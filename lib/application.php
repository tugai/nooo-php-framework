<?php
// Конфигурация нашего приложения
$config = array(
    'db_host'       =>  'localhost',
    'db_user'        =>  'root',
    'db_password'    =>  '',
    'db_name'        =>  'test',
);

// Глобальные переменные приложения 
$app = array(
    'title'         => 'GRUD без ООП',
    'db_link'       => -1,
    'http_server'   => 'http://cylon.local',
    'dir_ws_root'   => '/crud/',
);

$app['db_link'] = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
mysqli_set_charset($app['db_link'], "utf8");

// Приложение
function app_exit()
{
    exit;
}

// Обработка $_REQUEST
function get_request_wl_value($param, $default, $wl)
{
    $param = isset($_REQUEST[$param]) ? $_REQUEST[$param] : $default; 
    if(!in_array($param, $wl)) {
        $param = $default;
    }
    
    return $param;
}

function get_request_value($param, $default = '')
{
    $param = isset($_REQUEST[$param]) ? $_REQUEST[$param] : $default; 
    return $param;
}

// Редирект
function redirect($url)
{
    global $app;
    header('Location: ' . $app['http_server'] . $app['dir_ws_root'] . $url);
    app_exit(); 
}

// Функции для работы с бд mysql
function create_insert_query($db_link, $table, $data)
{
    $query = 'insert into ' . $table . ' (';
    while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
    }
    $query = substr($query, 0, -2) . ') values (';
    reset($data);
    while (list(, $value) = each($data)) {
        $value = (string)($value);
        switch ($value) {
            case 'now()':
                $query .= 'now(), ';
                break;
            case 'null':
                $query .= 'null, ';
                break;
            default:
                $query .= '\'' . mysqli_real_escape_string($db_link, $value) . '\', ';
                break;
        }
    }
    $query = substr($query, 0, -2) . ')';
    return $query;   
}

function create_update_query($db_link, $table, $data, $parameters = '')
{
    $query = 'update ' . $table . ' set ';
    while (list($columns, $value) = each($data)) {
        $value = (string)($value);
        switch ($value) {
            case 'now()':
                $query .= $columns . ' = now(), ';
                break;
            case 'null':
                $query .= $columns .= ' = null, ';
                break;
            default:
                $query .= $columns . ' = \'' . mysqli_real_escape_string($db_link, $value) . '\', ';
                break;
        }
    }
    $query = substr($query, 0, -2) . ' where ' . $parameters;
    return $query;   
}
