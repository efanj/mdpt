<?php

class Vendor extends Model
{
  public function escapeJsonString($value)
  {
    # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = ["\""];
    $replacements = [""];
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }

  public function generateSiriNo()
  {
    $siriNo = mt_rand(100000, 999999);
    return $siriNo;
  }

  public function checkSiriNo($data)
  {
    if ($data == null || $data == "") {
      return "-";
    } else {
      return Encryption::encryptId($data);
    }
  }

  public function checkNull($data)
  {
    if ($data == null || $data == "") {
      return "-";
    } else {
      return $data;
    }
  }

  public function checkNullNumber($data)
  {
    if ($data == null || $data == "") {
      return 0;
    } else {
      return $data;
    }
  }

  public function createReviewDesktop($userId, $workerId, $plgid, $nmbil, $noAkaun, $noLot, $noPT, $adpg1, $adpg2, $adpg3, $adpg4, $jlkod, $kwkod, $tnama, $bnama, $hnama, $snama, $lstnh, $lsbgn, $lsans, $lsbgn_tamb, $lsans_tamb, $codex, $codey, $catatan)
  {

    $plgid = empty($plgid) ? null : $plgid;
    $nmbil = empty($nmbil) ? null : $nmbil;
    $noAkaun = empty($noAkaun) ? null : $noAkaun;
    $noLot = empty($noLot) ? null : $noLot;
    $noPT = empty($noPT) ? null : $noPT;
    $adpg1 = empty($adpg1) ? null : $adpg1;
    $adpg2 = empty($adpg2) ? null : $adpg2;
    $adpg3 = empty($adpg3) ? null : $adpg3;
    $adpg4 = empty($adpg4) ? null : $adpg4;
    $jlkod = empty($jlkod) ? "0" : $jlkod;
    $kwkod = empty($kwkod) ? "0" : $kwkod;
    $tnama = empty($tnama) ? "0" : $tnama;
    $bnama = empty($bnama) ? "0" : $bnama;
    $hnama = empty($hnama) ? "0" : $hnama;
    $snama = empty($snama) ? "0" : $snama;
    $lstnh = empty($lstnh) ? "0" : $lstnh;
    $lsbgn = empty($lsbgn) ? "0" : $lsbgn;
    $lsans = empty($lsans) ? "0" : $lsans;
    $lsbgn_tamb = empty($lsbgn_tamb) ? "0" : $lsbgn_tamb;
    $lsans_tamb = empty($lsans_tamb) ? "0" : $lsans_tamb;
    $codex = empty($codex) ? null : substr($codex, 0, 15);
    $codey = empty($codey) ? null : substr($codey, 0, 15);
    $type = 1;

    $database = Database::openConnection();

    $query = "INSERT INTO data.smktpk(smk_akaun, smk_nolot, smk_nompt, smk_adpg1, smk_adpg2, smk_adpg3, smk_adpg4, smk_jalan, smk_kodkws, smk_jstnh, smk_jsbgn, ";
    $query .= "smk_kgtnh, smk_stbgn, smk_lsbgn, smk_lstnh, smk_lsans, smk_lsbgn_tmbh, smk_lsans_tmbh, smk_codex, smk_codey, smk_onama, smk_type) ";
    $query .= "VALUES(:smk_akaun, :smk_nolot, :smk_nompt, :smk_adpg1, :smk_adpg2, :smk_adpg3, :smk_adpg4, :smk_jalan, :smk_kodkws, :smk_jstnh, :smk_jsbgn, ";
    $query .= ":smk_kgtnh, :smk_stbgn, :smk_lsbgn, :smk_lstnh, :smk_lsans, :smk_lsbgn_tmbh, :smk_lsans_tmbh, :smk_codex, :smk_codey, :smk_onama, :smk_type)";

    $database->prepare($query);
    $database->bindValue(":smk_akaun", $noAkaun);
    $database->bindValue(":smk_nolot", $noLot);
    $database->bindValue(":smk_nompt", $noPT);
    $database->bindValue(":smk_adpg1", $adpg1);
    $database->bindValue(":smk_adpg2", $adpg2);
    $database->bindValue(":smk_adpg3", $adpg3);
    $database->bindValue(":smk_adpg4", $adpg4);
    $database->bindValue(":smk_jalan", $jlkod);
    $database->bindValue(":smk_kodkws", $kwkod);
    $database->bindValue(":smk_jstnh", $tnama);
    $database->bindValue(":smk_jsbgn", $bnama);
    $database->bindValue(":smk_kgtnh", $hnama);
    $database->bindValue(":smk_stbgn", $snama);
    $database->bindValue(":smk_lsbgn", $lsbgn);
    $database->bindValue(":smk_lstnh", $lstnh);
    $database->bindValue(":smk_lsans", $lsans);
    $database->bindValue(":smk_lsbgn_tmbh", $lsbgn_tamb);
    $database->bindValue(":smk_lsans_tmbh", $lsans_tamb);
    $database->bindValue(":smk_codex", $codex);
    $database->bindValue(":smk_codey", $codey);
    $database->bindValue(":smk_onama", $workerId);
    $database->bindValue(":smk_type", "2");
    $result = $database->execute();
    $smkId = $database->lastInsertedId();

    if ($database->countRows() !== 1) {
      throw new Exception("Gagal untuk masukkan data nilaian semula.");
    }

    if ($result) {
      $insQry = "INSERT INTO data.pindaan_raw (id_smk, no_akaun, type, luas_bangunan, luas_ansolari, catatan_hadapan) ";
      $insQry .= "VALUES(" . $smkId . ",'" . $noAkaun . "', " . $type . ", " . $lsbgn_tamb . ", " . $lsans_tamb . ", '" . $catatan . "')";
      $alter = $database->prepare($insQry);
      $database->execute($alter);

      if ($codex != null && $codey != null) {
        $qry = "INSERT INTO data.coordinates (akaun, plgid, nama, codex, codey, nolot, geom) ";
        $qry .= "VALUES($noAkaun, '" . $plgid . "', '" . $nmbil . "', $codex, $codey, '" . $noLot . "', ST_SetSRID(ST_MakePoint($codex, $codey), 4326))";
        $database->prepare($qry);
        $database->execute();
      }

      $activity = "Semakan Nilaian Semula : No akaun - " . $noAkaun;
      $database->logActivity($userId, $activity);
    }
    return true;
  }

  public function submitreviews($userId, $workerId, $rujukan, $tarikh, $data)
  {

    $rujukan = empty($rujukan) ? null : $rujukan;
    $tarikh = empty($tarikh) ? null : $tarikh;
    $result = $data ? explode(',', $data) : array();
    $integers = array_map('intval', $result);
    $dataInts = $this->escapeJsonString(str_replace(["[", "]"], ["{", "}"], json_encode($integers)));

    $database = Database::openConnection();

    $query = "INSERT INTO data.submission (reference, submition_date, workerid, items)";
    $query .= "VALUES(:reference, :submition_date, :workerid, :items)";

    $database->prepare($query);
    $database->bindValue(":reference", $rujukan);
    $database->bindValue(":submition_date", $tarikh);
    $database->bindValue(":workerid", $workerId);
    $database->bindValue(":items", $dataInts);
    $result = $database->execute();

    $submitId = $database->lastInsertedId();

    foreach ($integers as $id) {
      $qry = "UPDATE data.smktpk SET smk_stspn = 2, smk_submit_id = " . $submitId . " WHERE id = " . $id;
      $database->prepare($qry);
      $database->execute();
    }

    if ($database->countRows() !== 1) {
      throw new Exception("Gagal untuk masukkan data Penyerahan Nilaian Semula.");
    }

    if ($result) {
      $activity = "Penyerahan Nilaian Semula : Rujukan - " . $rujukan . " Tarikh - " . $tarikh;
      $database->logActivity($userId, $activity);
    }
    return ["success" => true];
  }

  public function createPS($userId, $workerId, $id, $Akaun, $Digit, $Stcbk, $kawKwkod, $Thkod, $Bgkod, $Htkod, $Stkod, $Jpkod, $Sbkod, $Mesej)
  {

    if ($this->checkEmptyLand($Htkod)) {
      $calcUrl = "calclandvendor";
      $calcType = "1";
    } else {
      $calcUrl = "calcbuildingvendor";
      $calcType = "2";
    }

    $Nsiri = $this->generateSiriNo();
    $Akaun = empty($Akaun) ? "0" : $Akaun;
    $Digit = empty($Digit) ? "0" : $Digit;
    $Thkod = empty($Thkod) ? "0" : $Thkod;
    $Bgkod = empty($Bgkod) ? "0" : $Bgkod;
    $Htkod = empty($Htkod) ? "0" : $Htkod;
    $Stkod = empty($Stkod) ? "0" : $Stkod;
    $Jpkod = empty($Jpkod) ? "0" : $Jpkod;
    $Sbkod = empty($Sbkod) ? null : $Sbkod;
    $Mesej = empty($Mesej) ? null : $Mesej;
    $Stcbk = empty($Stcbk) ? "T" : $Stcbk;
    $Statf = null;
    $Hsiri = "0";
    $Tkpos = null;
    $Etdate = date("Y-m-d");

    $database = Database::openConnection();

    $query = "INSERT INTO data.v_hacmjb(mjb_nsiri, mjb_akaun, mjb_digit, mjb_thkod, mjb_htkod, mjb_jpkod, mjb_bgkod, mjb_stkod, ";
    $query .= "mjb_sbkod, mjb_mesej, mjb_statf, mjb_hsiri, mjb_stcbk, mjb_tkpos, mjb_etdate, mjb_stsvd, mjb_calcty) ";
    $query .= "VALUES(:mjb_nsiri, :mjb_akaun, :mjb_digit, :mjb_thkod, :mjb_htkod, :mjb_jpkod, :mjb_bgkod, :mjb_stkod, :mjb_sbkod, ";
    $query .= ":mjb_mesej, :mjb_statf, :mjb_hsiri, :mjb_stcbk, :mjb_tkpos, :mjb_etdate, :mjb_stsvd, :mjb_calcty)";

    $database->prepare($query);
    $database->bindValue(":mjb_nsiri", $Nsiri);
    $database->bindValue(":mjb_akaun", $Akaun);
    $database->bindValue(":mjb_digit", $Digit);
    $database->bindValue(":mjb_thkod", $Thkod);
    $database->bindValue(":mjb_htkod", $Htkod);
    $database->bindValue(":mjb_jpkod", $Jpkod);
    $database->bindValue(":mjb_bgkod", $Bgkod);
    $database->bindValue(":mjb_stkod", $Stkod);
    $database->bindValue(":mjb_sbkod", $Sbkod);
    $database->bindValue(":mjb_mesej", $Mesej);
    $database->bindValue(":mjb_statf", $Statf);
    $database->bindValue(":mjb_hsiri", $Hsiri);
    $database->bindValue(":mjb_stcbk", $Stcbk);
    $database->bindValue(":mjb_tkpos", $Tkpos);
    $database->bindValue(":mjb_etdate", $Etdate);
    $database->bindValue(":mjb_stsvd", "1");
    $database->bindValue(":mjb_calcty", $calcType);
    $result = $database->execute();

    if ($database->countRows() !== 1) {
      throw new Exception("Gagal untuk masukkan data Penyerahan Nilaian Semula.");
    }

    if ($result) {
      $database->updateStatusSubmitted($id);

      $activity = "Penyerahan Nilaian Semula : No akaun - " . $Akaun . " No Siri - " . $Nsiri;
      $database->logActivity($userId, $activity);
    }
    return ["success" => true, "sirino" => Encryption::encryptId($Nsiri), "calcUrl" => $calcUrl];
  }

  public function submitiondatareviews($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "h.hrt_hnama LIKE '%" . $searchValue . "%' OR h2.bgn_bnama LIKE '%" . $searchValue . "%' OR m.jln_jnama LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.submission s ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.submission s ";
    if ($searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT id, reference, submition_date, workerid, items FROM data.submission s ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $rows = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["id"] = $val["id"];
      $rowOutput["reference"] = $val["reference"];
      $rowOutput["submition_date"] = date("d/m/Y", strtotime($val["submition_date"]));
      $rowOutput["items"] = $val["items"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function rentbenchmarktable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "h.hrt_hnama LIKE '%" . $searchValue . "%' OR h2.bgn_bnama LIKE '%" . $searchValue . "%' OR m.jln_jnama LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.benchmark f ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.benchmark f ";
    if ($searchValue != "") {
      $sql .= "WHERE f.parent = 0 AND f.jenis = 1 AND " . $searchQuery;
    } else {
      $sql .= "WHERE f.parent = 0 AND f.jenis = 1";
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT f.* FROM data.benchmark f ";
    if ($searchValue != "") {
      $query .= "WHERE f.parent = 0 AND f.jenis = 1 AND " . $searchQuery;
    } else {
      $query .= "WHERE f.parent = 0 AND f.jenis = 1";
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $rows = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["id"] = Encryption::encryptId($val["id"]);
      $rowOutput["jenis"] = $val["jenis"];
      $rowOutput["kwkod"] = $val["kwkod"];
      $rowOutput["htkod"] = $val["htkod"];
      $rowOutput["bgkod"] = $val["bgkod"];
      $rowOutput["nota"] = $val["nota"];
      $rowOutput["nilai"] = $val["nilai"];
      $rowOutput["kws_knama"] = $dbOracle->getElementById("SPMC.V_MKWJLN", "kws_knama", "kws_kwkod", $val["kwkod"]);
      $rowOutput["hrt_hnama"] = $dbOracle->getElementById("SPMC.V_HHARTA", "hrt_hnama", "hrt_htkod", $val["htkod"]);
      $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["bgkod"]);
      if ($val["bgside"] == 1) {
        $rowOutput["bgside"] = "MFA";
      } elseif ($val["bgside"] == 2) {
        $rowOutput["bgside"] = "AFA";
      }
      $rowOutput["childs"] = $this->getChildsBenchMark($val["id"]);
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function costbenchmarktable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "h.hrt_hnama LIKE '%" . $searchValue . "%' OR h2.bgn_bnama LIKE '%" . $searchValue . "%' OR f.nmbil LIKE '%" . $searchValue . "%' OR m.jln_jnama LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.benchmark f ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.benchmark f ";
    if ($searchValue != "") {
      $sql .= "WHERE f.parent = 0 AND f.jenis = 2 AND " . $searchQuery;
    } else {
      $sql .= "WHERE f.parent = 0 AND f.jenis = 2";
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT f.* FROM data.benchmark f ";
    if ($searchValue != "") {
      $query .= "WHERE f.parent = 0 AND f.jenis = 2 AND " . $searchQuery;
    } else {
      $query .= "WHERE f.parent = 0 AND f.jenis = 2";
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $rows = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {
      $rowOutput["id"] = Encryption::encryptId($val["id"]);
      $rowOutput["jenis"] = $val["jenis"];
      $rowOutput["kwkod"] = $val["kwkod"];
      $rowOutput["htkod"] = $val["htkod"];
      $rowOutput["bgkod"] = $val["bgkod"];
      $rowOutput["nota"] = $val["nota"];
      $rowOutput["nilai"] = $val["nilai"];
      $rowOutput["kws_knama"] = $dbOracle->getElementById("SPMC.V_MKWJLN", "kws_knama", "kws_kwkod", $val["kwkod"]);
      $rowOutput["hrt_hnama"] = $dbOracle->getElementById("SPMC.V_HHARTA", "hrt_hnama", "hrt_htkod", $val["htkod"]);
      $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["bgkod"]);
      if ($val["bgside"] == 1) {
        $rowOutput["bgside"] = "MFA";
      } elseif ($val["bgside"] == 2) {
        $rowOutput["bgside"] = "AFA";
      }
      $rowOutput["childs"] = $this->getChildsBenchMark($val["id"]);
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function sitereviewtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "", $street = "")
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(s.smk_akaun AS TEXT) iLIKE '%" . $searchValue . "%' OR CAST(s.smk_nolot AS TEXT) iLIKE '%" . $searchValue . "%' OR s.smk_adpg1 iLIKE '%" . $searchValue . "%' OR s.smk_adpg2 iLIKE '%" . $searchValue . "%' OR s.workerid iLIKE '%" . $searchValue . "%' OR s.name iLIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_semak_raw s ";
    $sql .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_semak_raw s ";
    $sql .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $sql .= "WHERE s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street . " AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $sql .= "WHERE s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street;
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT s.*, c.siri_no, f.file, d.doc FROM data.v_semak_raw s ";
    $query .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    $query .= "LEFT JOIN (select count(*) as file, no_akaun from data.files group by no_akaun) f ON s.smk_akaun = f.no_akaun ";
    $query .= "LEFT JOIN (select count(*) as doc, no_akaun from data.fdocs group by no_akaun) d ON s.smk_akaun = d.no_akaun ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $query .= "WHERE s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street . " AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $query .= "WHERE s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street;
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $row = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {

      $dbOracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["smk_akaun"]);
      $info = $dbOracle->fetchAssociative();

      if ($this->checkEmptyLand($info["peg_htkod"])) {
        if ($this->checkNull($val["siri_no"]) == "-") {
          $calcType = "createEmptyLandCalc";
        } else {
          $calcType = "editEmptyLandCalc";
        }
      } else {
        if ($this->checkNull($val["siri_no"]) == "-") {
          $calcType = "createBuildingCalc";
        } else {
          $calcType = "editBuildingCalc";
        }
      }

      $rowOutput["id"] = Encryption::encryptId($val["id"]);
      $rowOutput["sid"] = $val["id"];
      $rowOutput["akaun"] = Encryption::encryptId($val["smk_akaun"]);
      $rowOutput["sirino"] = $this->checkSiriNo($val["siri_no"]);
      $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
      $rowOutput["pmk_plgid"] = $info["pmk_plgid"];
      $rowOutput["pmk_hkmlk"] = $info["pmk_hkmlk"];
      $rowOutput["peg_pelan"] = $info["peg_pelan"];
      $rowOutput["peg_rjmmk"] = $info["peg_rjmmk"];
      $rowOutput["peg_nilth"] = $info["peg_nilth"];
      $rowOutput["kaw_kadar"] = $info["kaw_kadar"];
      $rowOutput["peg_tksir"] = $info["peg_tksir"];
      $rowOutput["smk_akaun"] = $val["smk_akaun"];
      $rowOutput["smk_nolot"] = $val["smk_nolot"];
      $rowOutput["smk_nompt"] = $val["smk_nompt"];
      $rowOutput["smk_adpg1"] = $val["smk_adpg1"];
      $rowOutput["smk_adpg2"] = $val["smk_adpg2"];
      $rowOutput["smk_adpg3"] = $val["smk_adpg3"];
      $rowOutput["smk_adpg4"] = $val["smk_adpg4"];
      $rowOutput["jln_kname"] = $dbOracle->getElementById("SPMC.V_MKWJLN", "kws_knama", "jln_jlkod", $info["jln_jlkod"]);
      if ($val["smk_jstnh"] != null) {
        $rowOutput["tnh_tnama"] = $dbOracle->getElementById("SPMC.V_HTANAH", "tnh_tnama", "tnh_thkod", $val["smk_jstnh"]);
      } else {
        $rowOutput["tnh_tnama"] = $this->checkNull($val["smk_jstnh"]);
      }
      if ($val["smk_jsbgn"] != null) {
        $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["smk_jsbgn"]);
      } else {
        $rowOutput["bgn_bnama"] = $this->checkNull($val["smk_jsbgn"]);
      }
      if ($val["smk_stbgn"] != null) {
        $rowOutput["stb_snama"] = $dbOracle->getElementById("SPMC.V_HSTBGN", "stb_snama", "stb_stkod", $val["smk_stbgn"]);
      } else {
        $rowOutput["stb_snama"] = $this->checkNull($val["smk_stbgn"]);
      }
      $rowOutput["smk_lsbgn"] = $val["smk_lsbgn"];
      $rowOutput["smk_lstnh"] = $val["smk_lstnh"];
      $rowOutput["smk_lsans"] = $val["smk_lsans"];
      $rowOutput["smk_lsbgn_tmbh"] = $val["smk_lsbgn_tmbh"];
      $rowOutput["smk_lsans_tmbh"] = $val["smk_lsans_tmbh"];
      $rowOutput["smk_codex"] = $val["smk_codex"];
      $rowOutput["smk_codey"] = $val["smk_codey"];
      $rowOutput["smk_type"] = $val["smk_type"];
      $rowOutput["smk_stspn"] = $val["smk_stspn"];
      $rowOutput["hadapan"] = $val["hadapan"];
      $rowOutput["belakang"] = $val["belakang"];
      $rowOutput["hrt_hnama"] = $info["hrt_hnama"];
      $rowOutput["jln_jnama"] = $info["jln_jnama"];
      $rowOutput["smk_datevisit"] = date("d/m/Y", strtotime($val["smk_datevisit"]));
      $rowOutput["smk_timevisit"] = date("H:i:s", strtotime($val["smk_datevisit"]));
      $rowOutput["workerid"] = $val["workerid"];
      $rowOutput["name"] = $val["name"];
      $rowOutput["calctype"] = $calcType;
      $rowOutput["file"] = $val["file"];
      $rowOutput["doc"] = $val["doc"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function evaluationtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(s.smk_akaun AS TEXT) iLIKE '%" . $searchValue . "%' OR CAST(s.smk_nolot AS TEXT) iLIKE '%" . $searchValue . "%' OR s.smk_adpg1 iLIKE '%" . $searchValue . "%' OR s.smk_adpg2 iLIKE '%" . $searchValue . "%' OR s.workerid iLIKE '%" . $searchValue . "%' OR s.name iLIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitioninfops s ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitioninfops s ";
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM data.v_submitioninfops s ";
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $row = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {

      $dbOracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["no_akaun"]);
      $info = $dbOracle->fetchAssociative();

      $rowOutput["no_siri"] = $val["no_siri"];
      $rowOutput["no_akaun"] = $val["no_akaun"];
      $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
      $rowOutput["pmk_plgid"] = $info["pmk_plgid"];
      $rowOutput["pmk_hkmlk"] = $info["pmk_hkmlk"];
      $rowOutput["peg_pelan"] = $info["peg_pelan"];
      $rowOutput["peg_rjmmk"] = $info["peg_rjmmk"];
      $rowOutput["peg_nilth"] = $info["peg_nilth"];
      $rowOutput["kaw_kadar"] = $info["kaw_kadar"];
      $rowOutput["peg_tksir"] = $info["peg_tksir"];
      $rowOutput["adpg1"] = $info["adpg1"];
      $rowOutput["adpg2"] = $info["adpg2"];
      $rowOutput["adpg3"] = $info["adpg3"];
      $rowOutput["adpg4"] = $info["adpg4"];
      $rowOutput["peg_nolot"] = $info["peg_nolot"];
      $rowOutput["peg_nompt"] = $info["peg_nompt"];
      $rowOutput["peg_lsbgn"] = $info["peg_lsbgn"];
      $rowOutput["peg_lstnh"] = $info["peg_lstnh"];
      $rowOutput["tkhpl"] = $val["tkhpl"];
      $rowOutput["tkhtk"] = $val["tkhtk"];
      $rowOutput["nilth_baru"] = $this->checkNullNumber($val["nilth_baru"]);
      $rowOutput["kadar_baru"] = $this->checkNullNumber($val["kadar_baru"]);
      $rowOutput["cukai_baru"] = $this->checkNullNumber($val["cukai_baru"]);
      $rowOutput["sebab"] = $dbOracle->getElementById("SPMC.V_ACMRSN", "acm_sbktr", "acm_sbkod", $val["sebab"]);
      $rowOutput["mesej"] = $val["mesej"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function submitsitereviewtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $submitId)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(s.smk_akaun AS TEXT) iLIKE '%" . $searchValue . "%' OR CAST(s.smk_nolot AS TEXT) iLIKE '%" . $searchValue . "%' OR s.smk_adpg1 iLIKE '%" . $searchValue . "%' OR s.smk_adpg2 iLIKE '%" . $searchValue . "%' OR s.workerid iLIKE '%" . $searchValue . "%' OR s.name iLIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_semak_raw s ";
    $sql .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_semak_raw s ";
    $sql .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    if ($searchValue != "") {
      $sql .= "WHERE s.smk_submit_id = " . $submitId . " AND " . $searchQuery;
    } else {
      $sql .= "WHERE s.smk_submit_id = " . $submitId;
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT s.*, c.siri_no, f.file, d.doc FROM data.v_semak_raw s ";
    $query .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    $query .= "LEFT JOIN (select count(*) as file, no_akaun from data.files group by no_akaun) f ON s.smk_akaun = f.no_akaun ";
    $query .= "LEFT JOIN (select count(*) as doc, no_akaun from data.fdocs group by no_akaun) d ON s.smk_akaun = d.no_akaun ";
    if ($searchValue != "") {
      $query .= "WHERE s.smk_submit_id = " . $submitId . " AND " . $searchQuery;
    } else {
      $query .= "WHERE s.smk_submit_id = " . $submitId;
    }

    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $row = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {

      $dbOracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["smk_akaun"]);
      $info = $dbOracle->fetchAssociative();

      if ($this->checkEmptyLand($info["peg_htkod"])) {
        if ($this->checkNull($val["siri_no"]) == "-") {
          $calcType = "createEmptyLandCalc";
        } else {
          $calcType = "editEmptyLandCalc";
        }
      } else {
        if ($this->checkNull($val["siri_no"]) == "-") {
          $calcType = "createBuildingCalc";
        } else {
          $calcType = "editBuildingCalc";
        }
      }

      $rowOutput["id"] = Encryption::encryptId($val["id"]);
      $rowOutput["sid"] = $val["id"];
      $rowOutput["akaun"] = Encryption::encryptId($val["smk_akaun"]);
      $rowOutput["sirino"] = $this->checkSiriNo($val["siri_no"]);
      $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
      $rowOutput["pmk_plgid"] = $info["pmk_plgid"];
      $rowOutput["pmk_hkmlk"] = $info["pmk_hkmlk"];
      $rowOutput["peg_pelan"] = $info["peg_pelan"];
      $rowOutput["peg_rjmmk"] = $info["peg_rjmmk"];
      $rowOutput["peg_nilth"] = $info["peg_nilth"];
      $rowOutput["kaw_kadar"] = $info["kaw_kadar"];
      $rowOutput["peg_tksir"] = $info["peg_tksir"];
      $rowOutput["smk_akaun"] = $val["smk_akaun"];
      $rowOutput["smk_nolot"] = $val["smk_nolot"];
      $rowOutput["smk_nompt"] = $val["smk_nompt"];
      $rowOutput["smk_adpg1"] = $val["smk_adpg1"];
      $rowOutput["smk_adpg2"] = $val["smk_adpg2"];
      $rowOutput["smk_adpg3"] = $val["smk_adpg3"];
      $rowOutput["smk_adpg4"] = $val["smk_adpg4"];
      $rowOutput["jln_kname"] = $dbOracle->getElementById("SPMC.V_MKWJLN", "kws_knama", "jln_jlkod", $info["jln_jlkod"]);
      if ($val["smk_jstnh"] != null) {
        $rowOutput["tnh_tnama"] = $dbOracle->getElementById("SPMC.V_HTANAH", "tnh_tnama", "tnh_thkod", $val["smk_jstnh"]);
      } else {
        $rowOutput["tnh_tnama"] = $this->checkNull($val["smk_jstnh"]);
      }
      if ($val["smk_jsbgn"] != null) {
        $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["smk_jsbgn"]);
      } else {
        $rowOutput["bgn_bnama"] = $this->checkNull($val["smk_jsbgn"]);
      }
      if ($val["smk_stbgn"] != null) {
        $rowOutput["stb_snama"] = $dbOracle->getElementById("SPMC.V_HSTBGN", "stb_snama", "stb_stkod", $val["smk_stbgn"]);
      } else {
        $rowOutput["stb_snama"] = $this->checkNull($val["smk_stbgn"]);
      }
      $rowOutput["smk_lsbgn"] = $val["smk_lsbgn"];
      $rowOutput["smk_lstnh"] = $val["smk_lstnh"];
      $rowOutput["smk_lsans"] = $val["smk_lsans"];
      $rowOutput["smk_lsbgn_tmbh"] = $val["smk_lsbgn_tmbh"];
      $rowOutput["smk_lsans_tmbh"] = $val["smk_lsans_tmbh"];
      $rowOutput["smk_codex"] = $val["smk_codex"];
      $rowOutput["smk_codey"] = $val["smk_codey"];
      $rowOutput["smk_type"] = $val["smk_type"];
      $rowOutput["smk_stspn"] = $val["smk_stspn"];
      $rowOutput["hadapan"] = $val["hadapan"];
      $rowOutput["belakang"] = $val["belakang"];
      $rowOutput["hrt_hnama"] = $info["hrt_hnama"];
      $rowOutput["jln_jnama"] = $info["jln_jnama"];
      $rowOutput["smk_datevisit"] = date("d/m/Y", strtotime($val["smk_datevisit"]));
      $rowOutput["smk_timevisit"] = date("H:i:s", strtotime($val["smk_datevisit"]));
      $rowOutput["workerid"] = $val["workerid"];
      $rowOutput["name"] = $val["name"];
      $rowOutput["calctype"] = $calcType;
      $rowOutput["file"] = $val["file"];
      $rowOutput["doc"] = $val["doc"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    # Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function pendingsitereviewtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "", $street = "")
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(s.smk_akaun AS TEXT) iLIKE '%" . $searchValue . "%' OR CAST(s.smk_nolot AS TEXT) iLIKE '%" . $searchValue . "%' OR s.smk_adpg1 iLIKE '%" . $searchValue . "%' OR s.smk_adpg2 iLIKE '%" . $searchValue . "%' OR s.workerid iLIKE '%" . $searchValue . "%' OR s.name iLIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_semak_raw s ";
    $sql .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_semak_raw s ";
    $sql .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $sql .= "WHERE s.smk_stspn = '3' AND s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street . " AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $sql .= "WHERE s.smk_stspn = '3' AND s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street;
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $sql .= "WHERE s.smk_stspn = '3' AND " . $searchQuery;
    } else {
      $sql .= "WHERE s.smk_stspn = '3'";
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT s.*, c.siri_no, f.file, d.doc FROM data.v_semak_raw s ";
    $query .= "LEFT JOIN data.calculator c ON s.smk_akaun = c.account_no ";
    $query .= "LEFT JOIN (select count(*) as file, no_akaun from data.files group by no_akaun) f ON s.smk_akaun = f.no_akaun ";
    $query .= "LEFT JOIN (select count(*) as doc, no_akaun from data.fdocs group by no_akaun) d ON s.smk_akaun = d.no_akaun ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $query .= "WHERE s.smk_stspn = '3' AND s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street . " AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $query .= "WHERE s.smk_stspn = '3' AND s.smk_kodkws = " . $area . " AND s.smk_jalan = " . $street;
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $query .= "WHERE s.smk_stspn = '3' AND " . $searchQuery;
    } else {
      $query .= "WHERE s.smk_stspn = '3'";
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
    $database->prepare($query);
    $database->execute();

    $row = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {

      $dbOracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["smk_akaun"]);
      $info = $dbOracle->fetchAssociative();

      if ($this->checkEmptyLand($info["peg_htkod"])) {
        if ($this->checkNull($val["siri_no"]) == "-") {
          $calcType = "createEmptyLandCalc";
        } else {
          $calcType = "editEmptyLandCalc";
        }
      } else {
        if ($this->checkNull($val["siri_no"]) == "-") {
          $calcType = "createBuildingCalc";
        } else {
          $calcType = "editBuildingCalc";
        }
      }

      $rowOutput["id"] = Encryption::encryptId($val["id"]);
      $rowOutput["sid"] = $val["id"];
      $rowOutput["akaun"] = Encryption::encryptId($val["smk_akaun"]);
      $rowOutput["sirino"] = $this->checkSiriNo($val["siri_no"]);
      $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
      $rowOutput["pmk_plgid"] = $info["pmk_plgid"];
      $rowOutput["pmk_hkmlk"] = $info["pmk_hkmlk"];
      $rowOutput["peg_pelan"] = $info["peg_pelan"];
      $rowOutput["peg_rjmmk"] = $info["peg_rjmmk"];
      $rowOutput["peg_nilth"] = $info["peg_nilth"];
      $rowOutput["kaw_kadar"] = $info["kaw_kadar"];
      $rowOutput["peg_tksir"] = $info["peg_tksir"];
      $rowOutput["smk_akaun"] = $val["smk_akaun"];
      $rowOutput["smk_nolot"] = $val["smk_nolot"];
      $rowOutput["smk_nompt"] = $val["smk_nompt"];
      $rowOutput["smk_adpg1"] = $val["smk_adpg1"];
      $rowOutput["smk_adpg2"] = $val["smk_adpg2"];
      $rowOutput["smk_adpg3"] = $val["smk_adpg3"];
      $rowOutput["smk_adpg4"] = $val["smk_adpg4"];
      $rowOutput["jln_kname"] = $dbOracle->getElementById("SPMC.V_MKWJLN", "kws_knama", "jln_jlkod", $info["jln_jlkod"]);
      if ($val["smk_jstnh"] != null) {
        $rowOutput["tnh_tnama"] = $dbOracle->getElementById("SPMC.V_HTANAH", "tnh_tnama", "tnh_thkod", $val["smk_jstnh"]);
      } else {
        $rowOutput["tnh_tnama"] = $this->checkNull($val["smk_jstnh"]);
      }
      if ($val["smk_jsbgn"] != null) {
        $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["smk_jsbgn"]);
      } else {
        $rowOutput["bgn_bnama"] = $this->checkNull($val["smk_jsbgn"]);
      }
      if ($val["smk_stbgn"] != null) {
        $rowOutput["stb_snama"] = $dbOracle->getElementById("SPMC.V_HSTBGN", "stb_snama", "stb_stkod", $val["smk_stbgn"]);
      } else {
        $rowOutput["stb_snama"] = $this->checkNull($val["smk_stbgn"]);
      }
      $rowOutput["smk_lsbgn"] = $val["smk_lsbgn"];
      $rowOutput["smk_lstnh"] = $val["smk_lstnh"];
      $rowOutput["smk_lsans"] = $val["smk_lsans"];
      $rowOutput["smk_lsbgn_tmbh"] = $val["smk_lsbgn_tmbh"];
      $rowOutput["smk_lsans_tmbh"] = $val["smk_lsans_tmbh"];
      $rowOutput["smk_codex"] = $val["smk_codex"];
      $rowOutput["smk_codey"] = $val["smk_codey"];
      $rowOutput["smk_type"] = $val["smk_type"];
      $rowOutput["smk_stspn"] = $val["smk_stspn"];
      $rowOutput["smk_nota"] = $val["smk_nota"];
      $rowOutput["hadapan"] = $val["hadapan"];
      $rowOutput["belakang"] = $val["belakang"];
      $rowOutput["hrt_hnama"] = $info["hrt_hnama"];
      $rowOutput["jln_jnama"] = $info["jln_jnama"];
      $rowOutput["smk_datevisit"] = date("d/m/Y", strtotime($val["smk_datevisit"]));
      $rowOutput["smk_timevisit"] = date("H:i:s", strtotime($val["smk_datevisit"]));
      $rowOutput["workerid"] = $val["workerid"];
      $rowOutput["name"] = $val["name"];
      $rowOutput["calctype"] = $calcType;
      $rowOutput["file"] = $val["file"];
      $rowOutput["doc"] = $val["doc"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecordwithFilter,
      "data" => $output,
    ];

    return $response;
  }

  public function getAllImgs($fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT * FROM data.files ";
    $query .= "WHERE no_akaun = :no_akaun ";
    $query .= "ORDER BY files.date DESC ";

    $database->prepare($query);
    $database->bindValue(":no_akaun", $fileId);
    $database->execute();
    $files = $database->fetchAllAssociative();

    return $files;
  }

  public function getBenchMarkInfo($id)
  {
    $database = Database::openConnection();
    $query = "SELECT f.*, d.document as doc_name FROM data.bdocs f ";
    $query .= "LEFT JOIN data.doctype d ON f.file_type = d.id ";
    $query .= "WHERE f.benchid = :id";

    $database->prepare($query);
    $database->bindValue(":id", $id);
    $database->execute();
    $rows = $database->fetchAllAssociative();

    return $rows;
  }

  public function getAllDocs($fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT f.*, d.document as doc_name FROM data.fdocs f ";
    $query .= "LEFT JOIN data.doctype d ON f.file_type = d.id ";
    $query .= "WHERE f.no_akaun = :no_akaun";

    $database->prepare($query);
    $database->bindValue(":no_akaun", $fileId);
    $database->execute();
    $files = $database->fetchAllAssociative();

    return $files;
  }

  public function insertrentbenchmark($userId, $ratetype, $akaun, $pemilik, $jlkod, $kwkod, $htkod, $items_rent)
  {
    $ratetype = empty($ratetype) ? 0 : $ratetype;
    $kwkod = empty($kwkod) ? 0 : $kwkod;
    $htkod = empty($htkod) ? 0 : $htkod;
    $jlkod = empty($jlkod) ? 0 : $jlkod;
    $akaun = empty($akaun) ? null : $akaun;
    $pemilik = empty($pemilik) ? null : $pemilik;

    $database = Database::openConnection();

    $first_item = array_shift($items_rent);

    $first_item_rentnote = empty($first_item["rentnote"]) ? null : $first_item["rentnote"];

    $query = "INSERT INTO data.benchmark(parent, akaun, jenis, jlkod, kwkod, nmbil, htkod, bgkod, bgside, nilai, nota) ";
    $query .= "values (0," . $akaun  . "," . $ratetype . "," . $jlkod . "," . $kwkod . ",'" . $pemilik . "'," . $htkod . "," . $first_item["bgtype"] . ",'" . $first_item["bgside"] . "'," . $first_item["rentprice"] . ",'" . $first_item_rentnote . "')";
    $database->prepare($query);
    $database->execute();
    $id = $database->lastInsertedId();

    foreach ($items_rent as $val) {
      $item_rentnote = empty($val["rentnote"]) ? null : $val["rentnote"];
      $query = "INSERT INTO data.benchmark(parent, akaun, jenis, jlkod, kwkod, nmbil, htkod, bgkod, bgside, nilai, nota) ";
      $query .= "values (" . $id . "," . $akaun  . "," . $ratetype . "," . $jlkod . "," . $kwkod . ",'" . $pemilik . "'," . $htkod . "," . $val["bgtype"] . ",'" . $val["bgside"] . "'," . $val["rentprice"] . ",'" . $item_rentnote . "')";
      $database->prepare($query);
      $database->execute();
    }

    return ["success" => true];
  }

  public function insertcostbenchmark($userId, $ratetype, $akaun, $pemilik, $jlkod, $kwkod, $htkod, $items_cost)
  {
    $ratetype = empty($ratetype) ? 0 : $ratetype;
    $kwkod = empty($kwkod) ? 0 : $kwkod;
    $htkod = empty($htkod) ? 0 : $htkod;
    $jlkod = empty($jlkod) ? 0 : $jlkod;
    $akaun = empty($akaun) ? null : $akaun;
    $pemilik = empty($pemilik) ? null : $pemilik;

    $database = Database::openConnection();

    $first_item = array_shift($items_cost);
    $first_item_costnote = empty($first_item["costnote"]) ? null : $first_item["costnote"];

    $query = "INSERT INTO data.benchmark(parent, akaun, jenis, jlkod, kwkod, nmbil, htkod, bgkod, bgside, nilai, nota) ";
    $query .= "values (0," . $akaun  . "," . $ratetype . "," . $jlkod . "," . $kwkod . ",'" . $pemilik . "'," . $htkod . "," . $first_item["bgtype"] . ",'" . $first_item["bgside"] . "'," . $first_item["costprice"] . ",'" . $first_item_costnote . "')";
    $database->prepare($query);
    $database->execute();
    $id = $database->lastInsertedId();

    foreach ($items_cost as $val) {
      $item_costnote = empty($val["costnote"]) ? null : $val["costnote"];
      $query = "INSERT INTO data.benchmark(parent, akaun, jenis, jlkod, kwkod, nmbil, htkod, bgkod, bgside, nilai, nota) ";
      $query .= "values (" . $id . "," . $akaun  . "," . $ratetype . "," . $jlkod . "," . $kwkod . ",'" . $pemilik . "'," . $htkod . "," . $val["bgtype"] . ",'" . $val["bgside"] . "'," . $val["costprice"] . ",'" . $item_costnote . "')";
      $database->prepare($query);
      $database->execute();
    }

    return ["success" => true];
  }

  public function uploadbenchmarkdocs($userId, $id, $file_type, $filename, $description, $fileData)
  {
    // upload
    $file = Uploader::uploadFile($fileData);

    if (!$file) {
      $this->errors = Uploader::errors();
      return false;
    }

    $database = Database::openConnection();

    $query = 'INSERT INTO data.bdocs (workerid, benchid, file_type, filename, hashed_filename, description, extension) VALUES (:workerid, :benchid, :file_type, :filename, :hashed_filename, :description, :extension)';

    $database->prepare($query);
    $database->bindValue(":workerid", $userId);
    $database->bindValue(":benchid", $id);
    $database->bindValue(":file_type", $file_type);
    $database->bindValue(":filename", $filename);
    $database->bindValue(":hashed_filename", $file["hashed_filename"]);
    $database->bindValue(":extension", $file["extension"]);
    $database->bindValue(":description", $description);
    $database->execute();

    // if insert failed, then delete the file
    if ($database->countRows() !== 1) {
      Uploader::deleteFile(IMAGES . "documents/" . $file["hashed_filename"]);
      throw new Exception("Couldn't upload file");
    }

    $id = $database->lastInsertedId();
    $file = $this->getDocsById("data.bdocs", $id);
    return $file;
  }

  public function uploadimages($userId, $no_akaun, $filename, $description, $fileData)
  {
    // upload
    $file = ImageResizer::resizeImage($fileData);

    $database = Database::openConnection();

    $query = "INSERT INTO data.files (no_akaun, workerid, filename, hashed_filename, description) VALUES (:no_akaun, :workerid, :filename, :hashed_filename, :description)";

    $database->prepare($query);
    $database->bindValue(":no_akaun", $no_akaun);
    $database->bindValue(":workerid", $userId);
    $database->bindValue(":filename", $filename);
    $database->bindValue(":hashed_filename", $file["hashed_filename"]);
    $database->bindValue(":description", $description);
    $database->execute();

    // if insert failed, then delete the file
    if ($database->countRows() !== 1) {
      Uploader::deleteFile(IMAGES . "big-lightgallry/" . $file["hashed_filename"]);
      throw new Exception("Couldn't upload file");
    }

    $fileId = $database->lastInsertedId();
    $file = $this->getImagesById($fileId);
    return $file;
  }

  public function uploaddocuments($userId, $no_akaun, $file_type, $filename, $description, $fileData)
  {
    // upload
    $file = Uploader::uploadFile($fileData);

    if (!$file) {
      $this->errors = Uploader::errors();
      return false;
    }

    $database = Database::openConnection();

    $query = "INSERT INTO data.fdocs (workerid, no_akaun, file_type, filename, hashed_filename, description, extension) VALUES (:workerid, :no_akaun, :file_type, :filename, :hashed_filename, :description, :extension)";

    $database->prepare($query);
    $database->bindValue(":workerid", $userId);
    $database->bindValue(":no_akaun", $no_akaun);
    $database->bindValue(":file_type", $file_type);
    $database->bindValue(":filename", $filename);
    $database->bindValue(":hashed_filename", $file["hashed_filename"]);
    $database->bindValue(":extension", $file["extension"]);
    $database->bindValue(":description", $description);
    $database->execute();

    // if insert failed, then delete the file
    if ($database->countRows() !== 1) {
      Uploader::deleteFile(IMAGES . "documents/" . $file["hashed_filename"]);
      throw new Exception("Couldn't upload file");
    }

    $fileId = $database->lastInsertedId();
    $file = $this->getDocsById("data.fdocs", $fileId);
    return $file;
  }

  public function buildingSubmit($userId, $workerId, $siriNo, $acctNo, $comparison, $breadth_land, $price_land, $section_one, $section_two, $discount, $rental, $even, $yearly, $rate, $tax)
  {
    $comparison = empty($comparison) ? null : $comparison;
    $breadth_land = empty($breadth_land) ? 0 : $breadth_land;
    $price_land = empty($price_land) ? 0 : $price_land;
    $discount = empty($discount) ? 0 : $discount;
    $rental = empty($rental) ? 0 : $rental;
    $even = empty($even) ? 0 : $even;
    $yearly = empty($yearly) ? 0 : $yearly;
    $rate = empty($rate) ? 0 : $rate;
    $tax = empty($tax) ? 0 : $tax;
    $total = $breadth_land * $price_land;
    // $corner = $corner == false ? 0 : 1;
    $calcType = 2;
    $capital = 0;

    $database = Database::openConnection();

    // if (($breadth_land != "" || $breadth_land != "0") || ($price_land != "" || $price_land != "0" || $price_land != "0.0")) {
    $land = "INSERT INTO data.items_land(siri_no, breadth, price, total) values ('" . $siriNo . "', " . $breadth_land . ", " . $price_land . ", " . $total . ")";
    $database->prepare($land);
    $database->execute();
    $land_id = $database->lastInsertedId();
    // }

    $itemsOne_id = [];
    $itemsOne_sum = [];
    foreach ($section_one as $val) {
      if ($val["main_title"] != "") {
        $sectionOne = "INSERT INTO data.section(section_type, siri_no, title) values (1,'" . $siriNo . "','" . $val["main_title"] . "')";
        $database->prepare($sectionOne);
        $database->execute();
        $sectionsOne_id = $database->lastInsertedId();

        foreach ($val['item'] as $value) {
          $breadth_one = empty($value["breadth_one"]) ? 0 : $value["breadth_one"];
          $price_one = empty($value["price_one"]) ? 0 : $value["price_one"];
          $total_one = empty($value["total_one"]) ? 0 : $value["total_one"];

          $sql = "INSERT INTO data.items_main(section_id, siri_no, title, breadth, breadthtype, price, pricetype, total) values ";
          $sql .= "(" . $sectionsOne_id . ",'" . $siriNo . "','" . $value["title_one"] . "'," . $breadth_one . ",'" . $value["breadthtype_one"] . "'," . $price_one . ",'" . $value["pricetype_one"] . "'," . $total_one . ")";
          $database->prepare($sql);
          $database->execute();
          $itemsOne_id[] = $database->lastInsertedId();
          $itemsOne_sum[] = $value["total_one"];
        }
      }
    }

    $itemsTwo_id = [];
    $itemsTwo_sum = [];
    foreach ($section_two as $val) {
      if ($val["external_title"] != "") {
        $sectionTwo = "INSERT INTO data.section(section_type, siri_no, title) values (2,'" . $siriNo . "','" . $val["external_title"] . "')";
        $database->prepare($sectionTwo);
        $database->execute();
        $sectionsTwo_id = $database->lastInsertedId();

        foreach ($val['item'] as $value) {
          $breadth_two = empty($value["breadth_two"]) ? 0 : $value["breadth_two"];
          $price_two = empty($value["price_two"]) ? 0 : $value["price_two"];
          $total_two = empty($value["total_two"]) ? 0 : $value["total_two"];

          $query = "INSERT INTO data.items_out(section_id, siri_no, title, breadth, breadthtype, price, pricetype, total) values ";
          $query .= "(" . $sectionsTwo_id . ",'" . $siriNo . "','" . $value["title_two"] . "'," . $breadth_two . ",'" . $value["breadthtype_two"] . "'," . $price_two . ",'" . $value["pricetype_two"] . "'," . $total_two . ")";
          $database->prepare($query);
          $database->execute();
          $itemsTwo_id[] = $database->lastInsertedId();
          $itemsTwo_sum[] = $value["total_two"];
        }
      }
    }

    if ($comparison != null) {
      $comparison = $this->escapeJsonString(str_replace(["[", "]"], ["{", "}"], json_encode($comparison)));
    } else {
      $comparison = $comparison;
    }
    $idItemsOne = $this->escapeJsonString(str_replace(["[", "]"], ["{", "}"], json_encode($itemsOne_id)));
    $idItemsTwo = $this->escapeJsonString(str_replace(["[", "]"], ["{", "}"], json_encode($itemsTwo_id)));

    // $sumItemOne = array_sum($itemsOne_sum);
    // $sumItemTwo = array_sum($itemsTwo_sum);

    $query = "INSERT INTO data.calculator(calc_type, siri_no, account_no, comparison, land, bmain, bout, capital, discount, rental, yearly_price, even, rate, assessment_tax) ";
    $query .= "VALUES(" . $calcType . ", '" . $siriNo . "', " . $acctNo . ", '" . $comparison . "', " . $land_id . ", '" . $idItemsOne . "', '" . $idItemsTwo . "', ";
    $query .= "'" . $capital . "', " . $discount . ", '" . $rental . "', " . $yearly . ", " . $even . ", " . $rate . ", " . $tax . ")";
    $database->prepare($query);
    $result = $database->execute();

    // if ($result) {
    //   $activity = "Pengiraan Nilaian : No Siri - " . $siriNo;
    //   $database->logActivity($userId, $activity);
    // }

    return true;
  }

  public function buildingEdit($userId, $workerId, $siriNo, $acctNo, $comparison, $breadth_land, $price_land, $section_one, $section_two, $discount, $rental, $even, $yearly, $rate, $tax)
  {
    $comparison = empty($comparison) ? null : $comparison;
    $breadth_land = empty($breadth_land) ? 0 : $breadth_land;
    $price_land = empty($price_land) ? 0 : $price_land;
    $discount = empty($discount) ? 0 : $discount;
    $rental = empty($rental) ? 0 : $rental;
    $even = empty($even) ? 0 : $even;
    $yearly = empty($yearly) ? 0 : $yearly;
    $rate = empty($rate) ? 0 : $rate;
    $tax = empty($tax) ? 0 : $tax;
    $total = $breadth_land * $price_land;
    // $corner = $corner == false ? 0 : 1;
    $calcType = 2;
    $capital = 0;

    $database = Database::openConnection();

    $land = "UPDATE data.items_land SET breadth = " . $breadth_land . ", price = " . $price_land . ", total = " . $total . " WHERE siri_no = '" . $siriNo . "'";
    $database->prepare($land);
    $database->execute();

    foreach ($section_one as $val) {
      if ($val["main_title"] != "") {
        $section_id = $val["id"];

        $sectionOne = "UPDATE data.section SET title = '" . $val["main_title"] . "' WHERE siri_no = '" . $siriNo . "' AND id = " . $section_id;
        $database->prepare($sectionOne);
        $database->execute();

        foreach ($val['item'] as $value) {
          $breadth_one = empty($value["breadth_one"]) ? 0 : $value["breadth_one"];
          $price_one = empty($value["price_one"]) ? 0 : $value["price_one"];
          $total_one = empty($value["total_one"]) ? 0 : $value["total_one"];
          $item_id = $value["id"];

          $sql = "UPDATE data.items_main SET title='" . $value["title_one"] . "', breadth=" . $breadth_one . ", breadthtype='" . $value["breadthtype_one"] . "', price=" . $price_one . ", pricetype='" . $value["pricetype_one"] . "', total=" . $total_one;
          $sql .= " WHERE siri_no = '" . $siriNo . "' AND id = " . $item_id;
          $database->prepare($sql);
          $database->execute();
        }
      }
    }

    foreach ($section_two as $key => $val) {
      if ($val["external_title"] != "") {
        $section_id = $val["id"];

        $sectionTwo = "UPDATE data.section SET title = '" . $val["external_title"] . "' WHERE siri_no = '" . $siriNo . "' AND id = " . $key;
        $database->prepare($sectionTwo);
        $database->execute();

        foreach ($val['item'] as $value) {
          $breadth_two = empty($value["breadth_two"]) ? 0 : $value["breadth_two"];
          $price_two = empty($value["price_two"]) ? 0 : $value["price_two"];
          $total_two = empty($value["total_two"]) ? 0 : $value["total_two"];
          $item_id = $value["id"];

          $query = "UPDATE data.items_out SET title = '" . $value["title_two"] . "', breadth = " . $breadth_two . ", breadthtype = '" . $value["breadthtype_two"] . "', price = " . $price_two . ", pricetype = '" . $value["pricetype_two"] . "', total = " . $total_two;
          $query .= " WHERE siri_no = '" . $siriNo . "' AND id = " . $item_id;
          $database->prepare($query);
          $database->execute();
        }
      }
    }

    if ($comparison != null) {
      $comparison = $this->escapeJsonString(str_replace(["[", "]"], ["{", "}"], json_encode($comparison)));
    } else {
      $comparison = "{}";
    }

    $query = "UPDATE data.calculator SET comparison = '" . $comparison . "', capital = '" . $capital . "', discount = " . $discount . ", rental = '" . $rental . "', yearly_price = " . $yearly . ", even = " . $even . ", rate = " . $rate . ", assessment_tax = " . $tax;
    $query .= " WHERE siri_no = '" . $siriNo . "'";
    $database->prepare($query);
    $result = $database->execute();

    // if ($result) {
    //   $activity = "Pengiraan Nilaian : No Siri - " . $siriNo;
    //   $database->logActivity($userId, $activity);
    // }

    return true;
  }

  public function getChildsBenchMark($id)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $query = "SELECT id, bgside, nilai, nota FROM data.benchmark ";
    $query .= "WHERE parent = :id ";

    $database->prepare($query);
    $database->bindValue(":id", (int) $id);
    $database->execute();

    $childs = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($childs as $val) {
      $rowOutput["id"] = Encryption::encryptId($val["id"]);
      $rowOutput["nota"] = $val["nota"];
      $rowOutput["nilai"] = $val["nilai"];
      $rowOutput["hrt_hnama"] = $dbOracle->getElementById("SPMC.V_HHARTA", "hrt_hnama", "hrt_htkod", $val["htkod"]);
      $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["bgkod"]);
      if ($val["bgside"] == 1) {
        $rowOutput["bgside"] = "MFA";
      } elseif ($val["bgside"] == 2) {
        $rowOutput["bgside"] = "AFA";
      }
      array_push($output, $rowOutput);
    }
    return $output;
  }

  public function reviewSubmition($userId, $id)
  {
    $database = Database::openConnection();

    $id = $this->escapeJsonString(str_replace(["[", "]"], ["{", "}"], json_encode($id)));

    $query = "INSERT INTO data.vendorsubmition(submit_id) ";
    $query .= "VALUES(:id)";

    $database->prepare($query);
    $database->bindValue(":id", $id);
    $database->execute();
  }

  public function updatebreadth($userId, $id, $akaun, $lsbgn, $lsans, $nota)
  {
    $database = Database::openConnection();
    $lsbgn = empty($lsbgn) ? null : $lsbgn;
    $lsans = empty($lsans) ? null : $lsans;

    $database->getReviewByNoAcct($akaun);
    $info = $database->fetchAssociative();

    if ($info != null) {
      $query = "UPDATE data.pindaan_raw SET luas_bangunan=:lsbgn , luas_ansolari=:lsans, catatan_hadapan=:nota ";
      $query .= "WHERE id = :id";
      $database->prepare($query);
      $database->bindValue(":id", $info['id']);
      $database->bindValue(":lsbgn", $lsbgn);
      $database->bindValue(":lsans", $lsans);
      $database->bindValue(":nota", $nota);
      $result = $database->execute();
    } else {
      $query = "INSERT INTO data.pindaan_raw(id_smk, no_akaun, type, luas_bangunan, luas_ansolari, catatan_hadapan) ";
      $query .= "VALUES(:id_smk, :no_akaun, :type, :lsbgn, :lsans, :nota)";
      $database->prepare($query);
      $database->bindValue(":id_smk", $id);
      $database->bindValue(":no_akaun", $akaun);
      $database->bindValue(":type", "1");
      $database->bindValue(":lsbgn", $lsbgn);
      $database->bindValue(":lsans", $lsans);
      $database->bindValue(":nota", $nota);
      $result = $database->execute();
    }

    if ($result) {
      $activity = "Kemaskini keluasan: No akaun - " . $akaun;
      $database->logActivity($userId, $activity);
    }

    return true;
  }

  public function getImagesById($fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT f.*, u.name ";
    $query .= "FROM data.files f ";
    $query .= "LEFT JOIN public.users u ON f.workerid = u.id ";
    $query .= "WHERE f.id = :id LIMIT 1 ";

    $database->prepare($query);
    $database->bindValue(":id", (int) $fileId);
    $database->execute();

    $file = $database->fetchAllAssociative();
    return $file;
  }

  public function getDocsById($table, $fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT a.*, u.name ";
    $query .= "FROM " . $table . " a ";
    $query .= "LEFT JOIN public.users u ON a.workerid = u.id ";
    $query .= "WHERE a.id = :id LIMIT 1 ";

    $database->prepare($query);
    $database->bindValue(":id", (int) $fileId);
    $database->execute();

    $file = $database->fetchAllAssociative();
    return $file;
  }

  public function deletesitereview($userId, $fileId)
  {

    $database = Database::openConnection();

    // $database->getById("data.smktpk", $fileId);
    // $file = $database->fetchAssociative();

    $database->deleteByIdCustom("data.pindaan_raw", "id_smk", $fileId);
    $database->deleteById("data.smktpk", $fileId);

    if ($database->countRows() !== 1) {
      throw new Exception("Couldn't delete sitereview");
    }
  }

  public function deleterentbenchmark($userId, $rowId)
  {

    $database = Database::openConnection();
    $database->deleteById("data.benchmark", $rowId);

    if ($database->countRows() !== 1) {
      throw new Exception("Couldn't delete benchmark");
    }

    $activity = "Padam Aras Nilaian : " . $rowId;
    $database->logActivity($userId, $activity);
  }

  public function deletecostbenchmark($userId, $rowId)
  {

    $database = Database::openConnection();
    $database->deleteById("data.benchmark", $rowId);

    if ($database->countRows() !== 1) {
      throw new Exception("Couldn't delete benchmark");
    }

    $activity = "Padam Aras Nilaian : " . $rowId;
    $database->logActivity($userId, $activity);
  }

  public function deletebenchdocument($userId, $docId)
  {
    $database = Database::openConnection();

    $database->getById("data.bdocs", $docId);
    $file = $database->fetchAssociative();

    // start a transaction to guarantee the file will be deleted from both; database and filesystem
    $database->beginTransaction();
    $database->deleteById("data.bdocs", $docId);

    if ($database->countRows() !== 1) {
      $database->rollBack();
      throw new Exception("Couldn't delete file");
    }

    $basename = $file["hashed_filename"] . "." . $file["extension"];
    Uploader::deleteFile(IMAGES . "documents/" . $basename);

    $database->commit();

    // $log = $this->logActivity($userId, "delete image");
  }

  public function deleteimage($userId, $imageId)
  {
    $database = Database::openConnection();

    $database->getById("data.files", $imageId);
    $file = $database->fetchAssociative();

    // start a transaction to guarantee the file will be deleted from both; database and filesystem
    $database->beginTransaction();
    $database->deleteById("data.files", $imageId);

    if ($database->countRows() !== 1) {
      $database->rollBack();
      throw new Exception("Couldn't delete file");
    }

    $basename = $file["hashed_filename"];
    Uploader::deleteFile(IMAGES . "big-lightgallry/" . $basename);
    Uploader::deleteFile(IMAGES . "thumb-lightgallry/" . $basename);

    $database->commit();

    // $log = $this->logActivity($userId, "delete image");
  }

  public function deletedocument($userId, $docId)
  {
    $database = Database::openConnection();

    $database->getById("data.fdocs", $docId);
    $file = $database->fetchAssociative();

    // start a transaction to guarantee the file will be deleted from both; database and filesystem
    $database->beginTransaction();
    $database->deleteById("data.fdocs", $docId);

    if ($database->countRows() !== 1) {
      $database->rollBack();
      throw new Exception("Couldn't delete file");
    }

    $basename = $file["hashed_filename"] . "." . $file["extension"];
    Uploader::deleteFile(IMAGES . "documents/" . $basename);

    $database->commit();

    // $log = $this->logActivity($userId, "delete image");
  }

  public function checkEmptyLand($id)
  {
    $dbOracle = new Oracle();

    $query = "SELECT hrt_hnama FROM SPMC.V_HHARTA WHERE hrt_htkod = :id";

    $dbOracle->prepare($query);
    $dbOracle->bindValue(":id", $id);
    $dbOracle->execute();
    $info = $dbOracle->fetchAssociative();
    if (strpos($info['hrt_hnama'], 'KOSONG')) {
      return true;
    } else {
      return false;
    }
  }
}
