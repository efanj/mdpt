<?php

class VendorController extends Controller
{
  public function beforeAction()
  {
    parent::beforeAction();

    Config::setJsConfig("curPage", "vendor");

    $action = $this->request->param("action");
    $actions = ["create", "delete"];
    $this->Security->requireAjax($actions);
    $this->Security->requirePost($actions);

    switch ($action) {
      case "createReviewDesktop":
        $this->Security->config("validateForm", false);
        break;
      case "submitreviews":
        $this->Security->config("validateForm", false);
        break;
      case "submitiondatareviews":
        $this->Security->config("validateForm", false);
        break;
      case "evaluationtable":
        $this->Security->config("validateForm", false);
        break;
      case "createPS":
        $this->Security->config("form", ["fields" => ["id", "Akaun", "Digit", "Stcbk", "kawKwkod", "Thkod", "Bgkod", "Htkod", "Stkod", "Jpkod", "Sbkod", "Mesej"]]);
        break;
      case "rentbenchmarktable":
        $this->Security->config("validateForm", false);
        break;
      case "costbenchmarktable":
        $this->Security->config("validateForm", false);
        break;
      case "sitereviewtable":
        $this->Security->config("validateForm", false);
        break;
      case "submitsitereviewtable":
        $this->Security->config("validateForm", false);
        break;
      case "pendingsitereviewtable":
        $this->Security->config("validateForm", false);
        break;
      case "insertrentbenchmark":
        $this->Security->config("validateForm", false);
        break;
      case "insertcostbenchmark":
        $this->Security->config("validateForm", false);
        break;
      case "uploadbenchmarkdocs":
        $this->Security->config("validateForm", false);
        break;
      case "uploadimages":
        $this->Security->config("validateForm", false);
        break;
      case "uploaddocuments":
        $this->Security->config("validateForm", false);
        break;
      case "reviewSubmition":
        $this->Security->config("validateForm", false);
        break;
      case "buildingSubmit":
        $this->Security->config("validateForm", false);
        break;
      case "buildingEdit":
        $this->Security->config("validateForm", false);
        break;
      case "updatebreadth":
        $this->Security->config("validateForm", false);
        break;
      case "deletesitereview":
        $this->Security->config("form", ["fields" => ["file_id"]]);
        break;
      case "deleterentbenchmark":
        $this->Security->config("form", ["fields" => ["id"]]);
        break;
      case "deletecostbenchmark":
        $this->Security->config("form", ["fields" => ["id"]]);
        break;
      case "deletebenchdocument":
        $this->Security->config("form", ["fields" => ["doc_id"]]);
        break;
      case "deleteimage":
        $this->Security->config("form", ["fields" => ["image_id"]]);
        break;
      case "deletedocument":
        $this->Security->config("form", ["fields" => ["doc_id"]]);
        break;
    }
  }

  public function rentbenchmark()
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/rentbenchmark/", Config::get("VIEWS_PATH") . "vendor/rent-benchmark.php");
  }

  public function costbenchmark()
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/costbenchmark/", Config::get("VIEWS_PATH") . "vendor/cost-benchmark.php");
  }

  public function sitereview()
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/sitereview/", Config::get("VIEWS_PATH") . "vendor/sitereviews.php");
  }

  public function submissionlist()
  {
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/submissionlist/", Config::get("VIEWS_PATH") . "vendor/submissionlist.php");
  }

  public function pending()
  {
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/pending/", Config::get("VIEWS_PATH") . "vendor/pending.php");
  }

  public function submitsitereview()
  {
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/submitsitereview/", Config::get("VIEWS_PATH") . "vendor/submitsitereview.php");
  }

  public function evaluationlist()
  {
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/evaluationlist/", Config::get("VIEWS_PATH") . "vendor/evaluationlist.php");
  }

  public function investigation($fileId)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/investigation/", Config::get("VIEWS_PATH") . "vendor/investigation.php", ["fileId" => $fileId]);
  }
  public function submission($fileId)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/submission/", Config::get("VIEWS_PATH") . "vendor/submission.php", ["fileId" => $fileId]);
  }

  public function viewbenchmark($id)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/viewbenchmark/", Config::get("VIEWS_PATH") . "vendor/viewbenchmarkdocs.php", ["id" => $id]);
  }

  public function createBuildingCalc($reviewId)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/createBuildingCalc/", Config::get("VIEWS_PATH") . "vendor/calcbuilding.php", ["reviewId" => $reviewId]);
  }

  public function createEmptyLandCalc($reviewId)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/createEmptyLandCalc/", Config::get("VIEWS_PATH") . "vendor/calcland.php", ["reviewId" => $reviewId]);
  }

  public function editBuildingCalc($siriNo)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/editBuildingCalc/", Config::get("VIEWS_PATH") . "vendor/editBuildingCalc.php", ["siriNo" => $siriNo]);
  }

  public function editEmptyLandCalc($siriNo)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/editEmptyLandCalc/", Config::get("VIEWS_PATH") . "vendor/editEmptyLandCalc.php", ["siriNo" => $siriNo]);
  }

  public function viewimages($reviewId)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/viewimages/", Config::get("VIEWS_PATH") . "vendor/viewimages.php", ["reviewId" => $reviewId]);
  }

  public function viewdocuments($reviewId)
  {
    Config::setJsConfig("curPage", "vendor");
    $this->view->renderWithLayouts(Config::get("VIEWS_PATH") . "layout/vendor/viewdocuments/", Config::get("VIEWS_PATH") . "vendor/viewdocuments.php", ["reviewId" => $reviewId]);
  }

  public function createReviewDesktop()
  {
    $plgid = $this->request->data("plgid");
    $nmbil = $this->request->data("nmbil");
    $noAkaun = $this->request->data("noAkaun");
    $noLot = $this->request->data("noLot");
    $noPT = $this->request->data("noPT");
    $adpg1 = $this->request->data("adpg1");
    $adpg2 = $this->request->data("adpg2");
    $adpg3 = $this->request->data("adpg3");
    $adpg3 = $this->request->data("adpg3");
    $adpg4 = $this->request->data("adpg4");
    $jlkod = $this->request->data("jlkod");
    $kwkod = $this->request->data("kwkod");
    $tnama = $this->request->data("tnama");
    $bnama = $this->request->data("bnama");
    $hnama = $this->request->data("hnama");
    $snama = $this->request->data("snama");
    $lstnh = $this->request->data("lstnh");
    $lsbgn = $this->request->data("lsbgn");
    $lsans = $this->request->data("lsans");
    $lsbgn_tamb = $this->request->data("lsbgn_tamb");
    $lsans_tamb = $this->request->data("lsans_tamb");
    $codex = $this->request->data("codex");
    $codey = $this->request->data("codey");
    $catatan = $this->request->data("catatan");

    $result = $this->vendor->createReviewDesktop(Session::getUserId(), Session::getUserWorkerId(), $plgid, $nmbil, $noAkaun, $noLot, $noPT, $adpg1, $adpg2, $adpg3, $adpg4, $jlkod, $kwkod, $tnama, $bnama, $hnama, $snama, $lstnh, $lsbgn, $lsans, $lsbgn_tamb, $lsans_tamb, $codex, $codey, $catatan);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function submitreviews()
  {
    $rujukan = $this->request->data("rujukan");
    $tarikh = $this->request->data("tarikh");
    $data = $this->request->data("data");

    $result = $this->vendor->submitreviews(Session::getUserId(), Session::getUserWorkerId(), $rujukan, $tarikh, $data);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function submitiondatareviews()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = strtoupper($search["value"]);
    $result = $this->vendor->submitiondatareviews($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function createPS()
  {
    $id = $this->request->data("id");
    $Akaun = $this->request->data("Akaun");
    $Digit = $this->request->data("Digit");
    $Stcbk = $this->request->data("Stcbk");
    $kawKwkod = $this->request->data("kawKwkod");
    $Thkod = $this->request->data("Thkod");
    $Bgkod = $this->request->data("Bgkod");
    $Htkod = $this->request->data("Htkod");
    $Stkod = $this->request->data("Stkod");
    $Jpkod = $this->request->data("Jpkod");
    $Sbkod = $this->request->data("Sbkod");
    $Mesej = $this->request->data("Mesej");

    $result = $this->vendor->createPS(Session::getUserId(), Session::getUserWorkerId(), $id, $Akaun, $Digit, $Stcbk, $kawKwkod, $Thkod, $Bgkod, $Htkod, $Stkod, $Jpkod, $Sbkod, $Mesej);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function rentbenchmarktable()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = strtoupper($search["value"]);
    $result = $this->vendor->rentbenchmarktable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function costbenchmarktable()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = strtoupper($search["value"]);
    $result = $this->vendor->costbenchmarktable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function sitereviewtable()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = $search["value"];
    $area = $this->request->data("area");
    $street = $this->request->data("street");
    $result = $this->vendor->sitereviewtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area, $street);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function evaluationtable()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = $search["value"];
    $result = $this->vendor->evaluationtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function submitsitereviewtable()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = $search["value"];
    $submitId = $this->request->data("date");
    $result = $this->vendor->submitsitereviewtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $submitId);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function pendingsitereviewtable()
  {
    $draw = $this->request->data("draw");
    $row = $this->request->data("start");
    $rowperpage = $this->request->data("length");
    $column = $this->request->data("order");
    $columnIndex = $column[0]["column"];
    $columns = $this->request->data("columns");
    $columnName = $columns[$columnIndex]["data"];
    $columnSortOrder = $column[0]["dir"];
    $search = $this->request->data("search");
    $searchValue = $search["value"];
    $area = $this->request->data("area");
    $street = $this->request->data("street");
    $result = $this->vendor->pendingsitereviewtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area, $street);
    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function insertrentbenchmark()
  {
    $ratetype = $this->request->data("ratetype");
    $akaun = $this->request->data("akaun");
    $pemilik = $this->request->data("pemilik");
    $jlkod = $this->request->data("jlkod");
    $kwkod = $this->request->data("kwkod");
    $htkod = $this->request->data("htkod");
    $items_rent = $this->request->data("items_rent");

    $result = $this->vendor->insertrentbenchmark(Session::getUserId(), $ratetype, $akaun, $pemilik, $jlkod, $kwkod, $htkod, $items_rent);

    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function insertcostbenchmark()
  {
    $ratetype = $this->request->data("ratetype");
    $akaun = $this->request->data("akaun");
    $pemilik = $this->request->data("pemilik");
    $jlkod = $this->request->data("jlkod");
    $kwkod = $this->request->data("kwkod");
    $htkod = $this->request->data("htkod");
    $items_cost = $this->request->data("items_cost");

    $result = $this->vendor->insertcostbenchmark(Session::getUserId(), $ratetype, $akaun, $pemilik, $jlkod, $kwkod, $htkod, $items_cost);

    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function uploadbenchmarkdocs()
  {
    $id = Encryption::decryptId($this->request->data("id"));
    $file_type = $this->request->data("file_type");
    $filename = $this->request->data("filename");
    $description = $this->request->data("description");
    $fileData = $this->request->data("file");

    $file = $this->vendor->uploadbenchmarkdocs(Session::getUserId(), $id, $file_type, $filename, $description, $fileData);

    if (!$file) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $fileHTML = $this->view->render(Config::get("VIEWS_PATH") . "vendor/benchmarkdocs.php", ["files" => $file]);
      $this->view->renderJson(["data" => $fileHTML]);
    }
  }

  public function uploadimages()
  {
    $no_akaun = $this->request->data("no_akaun");
    $filename = $this->request->data("filename");
    $description = $this->request->data("description");
    $fileData = $this->request->data("file");

    $file = $this->vendor->uploadimages(Session::getUserId(), $no_akaun, $filename, $description, $fileData);

    if (!$file) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $fileHTML = $this->view->render(Config::get("VIEWS_PATH") . "vendor/files.php", ["files" => $file]);
      $this->view->renderJson(["data" => $fileHTML]);
    }
  }

  public function uploaddocuments()
  {
    $no_akaun = $this->request->data("no_akaun");
    $file_type = $this->request->data("file_type");
    $filename = $this->request->data("filename");
    $description = $this->request->data("description");
    $fileData = $this->request->data("file");

    $file = $this->vendor->uploaddocuments(Session::getUserId(), $no_akaun, $file_type, $filename, $description, $fileData);

    if (!$file) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $fileHTML = $this->view->render(Config::get("VIEWS_PATH") . "vendor/docs.php", ["files" => $file]);
      $this->view->renderJson(["data" => $fileHTML]);
    }
  }

  public function buildingSubmit()
  {
    $siriNo = $this->account->generateSiriNo();
    $akaun = $this->request->data("akaun");
    $comparison = $this->request->data("comparison");
    $breadth_land = $this->request->data("breadth_land");
    $price_land = $this->request->data("price_land");
    $section_one = $this->request->data("section_one");
    $section_two = $this->request->data("section_two");
    $discount = $this->request->data("discount");
    $rental = $this->request->data("rental");
    $even = $this->request->data("even");
    $yearly = $this->request->data("yearly");
    $rate = $this->request->data("rate");
    $tax = $this->request->data("tax");

    $result = $this->vendor->buildingSubmit(Session::getUserId(), Session::getUserWorkerId(), $siriNo, $akaun, $comparison, $breadth_land, $price_land, $section_one, $section_two, $discount, $rental, $even, $yearly, $rate, $tax);

    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function buildingEdit()
  {
    $siriNo = $this->request->data("siri_no");
    $akaun = $this->request->data("akaun");
    $comparison = $this->request->data("comparison");
    $breadth_land = $this->request->data("breadth_land");
    $price_land = $this->request->data("price_land");
    $section_one = $this->request->data("section_one");
    $section_two = $this->request->data("section_two");
    $discount = $this->request->data("discount");
    $rental = $this->request->data("rental");
    $even = $this->request->data("even");
    $yearly = $this->request->data("yearly");
    $rate = $this->request->data("rate");
    $tax = $this->request->data("tax");

    $result = $this->vendor->buildingEdit(Session::getUserId(), Session::getUserWorkerId(), $siriNo, $akaun, $comparison, $breadth_land, $price_land, $section_one, $section_two, $discount, $rental, $even, $yearly, $rate, $tax);

    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function reviewSubmition()
  {
    $id = $this->request->data("id");

    $result = $this->vendor->reviewSubmition(Session::getUserId(), $id);

    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function updatebreadth()
  {
    $id = Encryption::decryptId($this->request->data("id"));
    $akaun = Encryption::decryptId($this->request->data("akaun"));
    $lsbgn = $this->request->data("lsbgn");
    $lsans = $this->request->data("lsans");
    $nota = $this->request->data("nota");

    $result = $this->vendor->updatebreadth(Session::getUserId(), $id, $akaun, $lsbgn, $lsans, $nota);

    if (!$result) {
      $this->view->renderErrors($this->vendor->errors());
    } else {
      $this->view->renderJson($result);
    }
  }

  public function deletesitereview()
  {
    $fileId = Encryption::decryptId($this->request->data("file_id"));

    $this->vendor->deletesitereview(Session::getUserId(), $fileId);

    $this->view->renderJson(["success" => true]);
  }

  public function deleterentbenchmark()
  {
    $rowId = Encryption::decryptId($this->request->data("id"));

    $this->vendor->deleterentbenchmark(Session::getUserId(), $rowId);

    $this->view->renderJson(["success" => true]);
  }

  public function deletecostbenchmark()
  {
    $rowId = Encryption::decryptId($this->request->data("id"));

    $this->vendor->deletecostbenchmark(Session::getUserId(), $rowId);

    $this->view->renderJson(["success" => true]);
  }

  public function deletebenchdocument()
  {
    $docId = Encryption::decryptId($this->request->data("doc_id"));

    $this->vendor->deletebenchdocument(Session::getUserId(), $docId);

    $this->view->renderJson(["success" => true]);
  }

  public function deleteimage()
  {
    $imageId = Encryption::decryptId($this->request->data("image_id"));

    $this->vendor->deleteimage(Session::getUserId(), $imageId);

    $this->view->renderJson(["success" => true]);
  }

  public function deletedocument()
  {
    $docId = Encryption::decryptId($this->request->data("doc_id"));

    $this->vendor->deletedocument(Session::getUserId(), $docId);

    $this->view->renderJson(["success" => true]);
  }

  public function isAuthorized()
  {
    $action = $this->request->param("action");
    $role = Session::getUserRole();
    $resource = "vendor";

    //only for admin
    Permission::allow("administrator", $resource, "*");

    //only for user
    Permission::allow("penilaian", $resource, ["submitsitereview"]);

    //only for normal vendor
    Permission::allow("vendor", $resource, "*");

    return Permission::check($role, $resource, $action);
  }
}