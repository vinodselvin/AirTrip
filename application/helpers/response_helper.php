<?php

function success($that, $data = array(), $message = null){

    $response = unserialize(SUCCESS_RESPONSE_FORMAT);

    $response['data'] = $data;
    $response['message'] = $message;

    $that->response($response, REST_Controller::HTTP_OK);
}

function error($that, $data = array(), $message = null){

    $response = unserialize(ERROR_RESPONSE_FORMAT);

    $response['data'] = $data;
    $response['message'] = $message;

    $that->response($response, REST_Controller::HTTP_OK);
}