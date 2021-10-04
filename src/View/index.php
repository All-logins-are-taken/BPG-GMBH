<?php
require_once __DIR__.'/../../vendor/autoload.php';

use App\Controller\PhonebookController;
use App\Database\RDBMS;
use App\Http\Router;
use App\Http\Request;
use App\Http\Response;
use App\Model\Phonebook;
use App\Validator\PhoneNumberValidator;
use App\Service\PhonebookService;

$service = new PhonebookService();
$phonebook = new PhonebookController((new Phonebook((new RDBMS()), $service)), (new PhoneNumberValidator($service)), $service);

Router::get('/', function (Request $request, Response $response) use ($phonebook) {
    $response->getResponse($phonebook->getPhoneNumberList());
});

Router::post('/', function (Request $request, Response $response) use ($phonebook) {
    $request->getBody()['action'] ?? header('Location: /');

    $action = $request->getBody()['action'];

    if ($action === 'add') {
        $request->getBody()['number'] ?? header('Location: /');

        $response->getResponse($phonebook->addPhoneNumber($request->getBody()['number']));
    }
    elseif ($action === 'search') {
        $request->getBody()['number'] ?? header('Location: /');

        $response->getResponse($phonebook->searchPhoneNumber($request->getBody()['number']));
    }
    elseif ($action === 'delete') {
        $request->getBody()['id'] ?? header('Location: /');

        $response->getResponse($phonebook->deletePhoneNumber($request->getBody()['id']));
    }
});
