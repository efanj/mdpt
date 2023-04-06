<?php

class Amendment extends Model
{
  public function escapeJsonString($value)
  {
    # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = ["\\", "'", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c"];
    $replacements = ["\\\\", "\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b"];
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }

  public function checkNull($data)
  {
    if ($data == null) {
      return "-";
    } else {
      return $data;
    }
  }

  public function macthingtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery =
        "CAST(peg_akaun AS TEXT) = '" .
        $searchValue .
        "%' OR pmk_nmbil LIKE '%" .
        $searchValue .
        "%' OR adpg1 LIKE '%" .
        $searchValue .
        "%' OR adpg2 LIKE '%" .
        $searchValue .
        "%' OR adpg3 LIKE '%" .
        $searchValue .
        "%' OR adpg4 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt1 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt2 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt3 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt4 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt5 LIKE '%" .
        $searchValue .
        "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.hvnduk h";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.hvnduk h ";
    if ($searchValue != "") {
      $sql .= " WHERE " . $searchQuery . " AND peg_codex is null AND peg_codey is null AND peg_statf != 'H'";
    } else {
      $sql .= " WHERE peg_codex is null AND peg_codey is null AND peg_statf != 'H'";
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM data.hvnduk h ";
    if ($searchValue != "") {
      $query .= " WHERE " . $searchQuery . " AND peg_codex is null AND peg_codey is null AND peg_statf != 'H'";
    } else {
      $query .= " WHERE peg_codex is null AND peg_codey is null AND peg_statf != 'H'";
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
      $rowOutput["id"] = Encryption::encryptId($val["peg_akaun"]);
      $rowOutput["peg_akaun"] = $val["peg_akaun"];
      $rowOutput["peg_nompt"] = $val["peg_nompt"];
      $rowOutput["pmk_nmbil"] = $val["pmk_nmbil"];
      $rowOutput["jln_jnama"] = $val["jln_jnama"];
      $rowOutput["jln_knama"] = $val["jln_knama"];
      $rowOutput["jpk_jnama"] = $val["jpk_jnama"];
      $rowOutput["hrt_hnama"] = $val["hrt_hnama"];

      $rowOutput["adpg1"] = $val["adpg1"];
      $rowOutput["adpg2"] = $val["adpg2"];
      $rowOutput["adpg3"] = $val["adpg3"];
      $rowOutput["adpg4"] = $val["adpg4"];
      $rowOutput["pvd_almt1"] = $val["pvd_almt1"];
      $rowOutput["pvd_almt2"] = $val["pvd_almt2"];
      $rowOutput["pvd_almt3"] = $val["pvd_almt3"];
      $rowOutput["pvd_almt4"] = $val["pvd_almt4"];
      $rowOutput["pvd_almt5"] = $val["pvd_almt5"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;
  }

  public function remacthingtable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    $database = Database::openConnection();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery =
        "CAST(peg_akaun AS TEXT) = '" .
        $searchValue .
        "%' OR pmk_nmbil LIKE '%" .
        $searchValue .
        "%' OR adpg1 LIKE '%" .
        $searchValue .
        "%' OR adpg2 LIKE '%" .
        $searchValue .
        "%' OR adpg3 LIKE '%" .
        $searchValue .
        "%' OR adpg4 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt1 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt2 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt3 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt4 LIKE '%" .
        $searchValue .
        "%' OR pvd_almt5 LIKE '%" .
        $searchValue .
        "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.hvnduk h";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.hvnduk h ";
    if ($searchValue != "") {
      $sql .= " WHERE " . $searchQuery . " AND peg_codex is not null AND peg_codey is not null";
    } else {
      $sql .= " WHERE peg_codex is not null AND peg_codey is not null";
    }
    $sel = $database->prepare($sql);
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM data.hvnduk h ";
    if ($searchValue != "") {
      $sql .= " WHERE " . $searchQuery . " AND peg_codex is not null AND peg_codey is not null";
    } else {
      $sql .= " WHERE peg_codex is not null AND peg_codey is not null";
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
      $rowOutput["id"] = Encryption::encryptId($val["peg_akaun"]);
      $rowOutput["peg_akaun"] = $val["peg_akaun"];
      $rowOutput["peg_nompt"] = $val["peg_nompt"];
      $rowOutput["pmk_nmbil"] = $val["pmk_nmbil"];
      $rowOutput["jln_jnama"] = $val["jln_jnama"];
      $rowOutput["jln_knama"] = $val["jln_knama"];
      $rowOutput["jpk_jnama"] = $val["jpk_jnama"];
      $rowOutput["hrt_hnama"] = $val["hrt_hnama"];

      $rowOutput["adpg1"] = $val["adpg1"];
      $rowOutput["adpg2"] = $val["adpg2"];
      $rowOutput["adpg3"] = $val["adpg3"];
      $rowOutput["adpg4"] = $val["adpg4"];
      $rowOutput["pvd_almt1"] = $val["pvd_almt1"];
      $rowOutput["pvd_almt2"] = $val["pvd_almt2"];
      $rowOutput["pvd_almt3"] = $val["pvd_almt3"];
      $rowOutput["pvd_almt4"] = $val["pvd_almt4"];
      $rowOutput["pvd_almt5"] = $val["pvd_almt5"];
      $rowOutput["role"] = Session::getUserRole();
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;
  }

  public function getAccountInfo($fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT s.*, h.tnh_tnama, b.bgn_bnama, st.stb_snama FROM data.hvnduk s ";
    $query .= "LEFT JOIN data.htanah h ON s.peg_thkod = h.tnh_thkod ";
    $query .= "LEFT JOIN data.hbangn b ON s.peg_bgkod = b.bgn_bgkod ";
    $query .= "LEFT JOIN data.hstbgn st ON s.peg_stkod = st.stb_stkod ";
    $query .= "WHERE s.peg_akaun = :akaun ";
    $database->prepare($query);
    $database->bindValue(":akaun", Encryption::decryptId($fileId));
    $database->execute();

    $info = $database->fetchAssociative();
    return $info;
  }

  public function getAmendTable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $area = "", $street = "")
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitioninfo ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitioninfo ";
    if ($area != "" && $street != "") {
      $sql .= "WHERE kwkod = :kwkod AND jlkod = :jlkod";
    }
    $sel = $database->prepare($sql);
    if ($area != "" && $street != "") {
      $database->bindValue(":kwkod", $area);
      $database->bindValue(":jlkod", $street);
    }
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM data.v_submitioninfo ";
    if ($area != "" && $street != "") {
      $query .= "WHERE kwkod = :kwkod AND jlkod = :jlkod";
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;

    $database->prepare($query);
    if ($area != "" && $street != "") {
      $database->bindValue(":kwkod", $area);
      $database->bindValue(":jlkod", $street);
    }
    $database->execute();

    $row = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {
      $dboracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["no_akaun"]);
      $info = $dboracle->fetchAssociative();

      $rowOutput["noSiri"] = Encryption::encryptId($val["no_siri"]);
      $rowOutput["noAcct"] = Encryption::encryptId($val["no_akaun"]);
      $rowOutput["no_siri"] = $val["no_siri"];
      $rowOutput["no_akaun"] = $val["no_akaun"];
      $rowOutput["tkhpl"] = $val["tkhpl"];
      $rowOutput["tkhtk"] = $val["tkhtk"];
      if ($val["thkod"] != 0) {
        $rowOutput["tnama"] = $dboracle->getElementById("SPMC.V_HTANAH", "tnh_tnama", "tnh_thkod", $val["thkod"]);
      } else {
        $rowOutput["tnama"] = $val["thkod"];
      }
      if ($val["htkod"] != 0) {
        $rowOutput["hnama"] = $dboracle->getElementById("SPMC.V_HHARTA", "hrt_hnama", "hrt_htkod", $val["htkod"]);
      } else {
        $rowOutput["hnama"] = $val["htkod"];
      }
      if ($val["thkod"] != 0) {
        $rowOutput["bnama"] = $dboracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["bgkod"]);
      } else {
        $rowOutput["bnama"] = $val["bgkod"];
      }
      if ($val["thkod"] != 0) {
        $rowOutput["snama"] = $dboracle->getElementById("SPMC.V_HSTBGN", "stb_snama", "stb_stkod", $val["stkod"]);
      } else {
        $rowOutput["snama"] = $val["stkod"];
      }
      $rowOutput["nilth_asal"] = $info["peg_nilth"];
      $rowOutput["kadar_asal"] = $info["kaw_kadar"];
      $rowOutput["cukai_asal"] = $info["peg_tksir"];
      $rowOutput["nilth_baru"] = $val["new_nilth"];
      $rowOutput["kadar_baru"] = $val["new_rate"];
      $rowOutput["cukai_baru"] = $val["new_tax"];
      $rowOutput["sebab"] = $dboracle->getElementById("SPMC.V_ACMRSN", "acm_sbktr", "acm_sbkod", $val["sebab"]);
      $rowOutput["mesej"] = $val["mesej"];
      // $rowOutput["status"] = $val["status"];
      // $rowOutput["vstatus"] = $val["vstatus"];
      $rowOutput["entry"] = $val["entry"];
      $rowOutput["verifier"] = $val["verifier"];
      $rowOutput["form"] = $val["form"];
      $rowOutput["calctype"] = $val["calctype"];
      array_push($output, $rowOutput);
    }
    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;
  }

  public function getVerifyTable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $area = "", $street = "")
  {
    $database = Database::openConnection();

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_verifyinfo ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_verifyinfo ";
    if ($area != "" && $street != "") {
      $sql .= "WHERE kwkod = :kwkod AND jlkod = :jlkod AND vstatus = 0";
    }
    $sel = $database->prepare($sql);
    if ($area != "" && $street != "") {
      $database->bindValue(":kwkod", $area);
      $database->bindValue(":jlkod", $street);
    }
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM data.v_verifyinfo ";
    if ($area != "" && $street != "") {
      $query .= "WHERE kwkod = :kwkod AND jlkod = :jlkod AND vstatus = 0";
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;

    $database->prepare($query);
    if ($area != "" && $street != "") {
      $database->bindValue(":kwkod", $area);
      $database->bindValue(":jlkod", $street);
    }
    $database->execute();

    $row = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {
      $rowOutput["noSiri"] = Encryption::encryptId($val["no_siri"]);
      $rowOutput["noAcct"] = Encryption::encryptId($val["no_akaun"]);
      $rowOutput["no_siri"] = $val["no_siri"];
      $rowOutput["no_akaun"] = $val["no_akaun"];
      $rowOutput["tkhpl"] = $val["tkhpl"];
      $rowOutput["tkhtk"] = $val["tkhtk"];
      $rowOutput["tnama"] = $val["tnama"];
      $rowOutput["hnama"] = $val["hnama"];
      $rowOutput["bnama"] = $val["bnama"];
      $rowOutput["snama"] = $val["snama"];
      $rowOutput["nilth_asal"] = $val["nilth_asal"];
      $rowOutput["kadar_asal"] = $val["kadar_asal"];
      $rowOutput["cukai_asal"] = $val["cukai_asal"];
      $rowOutput["nilth_baru"] = $val["nilth_baru"];
      $rowOutput["kadar_baru"] = $val["kadar_baru"];
      $rowOutput["cukai_baru"] = $val["cukai_baru"];
      $rowOutput["sebab"] = $val["sebab"];
      $rowOutput["mesej"] = $val["mesej"];
      $rowOutput["status"] = $val["status"];
      $rowOutput["entry"] = $val["entry"];
      $rowOutput["verifier"] = $val["verifier"];
      $rowOutput["form"] = $val["form"];
      $rowOutput["calctype"] = $val["calctype"];
      array_push($output, $rowOutput);
    }
    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;
  }

  public function getReviewTable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "", $street = "")
  {
    $database = Database::openConnection();
    $dbOracle = Oracle::openOriConnection();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "(CAST(r.mfa AS TEXT) = '" . $searchValue . "' OR CAST(r.afa AS TEXT) = '" . $searchValue . "' OR m.jln_jnama LIKE '%" . $searchValue . "%' OR CAST(h.peg_lsbgn AS TEXT) = '" . $searchValue . "' OR CAST(h.peg_nilth AS TEXT) = '" . $searchValue . "' OR h2.bgn_bnama LIKE '%" . $searchValue . "%')";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitioninfops v ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitioninfops v ";
    if ($area != "" && $street != "") {
      $sql .= "WHERE kwkod = :kwkod AND jlkod = :jlkod";
    }
    if ($searchValue != "") {
      $sql .= "WHERE " . $searchQuery;
    }
    $sel = $database->prepare($sql);
    if ($area != "" && $street != "") {
      $database->bindValue(":kwkod", $area);
      $database->bindValue(":jlkod", $street);
    }
    $database->execute($sel);

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT v.* FROM data.v_submitioninfops v ";
    if ($area != "" && $street != "") {
      $query .= "WHERE kwkod = :kwkod AND jlkod = :jlkod";
    }
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;

    $database->prepare($query);
    if ($area != "" && $street != "") {
      $database->bindValue(":kwkod", $area);
      $database->bindValue(":jlkod", $street);
    }
    $database->execute();

    $rows = $database->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($rows as $val) {

      //$dbOracle->getReasonById($val["sebab"]);
      // $sb = $dbOracle->fetchAssociative();

      $qry  = "SELECT vh.peg_nilth, vh.kaw_kadar, vh.peg_tksir, vb.bgn_bnama, vc.hrt_hnama, vd.tnh_tnama, ve.stb_snama FROM SPMC.V_HVNDUK vh ";
      $qry  .= "LEFT JOIN SPMC.V_HBANGN vb ON vh.peg_bgkod = vb.bgn_bgkod ";
      $qry  .= "LEFT JOIN SPMC.V_HHARTA vc ON vh.peg_htkod = vc.hrt_htkod ";
      $qry  .= "LEFT JOIN SPMC.V_HTANAH vd ON vh.peg_thkod = vd.tnh_thkod ";
      $qry  .= "LEFT JOIN SPMC.V_HSTBGN ve ON vh.peg_bgkod = ve.stb_stkod ";
      $qry  .= "WHERE vh.peg_akaun = " . $val['acctno'];
      $dbOracle->prepare($qry);
      $dbOracle->execute();
      $res = $dbOracle->fetchAssociative();

      if ($res) {
        $nilth_asal = $res["peg_nilth"];
        $kadar_asal = $res["kaw_kadar"];
        $cukai_asal = $res["peg_tksir"];
        $tnama = $res["tnh_tnama"];
        $hnama = $res["hrt_hnama"];
        $bnama = $res["bgn_bnama"];
        $snama = $res["stb_snama"];
      } else {
        $nilth_asal = 0;
        $kadar_asal = 0;
        $cukai_asal = 0;
        $tnama = "-";
        $hnama = "-";
        $bnama = "-";
        $snama = "-";
      }

      $rowOutput["noSiri"] = Encryption::encryptId($val["sirino"]);
      $rowOutput["noAcct"] = Encryption::encryptId($val["acctno"]);
      $rowOutput["no_siri"] = $val["sirino"];
      $rowOutput["no_akaun"] = $val["acctno"];
      $rowOutput["tkhpl"] = $val["tkhpl"];
      $rowOutput["tkhtk"] = $val["tkhtk"];
      $rowOutput["tnama"] = $tnama;
      $rowOutput["hnama"] = $hnama;
      $rowOutput["bnama"] = $bnama;
      $rowOutput["snama"] = $snama;
      $rowOutput["nilth_asal"] = number_format($nilth_asal, "2");
      $rowOutput["kadar_asal"] = $kadar_asal;
      $rowOutput["cukai_asal"] = number_format($cukai_asal, "2");
      $rowOutput["nilth_baru"] = number_format($val["new_nilth"], "2");
      $rowOutput["kadar_baru"] = $val["new_rate"];
      $rowOutput["cukai_baru"] = number_format($val["new_tax"], "2");
      $rowOutput["nilth_beza"] = number_format($val["new_nilth"] - $nilth_asal, "2");
      $rowOutput["kadar_beza"] = $val["new_rate"] - $kadar_asal;
      $rowOutput["cukai_beza"] = number_format($val["new_tax"] - $cukai_asal, "2");
      $rowOutput["sebab"] = "=";
      $rowOutput["mesej"] = $val["mesej"];
      $rowOutput["status"] = $val["status"];
      $rowOutput["entry"] = $val["entry"];
      $rowOutput["verifier"] = $val["verifier"];
      $rowOutput["form"] = $val["form"];
      $rowOutput["calctype"] = $val["calctype"];
      array_push($output, $rowOutput);
    }

    ## Response
    $response = [
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;
  }
}