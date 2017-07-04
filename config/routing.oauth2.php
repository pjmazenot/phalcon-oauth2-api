<?php

///////////////////////////////////
///// OAuth2 routes

// [POST] Generate token
if(class_exists('App\Controllers\OAuth2\OAuth2AccessTokenController')) {
	$app->post('/oauth/access_token', [new App\Controllers\OAuth2\OAuth2AccessTokenController(), 'generateToken']);
}

// [POST] Refresh token
if(class_exists('App\Controllers\OAuth2\OAuth2RefreshTokenController')) {
	$app->post('/oauth/refresh_token', [new App\Controllers\OAuth2\OAuth2RefreshTokenController(), 'refreshToken']);
}

// [GET|POST|PUT|DELETE] Test
if(class_exists('App\Controllers\OAuth2\OAuth2TestController')) {
	$app->get('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->post('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->put('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
	$app->delete('/oauth/test', [new App\Controllers\OAuth2\OAuth2TestController(), 'test']);
}