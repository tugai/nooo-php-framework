<?php
require_once 'lib/application.php';

$contact_us = array(
    'title' => 'Свяжитесь с нами',
    'actions' => array('view', 'create', 'update', 'delete'),
        'default_action' => 'view',
    'steps' => array('show', 'process'),
        'default_step' => 'show',
    'table' => array (
        'name' => 'contact_us',
        'id_field' => 'id',
        'fields' => array('id', 'email', 'subject', 'message')
    ),
    'form' => array(),
);

$action = get_request_wl_value('action', $contact_us['default_action'], $contact_us['actions']); 
$step = get_request_wl_value('step', $contact_us['default_step'], $contact_us['steps']); 

if($action == 'view') {
    // подготавливаем данные для вывода
    $query = "select " . implode(', ', $contact_us['table']['fields']) .
        " from " . $contact_us['table']['name'];
    $contact_us['data'] = mysqli_fetch_all(mysqli_query($app['db_link'], $query), MYSQLI_ASSOC);
    
    // выводим
    $layout = array(
        'title' => $app['title'] . ' :: ' . $contact_us['title'] . ' :: ' . $action,
        'content' => 'view/contact_us/view.php'
    );
    require 'layout/default.php';
} elseif ($action == 'create') {
    $contact_us['form']['error_msg'] = '';
    if($step == 'show') {
        foreach(array_slice($contact_us['table']['fields'], 1) as $field_name) {
            $contact_us['form'][$field_name] = '';
        }
    } elseif ($step == 'process') {
        $data = array();
        foreach(array_slice($contact_us['table']['fields'], 1) as $field_name) {
            $value = get_request_value($field_name);
            $contact_us['form'][$field_name] = $value;
            $data[$field_name] = $value;
        }
    
        if (contact_us_form_validate($contact_us['form'])) {
            $query = create_insert_query($app['db_link'], $contact_us['table']['name'], $data);
            $result = mysqli_query($app['db_link'], $query);
            redirect('contact_us.php'); 
        }
    }
    
    // выводим
    $layout = array(
        'title' => $app['title'] . ' :: ' . $contact_us['title'] . ' :: ' . $action,
        'content' => 'view/contact_us/create.php'
    );
    require 'layout/default.php';
} elseif ($action == 'update') {
    $contact_us['form']['error_msg'] = '';
    $id_field = $contact_us['table']['id_field'];
    if($step == 'show') {
        contact_us_form_get_record($id_field);
    } elseif ($step == 'process') {
        $contact_us['form'][$id_field] = get_request_value($id_field);
        $data = array();
        foreach(array_slice($contact_us['table']['fields'],1) as $field_name) {
            $value = get_request_value($field_name);
            $contact_us['form'][$field_name] = $value;
            $data[$field_name] = $value;
        }
        if (contact_us_form_validate($contact_us['form'])) {
            $query = create_update_query($app['db_link'], $contact_us['table']['name'], $data, $id_field . '=\'' . (int) $contact_us['form'][$id_field] . '\'');
            $result = mysqli_query($app['db_link'], $query);
            redirect('contact_us.php'); 
        }
    }
    
    // выводим
    $layout = array(
        'title' => $app['title'] . ' :: ' . $contact_us['title'] . ' :: ' . $action,
        'content' => 'view/contact_us/update.php'
    );
    require 'layout/default.php';
} elseif ($action == 'delete') {
    $id_field = $contact_us['table']['id_field'];
    if($step == 'show') {
        contact_us_form_get_record(get_request_value($id_field));
    } elseif ($step == 'process') {
        $query = 'delete from ' . $contact_us['table']['name'] . ' where ' . $id_field . '=\'' . (int) get_request_value($id_field) . '\'';
        $result = mysqli_query($app['db_link'], $query);
        redirect('contact_us.php'); 
    }
    // выводим
    $layout = array(
        'title' => $app['title'] . ' :: ' . $contact_us['title'] . ' :: ' . $action,
        'content' => 'view/contact_us/delete.php'
    );
    require 'layout/default.php';
}

function contact_us_form_get_record($id)
{
    global $app, $contact_us;
    
    $query = "select " . implode(', ', $contact_us['table']['fields']) . 
        ' from ' . $contact_us['table']['name'] . 
        ' where ' . $contact_us['table']['id_field'] . '=\'' . (int) $id . '\'';
    $row = mysqli_fetch_assoc(mysqli_query($app['db_link'], $query));
    foreach($row as $field_name => $value) {
        $contact_us['form'][$field_name] = $value;
    }
    
}

function contact_us_form_validate(&$form)
{
    $form_valid = true;
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $form_valid = false;
        $form['error_msg'] .= "Не верный email.<br>";    
    }
    if(strlen($form['subject']) < 3) {
        $form_valid = false;
        $form['error_msg'] .= "Введите тему.<br>";    
    }
    if(strlen($form['message']) < 10) {
        $form_valid = false;
        $form['error_msg'] .= "Введите сообщение.<br>";    
    }
    return $form_valid;
}
