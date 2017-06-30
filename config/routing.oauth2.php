<?php

///////////////////////////////////
///// OAuth2 routes

// [POST] Generate token
if(class_exists('App\Controllers\OAuth2\OAuth2AccessTokenController')) {
	$app->post('/oauth/access_token', [new App\Controllers\OAuth2\OAuth2AccessTokenController(), 'generateToken']);
}
}

// [GET|POST|PUT|DELETE] Test
if(class_exists('App\Controllers\OAuth2\OAuth2TestController')) {
	$app->get('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->post('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->put('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->delete('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
}