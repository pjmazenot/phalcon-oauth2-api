<?php

///////////////////////////////////
///// OAuth2 routes

// [POST] Generate token
if(class_exists('App\OAuth2\Controllers\OAuth2AccessTokenController')) {
	$app->post('/oauth/access_token', [new App\OAuth2\Controllers\OAuth2AccessTokenController(), 'generateToken']);
}

// [POST] Refresh token
if(class_exists('App\OAuth2\Controllers\OAuth2RefreshTokenController')) {
	$app->post('/oauth/refresh_token', [new App\OAuth2\Controllers\OAuth2RefreshTokenController(), 'refreshToken']);
}

// [GET|POST|PUT|DELETE] Test
if(class_exists('App\OAuth2\Controllers\OAuth2TestController')) {
	$app->get('/oauth/test', [new App\OAuth2\Controllers\OAuth2TestController(), 'test']);
	$app->post('/oauth/test', [new App\OAuth2\Controllers\OAuth2TestController(), 'test']);
	$app->put('/oauth/test', [new App\OAuth2\Controllers\OAuth2TestController(), 'test']);
	$app->delete('/oauth/test', [new App\OAuth2\Controllers\OAuth2TestController(), 'test']);
}