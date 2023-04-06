<?php

class Informations extends Model
{

  public static function dateFormat($date)
  {
    $date = str_replace("-", "/", $date);
    $date = date("d/m/Y", strtotime($date));

    return $date;
  }
  public function escapeJsonString($value)
  {
    # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = ["\\", "'", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c"];
    $replacements = ["\\\\", "\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b"];
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }

  public function escapeJsonString2($value)
  {
    # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = ["\""];
    $replacements = [""];
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }

  public function checkSiriNo($data)
  {
    if ($data == null || $data == "") {
      return "-";
    } else {
      return Encryption::encryptId($data);
    }
  }

  public function status($data)
  {
    if ($data == "Y") {
      return "Belum Proses Bil";
    } elseif ($data == "P") {
      return "Sudah Proses Bil";
    } elseif ($data == "D") {
      return "Dikenakan denda Lewat";
    } elseif ($data == "N") {
      return "DiKenakan Notis E";
    } elseif ($data == "W") {
      return "Dikenakan Waran F";
    } elseif ($data == "H") {
      return "Akaun Tak Aktif(Hapus)";
    }
  }

  public function kodAnsuran($data)
  {
    if ($data == "Y") {
      return "Ya";
    } elseif ($data == "T") {
      return "Tidak";
    }
  }

  public function checkNull($data)
  {
    if ($data == null) {
      return "-";
    } else {
      return $data;
    }
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
      $rowOutput["tnh_tnama"] = $dbOracle->getElementById("SPMC.V_HTANAH", "tnh_tnama", "tnh_thkod", $val["smk_jstnh"]);
      $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["smk_jsbgn"]);
      $rowOutput["stb_snama"] = $dbOracle->getElementById("SPMC.V_HSTBGN", "stb_snama", "stb_stkod", $val["smk_stbgn"]);
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
      $rowOutput["smk_datevisit"] = date("d/m/Y H:i:s", strtotime($val["smk_datevisit"]));
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
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $output,
    ];

    return $response;
  }

  public function handleinfotable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "", $street = "")
  {
    // $database = Database::openConnection();
    $oracleDB = Oracle::openOriConnection();

    if ($searchValue != "") {
      $searchQuery =
        "peg_akaun LIKE '%" .
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
        "%' OR pvd_notel LIKE '%" .
        $searchValue .
        "%' OR  pvd_nofax LIKE '%" .
        $searchValue .
        "%' OR  pvd_email LIKE '%" .
        $searchValue .
        "%' OR pmk_nmbil LIKE '%" .
        $searchValue .
        "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HVNDUK h ";
    $sel = $oracleDB->prepare($sql);
    $oracleDB->execute($sel);
    $records = $oracleDB->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HVNDUK h ";
    $sql .= "LEFT JOIN SPMC.V_HHARTA b ON h.PEG_HTKOD = b.HRT_HTKOD ";
    $sql .= "LEFT JOIN SPMC.V_HBANGN c ON h.PEG_BGKOD = c.BGN_BGKOD ";
    $sql .= "LEFT JOIN SPMC.V_HSTBGN d ON h.PEG_STKOD = d.STB_STKOD ";
    $sql .= "LEFT JOIN SPMC.V_HTANAH e ON h.PEG_THKOD = e.TNH_THKOD ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $sql .= "WHERE JLN_KWKOD = :kwkod AND JLN_JLKOD = :jlkod AND PEG_STATF != 'H' AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $sql .= "WHERE JLN_KWKOD = :kwkod AND JLN_JLKOD = :jlkod AND PEG_STATF != 'H'";
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $sql .= "WHERE PEG_STATF != 'H' AND " . $searchQuery;
    } else {
      $sql .= "WHERE PEG_STATF != 'H'";
    }
    $sel = $oracleDB->prepare($sql);
    if ($area != "" && $street != "") {
      $oracleDB->bindValue(":kwkod", $area);
      $oracleDB->bindValue(":jlkod", $street);
    }
    $oracleDB->execute($sel);

    $records = $oracleDB->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT h.*, b.HRT_HNAMA, c.BGN_BNAMA, d.STB_SNAMA, e.TNH_TNAMA ";
    $query .= "FROM ( SELECT tmp.*, rownum rn ";
    $query .= "FROM( SELECT * FROM SPMC.V_HVNDUK ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $query .= "WHERE JLN_KWKOD = :kwkod AND JLN_JLKOD = :jlkod AND PEG_STATF != 'H' AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $query .= "WHERE JLN_KWKOD = :kwkod AND JLN_JLKOD = :jlkod AND PEG_STATF != 'H'";
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $query .= "WHERE PEG_STATF != 'H' AND " . $searchQuery;
    } else {
      $query .= "WHERE PEG_STATF != 'H'";
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp ";
    $query .= "WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "LEFT JOIN SPMC.V_HHARTA b ON h.PEG_HTKOD = b.HRT_HTKOD ";
    $query .= "LEFT JOIN SPMC.V_HBANGN c ON h.PEG_BGKOD = c.BGN_BGKOD ";
    $query .= "LEFT JOIN SPMC.V_HSTBGN d ON h.PEG_STKOD = d.STB_STKOD ";
    $query .= "LEFT JOIN SPMC.V_HTANAH e ON h.PEG_THKOD = e.TNH_THKOD ";
    $query .= "WHERE rn > " . (int) $row;
    $oracleDB->prepare($query);
    if ($area != "" && $street != "") {
      $oracleDB->bindValue(":kwkod", $area);
      $oracleDB->bindValue(":jlkod", $street);
    }
    $oracleDB->execute();

    $row = $oracleDB->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $key => $val) {
      $rowOutput["acct"] = Encryption::encryptId($val["peg_akaun"]);
      $rowOutput["peg_akaun"] = $val["peg_akaun"];
      $rowOutput["peg_nolot"] = $val["peg_nolot"];
      $rowOutput["peg_statf"] = $val["peg_statf"];
      $rowOutput["peg_wstatf"] = $val["peg_wstatf"];
      $rowOutput["adpg1"] = $val["adpg1"];
      $rowOutput["adpg2"] = $val["adpg2"];
      $rowOutput["adpg3"] = $val["adpg3"];
      $rowOutput["adpg4"] = $val["adpg4"];
      $rowOutput["pvd_almt1"] = $val["pvd_almt1"];
      $rowOutput["pvd_almt2"] = $val["pvd_almt2"];
      $rowOutput["pvd_almt3"] = $val["pvd_almt3"];
      $rowOutput["pvd_almt4"] = $val["pvd_almt4"];
      $rowOutput["pvd_almt5"] = $val["pvd_almt5"];
      $rowOutput["pvd_notel"] = $val["pvd_notel"];
      $rowOutput["pvd_nofax"] = $val["pvd_nofax"];
      $rowOutput["pvd_email"] = $val["pvd_email"];
      $rowOutput["jpk_jnama"] = $val["jpk_jnama"];
      $rowOutput["pvd_pnama"] = $val["pvd_pnama"];
      $rowOutput["pmk_nmbil"] = $val["pmk_nmbil"];
      $rowOutput["pmk_plgid"] = $val["pmk_plgid"];
      $rowOutput["pmk_hkmlk"] = $val["pmk_hkmlk"];
      $rowOutput["peg_nompt"] = $this->checkNull($val["peg_nompt"]);
      $rowOutput["jln_jnama"] = $val["jln_jnama"];
      $rowOutput["jln_kname"] = $val["jln_knama"];
      $rowOutput["peg_pelan"] = $this->checkNull($val["peg_pelan"]);
      $rowOutput["peg_rjmmk"] = $this->checkNull($val["peg_rjmmk"]);
      $rowOutput["tnh_tnama"] = $val["tnh_tnama"];
      $rowOutput["bgn_bnama"] = $val["bgn_bnama"];
      $rowOutput["hrt_hnama"] = $val["hrt_hnama"];
      $rowOutput["stb_snama"] = $val["stb_snama"];
      $rowOutput["peg_lstnh"] = $this->checkNull($val["peg_lstnh"]);
      $rowOutput["peg_lsbgn"] = $this->checkNull($val["peg_lsbgn"]);
      $rowOutput["peg_lsans"] = $this->checkNull($val["peg_lsans"]);
      $rowOutput["jpk_stcbk"] = $this->kodAnsuran($val["jpk_stcbk"]);
      $rowOutput["peg_nilth"] = $val["peg_nilth"];
      $rowOutput["kaw_kadar"] = $val["kaw_kadar"];
      $rowOutput["peg_tksir"] = $val["peg_tksir"];
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

  // public function handleinfotable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "", $street = "")
  // {
  //   $database = Database::openConnection();
  //   // $oracleDB = Oracle::openOriConnection();

  //   ## Total number of records without filtering
  //   $sql = "SELECT count(*) AS allcount FROM data.hvnduk h ";
  //   $sel = $database->prepare($sql);
  //   $database->execute($sel);
  //   $records = $database->fetchAssociative();
  //   $totalRecords = $records["allcount"];

  //   ## Total number of record with filtering
  //   $sql = "SELECT count(*) AS allcount FROM data.hvnduk h ";
  //   $sql .= "LEFT JOIN data.hharta b ON h.PEG_HTKOD = b.HRT_HTKOD ";
  //   $sql .= "LEFT JOIN data.hbangn c ON h.PEG_BGKOD = c.BGN_BGKOD ";
  //   $sql .= "LEFT JOIN data.hstbgn d ON h.PEG_STKOD = d.STB_STKOD ";
  //   $sql .= "LEFT JOIN data.htanah e ON h.PEG_THKOD = e.TNH_THKOD ";
  //   if ($area != "" && $street != "") {
  //     $sql .= " WHERE JLN_KWKOD = :kwkod AND JLN_JLKOD = :jlkod AND h.PEG_STATF != 'H'";
  //   } else {
  //     $sql .= " WHERE h.PEG_STATF != 'H'";
  //   }
  //   $sel = $database->prepare($sql);
  //   if ($area != "" && $street != "") {
  //     $database->bindValue(":kwkod", $area);
  //     $database->bindValue(":jlkod", $street);
  //   }
  //   $database->execute($sel);

  //   $records = $database->fetchAssociative();
  //   $totalRecordwithFilter = $records["allcount"];

  //   ## Fetch records
  //   $query = "SELECT h.*, b.HRT_HNAMA, c.BGN_BNAMA, d.STB_SNAMA, e.TNH_TNAMA ";
  //   $query .= "FROM data.hvnduk h ";
  //   $query .= "LEFT JOIN data.hharta b ON h.PEG_HTKOD = b.HRT_HTKOD ";
  //   $query .= "LEFT JOIN data.hbangn c ON h.PEG_BGKOD = c.BGN_BGKOD ";
  //   $query .= "LEFT JOIN data.hstbgn d ON h.PEG_STKOD = d.STB_STKOD ";
  //   $query .= "LEFT JOIN data.htanah e ON h.PEG_THKOD = e.TNH_THKOD ";

  //   if ($area != "" && $street != "") {
  //     $query .= "WHERE JLN_KWKOD = :kwkod AND JLN_JLKOD = :jlkod AND PEG_STATF != 'H'";
  //   } else {
  //     $query .= "WHERE PEG_STATF != 'H'";
  //   }
  //   if ($columnName != "") {
  //     $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
  //   }
  //   $query .= " LIMIT " . $rowperpage . " OFFSET " . $row;
  //   $database->prepare($query);
  //   if ($area != "" && $street != "") {
  //     $database->bindValue(":kwkod", $area);
  //     $database->bindValue(":jlkod", $street);
  //   }
  //   $database->execute();

  //   $row = $database->fetchAllAssociative();
  //   $output = [];
  //   $rowOutput = [];
  //   foreach ($row as $key => $val) {
  //     $rowOutput["acct"] = Encryption::encryptId($val["peg_akaun"]);
  //     $rowOutput["peg_akaun"] = $val["peg_akaun"];
  //     $rowOutput["peg_nolot"] = $val["peg_nolot"];
  //     $rowOutput["peg_statf"] = $val["peg_statf"];
  //     $rowOutput["peg_wstatf"] = $val["peg_wstatf"];
  //     $rowOutput["adpg1"] = $val["adpg1"];
  //     $rowOutput["adpg2"] = $val["adpg2"];
  //     $rowOutput["adpg3"] = $val["adpg3"];
  //     $rowOutput["adpg4"] = $val["adpg4"];
  //     $rowOutput["pvd_almt1"] = $val["pvd_almt1"];
  //     $rowOutput["pvd_almt2"] = $val["pvd_almt2"];
  //     $rowOutput["pvd_almt3"] = $val["pvd_almt3"];
  //     $rowOutput["pvd_almt4"] = $val["pvd_almt4"];
  //     $rowOutput["pvd_almt5"] = $val["pvd_almt5"];
  //     $rowOutput["pvd_notel"] = $val["pvd_notel"];
  //     $rowOutput["pvd_nofax"] = $val["pvd_nofax"];
  //     $rowOutput["pvd_email"] = $val["pvd_email"];
  //     $rowOutput["jpk_jnama"] = $val["jpk_jnama"];
  //     $rowOutput["pvd_pnama"] = $val["pvd_pnama"];
  //     $rowOutput["pmk_nmbil"] = $val["pmk_nmbil"];
  //     $rowOutput["pmk_plgid"] = $val["pmk_plgid"];
  //     $rowOutput["pmk_hkmlk"] = $val["pmk_hkmlk"];
  //     $rowOutput["peg_nompt"] = $this->checkNull($val["peg_nompt"]);
  //     $rowOutput["jln_jnama"] = $val["jln_jnama"];
  //     $rowOutput["jln_kname"] = $val["jln_knama"];
  //     $rowOutput["peg_pelan"] = $this->checkNull($val["peg_pelan"]);
  //     $rowOutput["peg_rjmmk"] = $this->checkNull($val["peg_rjmmk"]);
  //     $rowOutput["tnh_tnama"] = $val["tnh_tnama"];
  //     $rowOutput["bgn_bnama"] = $val["bgn_bnama"];
  //     $rowOutput["hrt_hnama"] = $val["hrt_hnama"];
  //     $rowOutput["stb_snama"] = $val["stb_snama"];
  //     $rowOutput["peg_lstnh"] = $this->checkNull($val["peg_lstnh"]);
  //     $rowOutput["peg_lsbgn"] = $this->checkNull($val["peg_lsbgn"]);
  //     $rowOutput["peg_lsans"] = $this->checkNull($val["peg_lsans"]);
  //     $rowOutput["jpk_stcbk"] = $this->kodAnsuran($val["jpk_stcbk"]);
  //     $rowOutput["peg_nilth"] = $val["peg_nilth"];
  //     $rowOutput["kaw_kadar"] = $val["kaw_kadar"];
  //     $rowOutput["peg_tksir"] = $val["peg_tksir"];
  //     array_push($output, $rowOutput);
  //   }

  //   ## Response
  //   $response = [
  //     "draw" => intval($draw),
  //     "iTotalRecords" => $totalRecords,
  //     "iTotalDisplayRecords" => $totalRecordwithFilter,
  //     "aaData" => $output,
  //   ];

  //   return $response;
  // }

  public function ownerinfotable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    // $database = Database::openConnection();
    $dboracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery =
        "CAST(h.pmk_akaun AS TEXT) = '" .
        $searchValue .
        "' OR h.pmk_plgid = '" .
        $searchValue .
        "' OR h.pmk_nmbil LIKE '%" .
        $searchValue .
        "%' OR CAST(h.pmk_blpmk AS TEXT) = '" .
        $searchValue .
        "' OR h.pmk_hkmlk LIKE '%" .
        $searchValue .
        "%' OR h.pmk_kdans LIKE '%" .
        $searchValue .
        "%' OR h.pmk_kdexp LIKE '%" .
        $searchValue .
        "%' OR CAST(h.pmk_prtus AS TEXT) = '" .
        $searchValue .
        "' OR h.pmk_rujmj LIKE '%" .
        $searchValue .
        "%' OR h.pmk_jilid LIKE '%" .
        $searchValue .
        "%' OR h.pmk_statf LIKE '%" .
        $searchValue .
        "%' OR h.pmk_stang LIKE '%" .
        $searchValue .
        "%' OR h.pmk_kppek LIKE '%" .
        $searchValue .
        "%' OR CAST(h.pmk_amtid AS TEXT) = '" .
        $searchValue .
        "' OR h.pvd_pnama LIKE '%" .
        $searchValue .
        "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HVNDUK h ";
    $sel = $dboracle->prepare($sql);
    $dboracle->execute($sel);
    $records = $dboracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM SPMC.V_HVNDUK h ";
    if ($searchValue != "") {
      $sql .= " WHERE " . $searchQuery;
    }
    $sel = $dboracle->prepare($sql);
    $dboracle->execute($sel);

    $records = $dboracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM (";
    $query .= "SELECT tmp.*, rownum rn FROM(";
    $query .= "SELECT pmk_akaun, peg_wstatf, pmk_plgid, pmk_nmbil, pmk_blpmk, pmk_hkmlk, ";
    $query .= "pmk_kdans, pmk_wkdans, pmk_kdexp, pmk_prtus, pmk_rujmj, pmk_jilid, pmk_statf, pmk_stang, ";
    $query .= "pmk_kppek, pmk_amtid, pvd_pnama, pvd_wkbgsa, pvd_almt1, pvd_almt2, pvd_almt3, pvd_almt4, ";
    $query .= "pvd_almt5 FROM SPMC.V_HVNDUK ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;

    $dboracle->prepare($query);
    $dboracle->execute();
    $row = $dboracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {
      $rowOutput["acct"] = Encryption::encryptId($val["pmk_akaun"]);
      $rowOutput["peg_wstatf"] = $val["peg_wstatf"];
      $rowOutput["pmk_akaun"] = $val["pmk_akaun"];
      $rowOutput["pmk_plgid"] = $val["pmk_plgid"];
      $rowOutput["pmk_nmbil"] = $val["pmk_nmbil"];
      $rowOutput["pmk_blpmk"] = $val["pmk_blpmk"];
      $rowOutput["pmk_hkmlk"] = $val["pmk_hkmlk"];
      $rowOutput["pmk_kdans"] = $val["pmk_kdans"];
      $rowOutput["pmk_wkdans"] = $val["pmk_wkdans"];
      $rowOutput["pmk_kdexp"] = $val["pmk_kdexp"];
      $rowOutput["pmk_prtus"] = $val["pmk_prtus"];
      $rowOutput["pmk_rujmj"] = $this->checkNull($val["pmk_rujmj"]);
      $rowOutput["pmk_jilid"] = $this->checkNull($val["pmk_jilid"]);
      $rowOutput["pmk_statf"] = $val["pmk_statf"];
      $rowOutput["pmk_stang"] = $val["pmk_stang"];
      $rowOutput["pmk_kppek"] = $val["pmk_kppek"];
      $rowOutput["pmk_amtid"] = $val["pmk_amtid"];
      $rowOutput["pvd_pnama"] = $val["pvd_pnama"];
      $rowOutput["pvd_wkbgsa"] = $val["pvd_wkbgsa"];
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

  public function vendorinfotable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue)
  {
    // $database = Database::openConnection();
    $dboracle =
      Oracle::openOriConnection();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "CAST(pid_plgid AS TEXT) = '" . $searchValue . "' OR pid_pnama LIKE '%" . $searchValue . "%'";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM V_PLNGAN h ";
    $sel = $dboracle->prepare($sql);
    $dboracle->execute($sel);
    $records = $dboracle->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM V_PLNGAN h ";
    if ($searchValue != "") {
      $sql .= " WHERE " . $searchQuery;
    }
    $sel = $dboracle->prepare($sql);
    $dboracle->execute($sel);

    $records = $dboracle->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT * FROM (";
    $query .= "SELECT tmp.*, rownum rn FROM(";
    $query .= "SELECT DISTINCT PID_PLGID, PID_PNAMA, PID_JENPG, VAL_AMTID, VAL_ALMT1, VAL_ALMT2, VAL_ALMT3, VAL_ALMT4, VAL_ALMT5, VAL_POSKD FROM SPMC.V_PLNGAN ";
    if ($searchValue != "") {
      $query .= "WHERE " . $searchQuery;
    }
    if ($columnName != "") {
      $query .= " ORDER BY " . $columnName . " " . $columnSortOrder;
    }
    $query .= ") tmp WHERE rownum <= " . (int) ($row + $rowperpage) . " ) h ";
    $query .= "WHERE rn > " . (int) $row;
    $dboracle->prepare($query);
    $dboracle->execute();

    $row = $dboracle->fetchAllAssociative();
    $output = [];
    $rowOutput = [];
    foreach ($row as $val) {
      $rowOutput["pid_plgid"] = $val["pid_plgid"];
      $rowOutput["pid_pnama"] = $val["pid_pnama"];
      $rowOutput["pid_jenpg"] = $val["pid_jenpg"];
      $rowOutput["val_almt1"] = $val["val_almt1"];
      $rowOutput["val_almt2"] = $val["val_almt2"];
      $rowOutput["val_almt3"] = $val["val_almt3"];
      $rowOutput["val_almt4"] = $val["val_almt4"];
      $rowOutput["val_almt5"] = $val["val_almt5"];
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

  public function comparison($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $type, $kwkod, $htkod)
  {
    $database = Database::openConnection();
    $dbOracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "(CAST(r.mfa AS TEXT) = '" . $searchValue . "' OR CAST(r.afa AS TEXT) = '" . $searchValue . "' OR m.jln_jnama LIKE '%" . $searchValue . "%' OR CAST(h.peg_lsbgn AS TEXT) = '" . $searchValue . "' OR CAST(h.peg_nilth AS TEXT) = '" . $searchValue . "' OR h2.bgn_bnama LIKE '%" . $searchValue . "%')";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_rating r ";
    $sql .= "WHERE r.jenis = " . $type . " AND r.kwkod = " . $kwkod . " AND r.htkod = " . $htkod;
    $sel = $database->prepare($sql);
    $database->execute();
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $qry = "SELECT count(*) AS allcount FROM data.v_rating r ";
    $qry .= "WHERE r.jenis = " . $type . " AND r.kwkod = " . $kwkod . " AND r.htkod = " . $htkod;
    if ($searchValue != "") {
      $qry .= " AND " . $searchQuery;
    }
    $all = $database->prepare($qry);
    $database->execute();

    $records = $database->fetchAssociative();
    $totalRecordwithFilter = $records["allcount"];

    ## Fetch records
    $query = "SELECT r.* FROM data.v_rating r ";
    $query .= "WHERE r.jenis = " . $type . " AND r.kwkod = " . $kwkod . " AND r.htkod = " . $htkod;
    if ($searchValue != "") {
      $query .= " AND " . $searchQuery;
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
      $dbOracle->getByNoAcct("V_HVNDUK", "peg_akaun", $val["akaun"]);
      $info = $dbOracle->fetchAssociative();

      $rowOutput["id"] = $val["id"];
      $rowOutput["akaun"] = $val["akaun"];
      $rowOutput["nmbil"] = $val["nmbil"];
      $rowOutput["jln_kname"] = $dbOracle->getElementById("SPMC.V_MKWJLN", "kws_knama", "jln_jlkod", $val["jlkod"]);
      if ($val["smk_jsbgn"] != null) {
        $rowOutput["bgn_bnama"] = $dbOracle->getElementById("SPMC.V_HBANGN", "bgn_bnama", "bgn_bgkod", $val["bgkod"]);
      } else {
        $rowOutput["bgn_bnama"] = $this->checkNull($val["bgkod"]);
      }
      $rowOutput["peg_nolot"] = $info["peg_nolot"];
      $rowOutput["peg_lsbgn"] = $info["peg_lsbgn"];
      $rowOutput["peg_nilth"] = $info["peg_nilth"];
      $rowOutput["mfa"] = $val["mfa"];
      $rowOutput["afa"] = $val["afa"];
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

  public function submissiontable($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue, $area = "", $street = "")
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $searchQuery = "";
    if ($searchValue != "") {
      $searchQuery = "(CAST(r.mfa AS TEXT) = '" . $searchValue . "' OR CAST(r.afa AS TEXT) = '" . $searchValue . "' OR m.jln_jnama LIKE '%" . $searchValue . "%' OR CAST(h.peg_lsbgn AS TEXT) = '" . $searchValue . "' OR CAST(h.peg_nilth AS TEXT) = '" . $searchValue . "' OR h2.bgn_bnama LIKE '%" . $searchValue . "%')";
    }

    ## Total number of records without filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitionvendorinfo v ";
    $sel = $database->prepare($sql);
    $database->execute($sel);
    $records = $database->fetchAssociative();
    $totalRecords = $records["allcount"];

    ## Total number of record with filtering
    $sql = "SELECT count(*) AS allcount FROM data.v_submitionvendorinfo v ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $sql .= "WHERE v.stsvd = 2 AND kwkod = :kwkod AND jlkod = :jlkod AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $sql .= "WHERE v.stsvd = 2 AND kwkod = :kwkod AND jlkod = :jlkod ";
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $sql .= "WHERE v.stsvd = 2 AND " . $searchQuery;
    } else {
      $sql .= "WHERE v.stsvd = 2";
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
    $query = "SELECT v.* FROM data.v_submitionvendorinfo v ";
    if ($area != "" && $street != "" && $searchValue != "") {
      $query .= "WHERE v.stsvd = 2 AND kwkod = :kwkod AND jlkod = :jlkod AND " . $searchQuery;
    } elseif ($area != "" && $street != "" && $searchValue == "") {
      $query .= "WHERE v.stsvd = 2 AND kwkod = :kwkod AND jlkod = :jlkod ";
    } elseif ($area == "" && $street == "" && $searchValue != "") {
      $query .= "WHERE v.stsvd = 2 AND " . $searchQuery;
    } else {
      $query .= "WHERE v.stsvd = 2";
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

      //$dboracle->getReasonById($val["sebab"]);
      // $sb = $dboracle->fetchAssociative();

      $qry  = "SELECT vh.peg_nilth, vh.kaw_kadar, vh.peg_tksir, vb.bgn_bnama, vc.hrt_hnama, vd.tnh_tnama, ve.stb_snama FROM SPMC.V_HVNDUK vh ";
      $qry  .= "LEFT JOIN SPMC.V_HBANGN vb ON vh.peg_bgkod = vb.bgn_bgkod ";
      $qry  .= "LEFT JOIN SPMC.V_HHARTA vc ON vh.peg_htkod = vc.hrt_htkod ";
      $qry  .= "LEFT JOIN SPMC.V_HTANAH vd ON vh.peg_thkod = vd.tnh_thkod ";
      $qry  .= "LEFT JOIN SPMC.V_HSTBGN ve ON vh.peg_bgkod = ve.stb_stkod ";
      $qry  .= "WHERE vh.peg_akaun = " . $val['acctno'];
      $dboracle->prepare($qry);
      $dboracle->execute();
      $res = $dboracle->fetchAssociative();

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
      $rowOutput["sebab"] = $dboracle->getElementById("SPMC.V_ACMRSN", "acm_sbktr", "acm_sbkod", $val["sebab"]);
      $rowOutput["mesej"] = $val["mesej"];
      $rowOutput["stsvd"] = $val["stsvd"];
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

  public function comparisontable($type, $kwkod, $htkod)
  {
    $database = Database::openConnection();

    $query = "SELECT r.*, m.jln_jnama, h.peg_nolot, h.peg_lsbgn, h.peg_nilth, h2.bgn_bnama FROM data.v_rating r ";
    $query .= "LEFT JOIN data.hvnduk h ON r.akaun = h.peg_akaun ";
    $query .= "LEFT JOIN data.hbangn h2 ON r.bgkod = h2.bgn_bgkod ";
    $query .= "LEFT JOIN data.mkwjln m ON r.jlkod = m.jln_jlkod ";
    $query .= "WHERE r.jenis = :jenis AND r.kwkod = :kwkod AND r.htkod = :htkod ";

    $database->prepare($query);
    $database->bindValue(":jenis", $type);
    $database->bindValue(":kwkod", $kwkod);
    $database->bindValue(":htkod", $htkod);
    $database->execute();

    $info = $database->fetchAllAssociative();
    return $info;
  }

  public function getDetailsHandle($fileId)
  {
    $database = Database::openConnection();
    // $dboracle = new Oracle();
    $query = "SELECT h.*, h3.tnh_tnama, h2.hrt_hnama, h4.bgn_bnama, h5.stb_snama, h6.jpk_jnama ";
    $query .= "FROM data.hvnduk h ";
    $query .= "left join data.hharta h2 on h.peg_htkod = h2.hrt_htkod ";
    $query .= "left join data.htanah h3 on h.peg_thkod = h3.tnh_thkod ";
    $query .= "left join data.hbangn h4 on h.peg_bgkod = h4.bgn_bgkod ";
    $query .= "left join data.hstbgn h5 on h.peg_stkod = h5.stb_stkod ";
    $query .= "left join data.hjenpk h6 on h.peg_jpkod = h6.jpk_jpkod ";
    $query .= "WHERE h.peg_akaun = :peg_akaun";
    $database->prepare($query);
    $database->bindValue(":peg_akaun", $fileId);
    $database->execute();
    $info = $database->fetchAssociative();

    $rowOutput = [];

    $rowOutput["peg_oldac"] = $this->checkNull($info["peg_oldac"]);
    $rowOutput["peg_akaun"] = $info["peg_akaun"];
    $rowOutput["peg_thkod"] = $info["peg_thkod"];
    $rowOutput["peg_bgkod"] = $info["peg_bgkod"];
    $rowOutput["peg_htkod"] = $info["peg_htkod"];
    $rowOutput["peg_stkod"] = $info["peg_stkod"];
    $rowOutput["peg_jpkod"] = $info["peg_jpkod"];
    $rowOutput["peg_adpg1"] = $info["peg_adpg1"];
    $rowOutput["peg_adpg2"] = $info["peg_adpg2"];
    $rowOutput["peg_codex"] = $info["peg_codex"];
    $rowOutput["peg_codey"] = $info["peg_codey"];
    $rowOutput["pmk_plgid"] = $info["pmk_plgid"];
    $rowOutput["pvd_pnama"] = $info["pvd_pnama"];
    $rowOutput["pvd_wkbgsa"] = $info["pvd_wkbgsa"];
    $rowOutput["pvd_almt1"] = $this->checkNull($info["pvd_almt1"]);
    $rowOutput["pvd_almt2"] = $this->checkNull($info["pvd_almt2"]);
    $rowOutput["pvd_almt3"] = $this->checkNull($info["pvd_almt3"]);
    $rowOutput["pvd_almt4"] = $this->checkNull($info["pvd_almt4"]);
    $rowOutput["pvd_almt5"] = $this->checkNull($info["pvd_almt5"]);
    $rowOutput["peg_statf"] = $this->status($info["peg_statf"]);
    $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
    $rowOutput["pmk_blpmk"] = $this->checkNull($info["pmk_blpmk"]);
    $rowOutput["pmk_hkmlk"] = $info["pmk_hkmlk"];
    $rowOutput["pmk_kdans"] = $this->kodAnsuran($info["pmk_kdans"]);
    $rowOutput["pmk_prtus"] = $info["pmk_prtus"];
    $rowOutput["peg_rjfil"] = $this->checkNull($info["peg_rjfil"]);
    $rowOutput["pmk_rujmj"] = $this->checkNull($info["pmk_rujmj"]);
    $rowOutput["pmk_jilid"] = $this->checkNull($info["pmk_jilid"]);
    $rowOutput["adpg1"] = $this->checkNull($info["adpg1"]);
    $rowOutput["adpg2"] = $this->checkNull($info["adpg2"]);
    $rowOutput["adpg3"] = $this->checkNull($info["adpg3"]);
    $rowOutput["adpg4"] = $this->checkNull($info["adpg4"]);
    $rowOutput["hrt_hnama"] = $info["hrt_hnama"];
    $rowOutput["jpk_jnama"] = $info["jpk_jnama"];
    $rowOutput["tnh_tnama"] = $info["tnh_tnama"];
    $rowOutput["stb_snama"] = $info["stb_snama"];
    $rowOutput["bgn_bnama"] = $info["bgn_bnama"];
    $rowOutput["peg_nilth"] = $info["peg_nilth"];
    $rowOutput["kaw_kadar"] = $info["kaw_kadar"];
    $rowOutput["peg_nompt"] = $this->checkNull($info["peg_nompt"]);
    $rowOutput["peg_tksir"] = $info["peg_tksir"];
    $rowOutput["peg_pelan"] = $this->checkNull($info["peg_pelan"]);
    $rowOutput["peg_lsbgn"] = $this->checkNull($info["peg_lsbgn"]);
    $rowOutput["peg_tkhoc"] = $this->checkNull($info["peg_tkhoc"]);
    $rowOutput["peg_lstnh"] = $this->checkNull($info["peg_lstnh"]);
    $rowOutput["peg_tkhpl"] = $this->checkNull($info["peg_tkhpl"]);
    $rowOutput["peg_tkhtk"] = $this->checkNull($info["peg_tkhtk"]);
    $rowOutput["peg_rjmmk"] = $this->checkNull($info["peg_rjmmk"]);
    $rowOutput["peg_nolot"] = $this->checkNull($info["peg_nolot"]);
    $rowOutput["peg_codex"] = $this->checkNull($info["peg_codex"]);
    $rowOutput["peg_codey"] = $this->checkNull($info["peg_codey"]);
    $rowOutput["peg_smpah"] = $this->checkNull($info["peg_smpah"]);
    $rowOutput["peg_lsans"] = $this->checkNull($info["peg_lsans"]);
    $rowOutput["peg_bilpk"] = $this->checkNull($info["peg_bilpk"]);
    $rowOutput["pmk_statf"] = $this->checkNull($info["pmk_statf"]);
    $rowOutput["kaw_kwkod"] = $info["kaw_kwkod"];
    $rowOutput["jln_kwkod"] = $info["jln_kwkod"];
    $rowOutput["jln_knama"] = $info["jln_knama"];
    $rowOutput["jln_jlkod"] = $info["jln_jlkod"];
    $rowOutput["jln_jnama"] = $info["jln_jnama"];
    $rowOutput["peg_bllot"] = $this->checkNull($info["peg_bllot"]);

    return $rowOutput;
  }

  public function getReviewInfo($fileId)
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $query = "SELECT * FROM data.v_semak_raw vsr ";
    // $query .= "LEFT JOIN data.hvnduk h ON vsr.smk_akaun = h.peg_akaun ";
    $query .= "WHERE vsr.smk_akaun = :smk_akaun";
    $database->prepare($query);
    $database->bindValue(":smk_akaun", Encryption::decryptId($fileId));
    $database->execute();

    $row = $database->fetchAllAssociative();
    $rowOutput = [];
    foreach ($row as $val) {
      $dboracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["smk_akaun"]);
      $info = $dboracle->fetchAssociative();

      $rowOutput["no_akaun"] = $val["smk_akaun"];
      $rowOutput["no_lot"] = $val["smk_nolot"];
      $rowOutput["nmbil"] = $info["pmk_nmbil"];
      $rowOutput["plgid"] = $info["pmk_plgid"];
      $rowOutput["almt1"] = $info["pvd_almt1"];
      $rowOutput["almt2"] = $info["pvd_almt2"];
      $rowOutput["almt3"] = $info["pvd_almt3"];
      $rowOutput["almt4"] = $info["pvd_almt4"];
      $rowOutput["almt5"] = $info["pvd_almt5"];
      $rowOutput["notel"] = $info["pvd_notel"];
      $rowOutput["adpg1"] = $val["smk_adpg1"];
      $rowOutput["adpg2"] = $val["smk_adpg2"];
      $rowOutput["adpg3"] = $val["smk_adpg3"];
      $rowOutput["adpg4"] = $val["smk_adpg4"];
      $rowOutput["jnama"] = $info["jln_jnama"];
      $rowOutput["knama"] = $info["jln_knama"];
      $rowOutput["kwkod"] = $info["jln_kwkod"];

      $rowOutput["thkod"] = $row["smk_jstnh"];
      $rowOutput["bgkod"] = $row["smk_jsbgn"];
      $rowOutput["htkod"] = $row["smk_kgtnh"];
      $rowOutput["stkod"] = $row["smk_stbgn"];

      $rowOutput["thkod"] = $info["tnh_thkod"];
      $rowOutput["tnama"] = $info["tnh_tnama"];
      $rowOutput["htkod"] = $info["peg_htkod"];
      $rowOutput["hnama"] = $info["hrt_hnama"];
      // $rowOutput["bnama"] = $val["bnama"];
      // $rowOutput["snama"] = $val["snama"];
      $rowOutput["lsbgn"] = $info["peg_lsbgn"];
      $rowOutput["lstnh"] = $info["peg_lstnh"];
      $rowOutput["lsans"] = $info["peg_lsans"];
      $rowOutput["ttl_bgn"] = $val["smk_lsbgn_tmbh"] + $info["peg_lsbgn"];
      $rowOutput["ttl_ans"] = $val["smk_lsans_tmbh"] + $info["peg_lsans"];
      $rowOutput["nilth_asal"] = $info["peg_nilth"];
      $rowOutput["kadar_asal"] = $info["kaw_kadar"];
      $rowOutput["cukai_asal"] = $info["peg_tksir"];
    }

    return $rowOutput;

    $dboracle->closeOciConnection();
  }

  public function getCalcInfo($siriNo)
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $query = "SELECT c.*, vs.* FROM data.calculator c ";
    $query .= "LEFT JOIN data.v_semak_raw vs ON c.account_no = vs.smk_akaun ";
    $query .= "WHERE c.siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", Encryption::decryptId($siriNo));
    $database->execute();

    $row = $database->fetchAllAssociative();
    $rowOutput = [];
    foreach ($row as $val) {
      $dboracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["account_no"]);
      $row = $dboracle->fetchAssociative();

      $dataList = substr($val["comparison"], 1, -1);
      $result = $dataList ? explode(',', $dataList) : array();
      $integers = array_map('intval', $result);

      $rowOutput["nmbil"] = $row["pmk_nmbil"];
      $rowOutput["plgid"] = $row["pmk_plgid"];
      $rowOutput["nolot"] = $this->checkNull($val["smk_nolot"]);
      $rowOutput["nompt"] = $this->checkNull($val["smk_nompt"]);

      $rowOutput["calc_type"] = $val["calc_type"];
      $rowOutput["siri_no"] = $val["siri_no"];
      $rowOutput["account_no"] = $val["account_no"];
      if (count($integers) > 0) {
        $rowOutput["comparison"] = $this->getComparison($val["comparison"]);
      } else {
        $rowOutput["comparison"] = [];
      }
      $rowOutput["land"] = $this->getLand(Encryption::decryptId($siriNo));
      $rowOutput["mfa"] = $this->getMfa(Encryption::decryptId($siriNo));
      $rowOutput["afa"] = $this->getAfa(Encryption::decryptId($siriNo));
      $rowOutput["totalmfa"] = $this->getTotalMfa(Encryption::decryptId($siriNo));
      $rowOutput["totalafa"] = $this->getTotalAfa(Encryption::decryptId($siriNo));
      $rowOutput["capital"] = $val["capital"];
      $rowOutput["discount"] = $val["discount"];
      $rowOutput["rental"] = $val["rental"];
      $rowOutput["yearly_price"] = $val["yearly_price"];
      $rowOutput["even"] = $val["even"];
      $rowOutput["rate"] = $val["rate"];
      $rowOutput["assessment_tax"] = $val["assessment_tax"];

      $rowOutput["no_akaun"] = $val["smk_akaun"];
      $rowOutput["no_lot"] = $val["smk_nolot"];
      $rowOutput["adpg1"] = $val["smk_adpg1"];
      $rowOutput["adpg2"] = $val["smk_adpg2"];
      $rowOutput["adpg3"] = $val["smk_adpg3"];
      $rowOutput["adpg4"] = $val["smk_adpg4"];
      $rowOutput["thkod"] = $val["smk_jstnh"];
      $rowOutput["tnama"] = $dboracle->getElementById("V_HTANAH", "tnh_tnama", "tnh_thkod", $val["smk_jstnh"]);
      $rowOutput["htkod"] = $val["smk_kgtnh"];
      $rowOutput["ttl_bgn"] = $val["smk_lsbgn_tmbh"] + $row["peg_lsbgn"];
      $rowOutput["ttl_ans"] = $val["smk_lsans_tmbh"] + $row["peg_lsans"];
      $rowOutput["hnama"] = $row["hrt_hnama"];
      $rowOutput["jnama"] = $row["jln_jnama"];
      $rowOutput["knama"] = $row["jln_knama"];
      $rowOutput["kwkod"] = $row["jln_kwkod"];
      $rowOutput["lsbgn"] = $row["peg_lsbgn"];
      $rowOutput["lstnh"] = $row["peg_lstnh"];
      $rowOutput["lsans"] = $row["peg_lsans"];
      $rowOutput["nilth_asal"] = $row["peg_nilth"];
      $rowOutput["kadar_asal"] = $row["kaw_kadar"];
      $rowOutput["cukai_asal"] = $row["peg_tksir"];
    }

    return $rowOutput;

    $dboracle->closeOciConnection();
  }

  public function getSubmitionInfo($siriNo)
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $query = "SELECT * FROM data.v_submitioninfo ";
    $query .= "WHERE no_siri = :no_siri";
    $database->prepare($query);
    $database->bindValue(":no_siri", Encryption::decryptId($siriNo));
    $database->execute();

    $row = $database->fetchAllAssociative();
    $rowOutput = [];
    foreach ($row as $val) {
      $dboracle->getByNoAcct("V_HVNDUK", "PEG_AKAUN", $val["no_akaun"]);
      $row = $dboracle->fetchAssociative();

      $rowOutput["no_siri"] = $val["no_siri"];
      $rowOutput["no_akaun"] = $val["no_akaun"];
      $rowOutput["no_lot"] = $val["no_lot"];
      $rowOutput["tkhpl"] = $val["tkhpl"];
      $rowOutput["tkhtk"] = $val["tkhtk"];
      $rowOutput["nmbil"] = $val["nmbil"];
      $rowOutput["plgid"] = $val["plgid"];
      $rowOutput["adpg1"] = $val["adpg1"];
      $rowOutput["adpg2"] = $val["adpg2"];
      $rowOutput["adpg3"] = $row["adpg3"];
      $rowOutput["adpg4"] = $row["adpg4"];
      $rowOutput["jlkod"] = $val["jlkod"];
      $rowOutput["thkod"] = $val["thkod"];
      $rowOutput["htkod"] = $val["htkod"];
      $rowOutput["lsbgn"] = $row["peg_lsbgn"];
      $rowOutput["lstnh"] = $row["peg_lstnh"];
      $rowOutput["lsans"] = $row["peg_lsans"];
      $rowOutput["nilth_baru"] = $val["new_nilth"];
      $rowOutput["sebab"] = $val["sebab"];
      $rowOutput["mesej"] = $val["mesej"];
      // $rowOutput["status"] = $val["status"];
      $rowOutput["entry"] = $val["entry"];
      $rowOutput["verifier"] = $val["verifier"];
      $rowOutput["form"] = $val["form"];
    }

    return $rowOutput;
  }

  public function getSubmitionVendorInfo($siriNo)
  {
    $database = Database::openConnection();
    $query = "SELECT * FROM data.v_submitionvendorinfo ";
    $query .= "WHERE sirino = :no_siri";
    $database->prepare($query);
    $database->bindValue(":no_siri", Encryption::decryptId($siriNo));
    $database->execute();

    $row = $database->fetchAssociative();

    return $row;
  }

  public function getCalculationInfo($siriNo)
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $query = "SELECT distinct c.*, v.entry, v.entry_pos, v.verifier, v.verifier_pos, to_char(v.etdate, 'DD/MM/YYYY') as etdate, to_char(v.vfdate, 'DD/MM/YYYY') as vfdate FROM data.calculator c ";
    $query .= "INNER JOIN data.v_submitioninfo v ON c.siri_no = v.no_siri ";
    $query .= "WHERE c.siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", Encryption::decryptId($siriNo));
    $database->execute();

    $row = $database->fetchAllAssociative();
    $rowOutput = [];
    foreach ($row as $val) {
      $sql = "SELECT PMK_NMBIL, PMK_PLGID, PEG_NOLOT, PEG_NOMPT,";
      $sql .= "rtrim( ADPG1||', '||ADPG2||', '||ADPG3||', '||ADPG4,' ,') AS address, ";
      $sql .= "rtrim( PVD_ALMT1||', '||PVD_ALMT2||', '||PVD_ALMT3||', '||PVD_ALMT4,' ,') AS postal ";
      $sql .= "FROM SPMC.V_HVNDUK WHERE PEG_AKAUN = " . $val["account_no"];
      $sel = $dboracle->prepare($sql);
      $dboracle->execute($sel);
      $row = $dboracle->fetchAssociative();

      $dataList = substr($val["comparison"], 1, -1);
      $result = $dataList ? explode(',', $dataList) : array();
      $integers = array_map('intval', $result);

      $rowOutput["pmk_nmbil"] = $row["pmk_nmbil"];
      $rowOutput["pmk_plgid"] = $row["pmk_plgid"];
      $rowOutput["peg_nolot"] = $this->checkNull($row["peg_nolot"]);
      $rowOutput["peg_nompt"] = $this->checkNull($row["peg_nompt"]);
      $rowOutput["address"] = $row["address"];
      $rowOutput["postal"] = $row["postal"];

      $rowOutput["calc_type"] = $val["calc_type"];
      $rowOutput["siri_no"] = $val["siri_no"];
      $rowOutput["account_no"] = $val["account_no"];
      if (count($integers) >= 1) {
        $rowOutput["comparison"] = $this->getComparison($val["comparison"]);
      } else {
        $rowOutput["comparison"] = [];
      }
      $rowOutput["land"] = $this->getLand(Encryption::decryptId($siriNo));
      $rowOutput["mfa"] = $this->getMfa(Encryption::decryptId($siriNo));
      $rowOutput["afa"] = $this->getAfa(Encryption::decryptId($siriNo));
      $rowOutput["totalmfa"] = $this->getTotalMfa(Encryption::decryptId($siriNo));
      $rowOutput["totalafa"] = $this->getTotalAfa(Encryption::decryptId($siriNo));
      $rowOutput["capital"] = $val["capital"];
      $rowOutput["discount"] = $val["discount"];
      $rowOutput["rental"] = $val["rental"];
      $rowOutput["yearly_price"] = $val["yearly_price"];
      $rowOutput["even"] = $val["even"];
      $rowOutput["rate"] = $val["rate"];
      $rowOutput["assessment_tax"] = $val["assessment_tax"];

      $rowOutput["bnama"] = $val["bnama"];
      $rowOutput["clerk"] = $val["entry"];
      $rowOutput["clerk_pos"] = $val["entry_pos"];
      $rowOutput["verifier"] = $this->checkNull($val["verifier"]);
      $rowOutput["verifier_pos"] = $this->checkNull($val["verifier_pos"]);
      $rowOutput["etdate"] = $val["etdate"];
      $rowOutput["vfdate"] = $this->checkNull($val["vfdate"]);
    }

    return $rowOutput;
  }

  public function getComparison($comparison)
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $output = [];
    $rowOutput = [];

    $dataList = substr($comparison, 1, -1);
    $integers = array_map('intval', explode(',', $dataList));
    foreach ($integers as $value) {
      $query = "SELECT r.id, r.akaun, r.mfa, r.afa, h.bgn_bnama, DATE_PART('Year', r.date) as year FROM data.v_rating r ";
      $query .= "LEFT JOIN data.hbangn h ON r.bgkod = h.bgn_bgkod ";
      $query .= "WHERE r.id = :id";
      $database->prepare($query);
      $database->bindValue(":id", $value);
      $database->execute();
      $row = $database->fetchAssociative();

      $rowOutput["id"] = $row["id"];
      $rowOutput["mfa"] = $this->checkNull($row["mfa"]);
      $rowOutput["afa"] = $this->checkNull($row["afa"]);
      $rowOutput["bgn_bnama"] = $row["bgn_bnama"];
      $rowOutput["year"] = $row["year"];

      if ($row) {
        $qry  = "SELECT jln_jnama, peg_lsbgn, peg_lstnh, peg_nilth FROM SPMC.V_HVNDUK WHERE peg_akaun = " . $row['akaun'];
        $dboracle->prepare($qry);
        $dboracle->execute();
        $res = $dboracle->fetchAssociative();

        $rowOutput["jln_jnama"] = $res["jln_jnama"];
        $rowOutput["peg_lsbgn"] = $res["peg_lsbgn"];
        $rowOutput["peg_lstnh"] = $res["peg_lstnh"];
        $rowOutput["peg_nilth"] = $res["peg_nilth"];
      }
      array_push($output, $rowOutput);
    }
    return $output;
  }

  public function getLand($siriNo)
  {
    $database = Database::openConnection();
    $query = "SELECT * FROM data.items_land ";
    $query .= "WHERE siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();
    $rows = $database->fetchAssociative();

    return $rows;
  }

  public function getMfa($siriNo)
  {
    $database = Database::openConnection();

    $output = [];
    $rowOutput = [];

    $query = "SELECT id, title FROM data.section ";
    $query .= "WHERE section_type = 1 AND siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();

    if ($database->countRows() >= 1) {
      foreach ($database->fetchAllAssociative() as $row) {
        $rowOutput["id"] = $row["id"];
        $rowOutput["title"] = $row["title"];
        $rowOutput["items"] = $this->itemsMain($row["id"], $siriNo);
        array_push($output, $rowOutput);
      }
    } else {
      $rowOutput["id"] = 0;
      $rowOutput["title"] = "";
      $rowOutput["items"] = $this->itemsMain("", $siriNo);
      array_push($output, $rowOutput);
    }

    return $output;
  }

  public function getAfa($siriNo)
  {
    $database = Database::openConnection();

    $output = [];
    $rowOutput = [];

    $query = "SELECT id, title FROM data.section ";
    $query .= "WHERE section_type = 2 AND siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();

    if ($database->countRows() >= 1) {
      foreach ($database->fetchAllAssociative() as $row) {
        $rowOutput["id"] = $row["id"];
        $rowOutput["title"] = $row["title"];
        $rowOutput["items"] = $this->itemsOut($row["id"], $siriNo);
        array_push($output, $rowOutput);
      }
    } else {
      $rowOutput["id"] = 0;
      $rowOutput["title"] = "";
      $rowOutput["items"] = $this->itemsOut("", $siriNo);
      array_push($output, $rowOutput);
    }

    return $output;
  }

  public function getTotalMfa($siriNo)
  {
    $database = Database::openConnection();
    $query = "SELECT SUM(total) as total FROM data.items_main ";
    $query .= "WHERE siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();
    $records = $database->fetchAssociative();
    $total = $records["total"];

    return $total;
  }

  public function getTotalAfa($siriNo)
  {
    $database = Database::openConnection();
    $query = "SELECT SUM(total) as total FROM data.items_out ";
    $query .= "WHERE siri_no = :siri_no";
    $database->prepare($query);
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();
    $records = $database->fetchAssociative();
    $total = $records["total"];

    return $total;
  }

  public function itemsMain($sectionId, $siriNo)
  {
    $database = Database::openConnection();

    $query = "SELECT id, title, breadth, breadthtype, price, pricetype, total FROM data.items_main ";
    if (!empty($sectionId)) {
      $query .= "WHERE section_id = :section_id AND siri_no = :siri_no";
    } else {
      $query .= "WHERE siri_no = :siri_no";
    }
    $database->prepare($query);
    if (!empty($sectionId)) {
      $database->bindValue(":section_id", $sectionId);
    }
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();
    $result = $database->fetchAllAssociative();

    return $result;
  }

  public function itemsOut($sectionId, $siriNo)
  {
    $database = Database::openConnection();

    $query = "SELECT id, title, breadth, breadthtype, price, pricetype, total FROM data.items_out ";
    if (!empty($sectionId)) {
      $query .= "WHERE section_id = :section_id AND siri_no = :siri_no";
    } else {
      $query .= "WHERE siri_no = :siri_no";
    }
    $database->prepare($query);
    if (!empty($sectionId)) {
      $database->bindValue(":section_id", $sectionId);
    }
    $database->bindValue(":siri_no", $siriNo);
    $database->execute();
    $result = $database->fetchAllAssociative();

    return $result;
  }

  public function sitereview($fileId)
  {
    $database = Database::openConnection();

    $query = "SELECT * FROM data.v_semak ";
    $query .= "WHERE smk_akaun = :smk_akaun";

    $database->prepare($query);
    $database->bindValue(":smk_akaun", $fileId);
    $database->execute();

    $info = $database->fetchAllAssociative();
    return $info;
  }

  public function benchmarkinfo($id)
  {
    $database = Database::openConnection();

    $query = "SELECT b.*, m.jln_jnama, h.bgn_bnama FROM data.benchmark b ";
    $query .= "LEFT JOIN data.hbangn h on b.bgkod = h.bgn_bgkod ";
    $query .= "LEFT JOIN data.mkwjln m on b.jlkod = m.jln_jlkod ";
    $query .= "WHERE b.id = :id";

    $database->prepare($query);
    $database->bindValue(":id", Encryption::decryptId($id));
    $database->execute();

    $row = $database->fetchAssociative();
    $rowOutput = [];
    $rowOutput["id"] = $row["id"];
    $rowOutput["jenis"] = $row["jenis"];
    $rowOutput["jlkod"] = $row["jlkod"];
    $rowOutput["nmbil"] = $row["nmbil"];
    $rowOutput["bgkod"] = $row["bgkod"];
    $rowOutput["nota"] = $row["nota"];
    $rowOutput["nilai"] = $row["nilai"];
    $rowOutput["jln_jnama"] = $row["jln_jnama"];
    $rowOutput["bgn_bnama"] = $row["bgn_bnama"];
    $rowOutput["childs"] = $this->getChildsBenchMark($row["id"]);

    return $rowOutput;
  }

  public function sitereviewinfo($fileId)
  {
    $database = Database::openConnection();

    $query = "SELECT * FROM data.v_semak_raw ";
    $query .= "WHERE id = :id";

    $database->prepare($query);
    $database->bindValue(":id", Encryption::decryptId($fileId));
    $database->execute();

    $info = $database->fetchAssociative();
    return $info;
  }

  public function viewimages($fileId)
  {
    $database = Database::openConnection();

    $query = "SELECT * FROM data.files ";
    $query .= "WHERE no_akaun = :no_akaun";

    $database->prepare($query);
    $database->bindValue(":no_akaun", Encryption::decryptId($fileId));
    $database->execute();

    $info = $database->fetchAllAssociative();
    return $info;
  }

  public function viewdocuments($fileId)
  {
    $database = Database::openConnection();

    $query = "SELECT f.no_akaun, f.file_type, f.filename, f.hashed_filename, f.extension, f.datetime, d.document as doc_name FROM data.fdocs f ";
    $query .= "LEFT JOIN data.doctype d ON f.file_type = d.id ";
    $query .= "WHERE f.no_akaun = :no_akaun";

    $database->prepare($query);
    $database->bindValue(":no_akaun", Encryption::decryptId($fileId));
    $database->execute();

    $info = $database->fetchAllAssociative();
    return $info;
  }

  public function docstype()
  {
    $database = Database::openConnection();

    $query = "SELECT * FROM data.doctype";

    $database->prepare($query);
    $database->execute();

    $info = $database->fetchAllAssociative();
    return $info;
  }

  public function getAllImgs($fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT * FROM data.files ";
    $query .= "WHERE no_akaun = :no_akaun ";
    $query .= "ORDER BY files.date DESC ";

    $database->prepare($query);
    $database->bindValue(":no_akaun", Encryption::decryptId($fileId));
    $database->execute();
    $files = $database->fetchAllAssociative();

    return $files;
  }

  public function getAllDocs($fileId)
  {
    $database = Database::openConnection();
    $query = "SELECT f.id, f.no_akaun, f.file_type, f.filename, f.hashed_filename, f.description, f.extension, f.datetime, d.document as doc_name FROM data.fdocs f ";
    $query .= "LEFT JOIN data.doctype d ON f.file_type = d.id ";
    $query .= "WHERE f.no_akaun = :no_akaun";

    $database->prepare($query);
    $database->bindValue(":no_akaun", Encryption::decryptId($fileId));
    $database->execute();
    $files = $database->fetchAllAssociative();

    return $files;
  }

  public function getChildsBenchMark($id)
  {
    $database = Database::openConnection();
    $query = "SELECT b.nilai, b.nota, h.bgn_bnama FROM data.benchmark b ";
    $query .= "LEFT JOIN data.hbangn h on b.bgkod = h.bgn_bgkod ";
    $query .= "WHERE b.parent = :id ";

    $database->prepare($query);
    $database->bindValue(":id", (int) $id);
    $database->execute();

    $childs = $database->fetchAllAssociative();
    return $childs;
  }

  public function AcctInfo($fileId)
  {
    $oracleDB = Oracle::openOriConnection();

    $query = "SELECT b.*, m.jln_jnama, h.bgn_bnama FROM data.benchmark b ";
    $query .= "LEFT JOIN data.hbangn h on b.bgkod = h.bgn_bgkod ";
    $query .= "LEFT JOIN data.mkwjln m on b.jlkod = m.jln_jlkod ";
    $query .= "WHERE b.id = :id";

    $oracleDB->prepare($query);
    $oracleDB->bindValue(":id", Encryption::decryptId($fileId));
    $oracleDB->execute();

    $row = $oracleDB->fetchAssociative();
    $rowOutput = [];
    $rowOutput["id"] = $row["id"];
    $rowOutput["jenis"] = $row["jenis"];
    $rowOutput["jlkod"] = $row["jlkod"];
    $rowOutput["nmbil"] = $row["nmbil"];
    $rowOutput["bgkod"] = $row["bgkod"];
    $rowOutput["nota"] = $row["nota"];
    $rowOutput["nilai"] = $row["nilai"];
    $rowOutput["jln_jnama"] = $row["jln_jnama"];
    $rowOutput["bgn_bnama"] = $row["bgn_bnama"];
    $rowOutput["childs"] = $this->getChildsBenchMark($row["id"]);

    return $rowOutput;
  }

  public function getAcctInfo($fileId)
  {
    $dboracle = new Oracle();

    $query = "SELECT v.*, h2.TNH_TNAMA,h3.HRT_HNAMA,h4.BGN_BNAMA,h5.STB_SNAMA FROM SPMC.V_HVNDUK v ";
    $query .= "LEFT JOIN SPMC.V_HTANAH h2 ON v.PEG_THKOD = h2.TNH_THKOD ";
    $query .= "LEFT JOIN SPMC.V_HHARTA h3 ON v.PEG_HTKOD = h3.HRT_HTKOD ";
    $query .= "LEFT JOIN SPMC.V_HBANGN h4 ON v.PEG_BGKOD = h4.BGN_BGKOD ";
    $query .= "LEFT JOIN SPMC.V_HSTBGN h5 ON v.PEG_STKOD = h5.STB_STKOD ";
    $query .= "WHERE v.PEG_AKAUN = :PEG_AKAUN ";

    $dboracle->prepare($query);
    $dboracle->bindValue(":PEG_AKAUN", $fileId);
    $dboracle->execute();

    $row = $dboracle->fetchAssociative();

    return $row;
  }

  public function getReviewAcctInfo($fileId)
  {
    $database = Database::openConnection();
    $dboracle = new Oracle();

    $query = "SELECT * FROM data.v_semak_raw ";
    $query .= "WHERE id = :id ";
    $database->prepare($query);
    $database->bindValue(":id", Encryption::decryptId($fileId));
    $database->execute();

    $row = $database->fetchAssociative();

    $rowOutput = [];

    $dboracle->getByNoAcct("V_HVNDUK", "peg_akaun", $row["smk_akaun"]);
    $info = $dboracle->fetchAssociative();

    $rowOutput["id"] = Encryption::encryptId($row["id"]);
    $rowOutput["sid"] = $row["id"];
    $rowOutput["smk_akaun"] = $row["smk_akaun"];
    $rowOutput["adpg1"] = $row["smk_adpg1"];
    $rowOutput["adpg2"] = $row["smk_adpg2"];
    $rowOutput["adpg3"] = $row["smk_adpg3"];
    $rowOutput["adpg4"] = $row["smk_adpg4"];
    $rowOutput["thkod"] = $row["smk_jstnh"];
    $rowOutput["bgkod"] = $row["smk_jsbgn"];
    $rowOutput["htkod"] = $row["smk_kgtnh"];
    $rowOutput["stkod"] = $row["smk_stbgn"];
    $rowOutput["codex"] = $row["smk_codex"];
    $rowOutput["codey"] = $row["smk_codey"];
    $rowOutput["lsbgnt"] = $row["smk_lsbgn_tmbh"];
    $rowOutput["lsanst"] = $row["smk_lsans_tmbh"];

    $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
    $rowOutput["pmk_plgid"] = $info["pmk_plgid"];
    $rowOutput["peg_digit"] = $info["peg_digit"];
    $rowOutput["peg_oldac"] = $info["peg_oldac"];
    $rowOutput["peg_stcbk"] = $info["peg_stcbk"];
    $rowOutput["pmk_nmbil"] = $info["pmk_nmbil"];
    $rowOutput["peg_nolot"] = $info["peg_nolot"];
    $rowOutput["jln_jnama"] = $info["jln_jnama"];
    $rowOutput["jln_knama"] = $info["jln_knama"];
    $rowOutput["kaw_kwkod"] = $info["kaw_kwkod"];
    $rowOutput["jpk_jnama"] = $info["jpk_jnama"];
    $rowOutput["peg_jpkod"] = $info["jpk_jpkod"];
    $rowOutput["peg_nompt"] = $info["peg_nompt"];
    $rowOutput["peg_rjfil"] = $info["peg_rjfil"];
    $rowOutput["peg_pelan"] = $info["peg_pelan"];
    $rowOutput["peg_bilpk"] = $info["peg_bilpk"];
    $rowOutput["peg_rjmmk"] = $info["peg_rjmmk"];
    $rowOutput["peg_lsbgn"] = $info["peg_lsbgn"];
    $rowOutput["peg_lstnh"] = $info["peg_lstnh"];
    $rowOutput["peg_lsans"] = $info["peg_lsans"];
    if ($row["smk_jstnh"] != null) {
      $rowOutput["tnama"] = $dboracle->getElementById("SPMC.V_HTANAH", "tnh_tnama", "tnh_thkod", $row["smk_jstnh"]);
    } else {
      $rowOutput["tnama"] = $this->checkNull($row["smk_jstnh"]);
    }
    $rowOutput["htkod"] = $info["peg_htkod"];
    $rowOutput["hnama"] = $info["hrt_hnama"];
    $rowOutput["lsbgn"] = $info["peg_lsbgn"];
    $rowOutput["lstnh"] = $info["peg_lstnh"];
    $rowOutput["lsans"] = $info["peg_lsans"];
    $rowOutput["nilth_asal"] = $info["peg_nilth"];
    $rowOutput["kadar_asal"] = $info["kaw_kadar"];
    $rowOutput["cukai_asal"] = $info["peg_tksir"];
    // $rowOutput["ttl_bgn"] = $row["smk_lsbgn_tmbh"] + $info["peg_lsbgn"];
    // $rowOutput["ttl_ans"] = $row["smk_lsans_tmbh"] + $info["peg_lsans"];

    $rowOutput["workerid"] = $row["workerid"];
    $rowOutput["name"] = $row["name"];
    $rowOutput["role"] = Session::getUserRole();

    return $rowOutput;
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