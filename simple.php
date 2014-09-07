<?php
use Phalcon\DI\FactoryDefault,
	Phalcon\Mvc\Micro,
	Phalcon\Http\Response,
	Phalcon\Http\Request;

$di = new FactoryDefault();

//Using an anonymous function, the instance will be lazy loaded
$di["response"] = function () {
	return new Response();
};

$di["request"] = function () {
	return new Request();
};

$app = new Micro();

$app->setDI( $di );

$app->get( '/api', function () use ( $app ) {
	echo "Welcome";
} );

$app->post( '/api', function () use ( $app ) {
	$post = $app->request->getPost();
	print_r( $post );
} );

$app->notFound(
	function () use ( $app ) {
		$app->response->setStatusCode( 404, "Not Found" )->sendHeaders();
		echo 'This is crazy, but this page was not found!';
	}
);

$app->handle();
