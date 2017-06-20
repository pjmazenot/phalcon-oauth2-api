<?php

///////////////////////////////////
///// OAuth2 routes

// [POST] Generate token
if(class_exists('App\Controllers\OAuth2\OAuth2GenerateAccessTokenController')) {
	$app->post('/auth/generate-token', [new App\Controllers\OAuth2\OAuth2GenerateAccessTokenController(), 'generateToken']);
}

// [GET|POST|PUT|DELETE] Test
if(class_exists('App\Controllers\OAuth2\OAuth2TestController')) {
	$app->get('/auth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->post('/auth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->put('/auth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->delete('/auth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
}