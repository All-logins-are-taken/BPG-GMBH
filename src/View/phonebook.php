<?php

$output = '';
$listDivsOpen = '<div class="col border-info bg-success border-end border-bottom pt-1 pb-1 text-center fw-bold text-white">';
$listDivsClose = '</div>';
$listHeaderDivsOpen = '<div class="col border-dark bg-info border-end pt-1 pb-1 text-center fw-bold">';

/** @var string $options */
if (!empty($options)) {
    $phonebook = json_decode($options, true);

    if ($phonebook['success'] === false) {
        $output = '<div class="row"></div><div class="col-12 bg-warning border-end pt-1 pb-1 text-center fw-bold">' . $phonebook['message'] . '</div></div>';
    } else {
        if (is_array($phonebook['message'])) {
            foreach ($phonebook['message'] as $list) {
                $action = '';

                if ($list["deleted"] == 0) {
                    $action = '<form class="d-flex m-auto" id="delete_form_' . $list["id"] . '">
                                  <input id="delete_input_' . $list["id"] . '" type="hidden" name="id" value="' . $list["id"] . '" />
                                  <button class="btn btn-danger w-100 white" type="button" onclick="handler(\'delete\', ' . $list["id"] . ')" id="delete_button_' . $list["id"] . '">Delete</button>
                                </form>';
                }

                $output .= '
                    <div class="row">
                        ' . $listDivsOpen . $list["id"] . $listDivsClose .
                    $listDivsOpen . $list["prefix"] . $listDivsClose .
                    $listDivsOpen . $list["number"] . $listDivsClose .
                    $listDivsOpen . $list["name"] . $listDivsClose .
                    $listDivsOpen . $list["updated_at"] . $listDivsClose .
                    $listDivsOpen . $list["deleted"] . $listDivsClose .
                    $listDivsOpen . $action . $listDivsClose . '
                  </div>
                ';
            }
        } else {
            $output = '<div class="row"></div><div class="col-12 bg-info border-end pt-1 pb-1 text-center fw-bold">' . $phonebook['message'] . '</div></div>';
        }
    }
}

include_once __DIR__ . '/Layout/header.php';

echo '      
    <header>      
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">all_phone_book</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>          
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <form id="add_form" class="d-flex m-auto">
              <div id="add_message"></div>
              <input id="add_input" name="number" class="form-control me-2" type="search" placeholder="Phone: +40312295914" aria-label="Search" min="7" max="20">
              <button id="add_button" class="btn btn-outline-info w-100" onclick="handler(\'add\')" type="button">Add phone number</button>
            </form>
          
            <form id="search_form" class="d-flex m-auto">
              <div id="search_message"></div>
              <input id="search_input" class="form-control me-2" type="search" placeholder="Phone: +40312295914" aria-label="Search" min="7" max="20">
              <button id="search_button" class="btn btn-outline-success" type="button"  onclick="handler(\'search\')">Search</button>
            </form>
          </div>
        </div>
      </nav>
    </header>

    <main class="flex-shrink-0 m-5">
      <div class="container">
        <h1 class="mt-5">BPG practical test with all_phone_book</h1>
        <p class="lead">Insert, attempt to duplicate insert, search, delete.</p>
        <div id="message"></div>
          <div class="row">
            ' . $listHeaderDivsOpen . 'Id' . $listDivsClose .
    $listHeaderDivsOpen . 'Prefix' . $listDivsClose .
    $listHeaderDivsOpen . 'Number' . $listDivsClose .
    $listHeaderDivsOpen . 'Name' . $listDivsClose .
    $listHeaderDivsOpen . 'UpdatedAt' . $listDivsClose .
    $listHeaderDivsOpen . 'Deleted' . $listDivsClose .
    $listHeaderDivsOpen . 'Action' . $listDivsClose . '
          </div>
            ' . $output . '
';

include_once __DIR__ . '/Layout/footer.php';
