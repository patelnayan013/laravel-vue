<?php


function errorResponse($message = 'Somethings goes wrong.', $errors = [], $code = 422) {
    $response = [
        'meta' => [
            'code' => $code,
            'message' => $message,
        ],
        'errors'      => $errors,
        'data' => []
    ];
    return \Response::json($response, $code);
}


function successResponse($message = 'Success!',$data = [], $code = 200) {
    $response = [
        'meta' => [
            'code' => $code,
            'message' => $message
        ],
        'errors'      => [],
        'data' => $data
    ];
    return \Response::json($response, $code);
}

function user(){
    return Auth::user();
}



function id(){
    return Auth::user()->id;
}

function currentTime(){
    return date('Y-m-d H:i:s');
}

function parseDBdate($date){
    if($date == "") {
        return null;
    }
    return date('Y-m-d',strtotime($date));
}


function viewDate($date){
    if($date == "") {
        return "";
    }
    return date('D, d M Y',strtotime($date));
}

function getPaginationInfo($data){
    return [
        'pagination' => [
            'total'        => $data->total(),
            'per_page'     => $data->perPage(),
            'from'         => $data->firstItem(),
            'to'           => $data->lastItem(),
            'current_page' => $data->currentPage(),
            'last_page'    => $data->lastPage()
        ],
        'data' => $data
    ];
}