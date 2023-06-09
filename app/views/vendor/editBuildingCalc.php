<div class="page-content clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4">
          <?php $info = $this->controller->informations->getCalcInfo($siriNo); ?>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4>MAKLUMAT PEGANGAN</h4>
            </div>
            <div class="panel-body s13">
              <div class="row mb5">
                <div class="col-md-6 s13"><label class="control-label tal">No. Akaun</label> : <?= $info["no_akaun"] ?>
                </div>
                <div class="col-md-6 s13"><label class="control-label tal">IC Pemilik</label> : <?= $info["plgid"] ?>
                </div>
              </div>
              <div class="row mb5">
                <dv class="col-md-12 s13"><label class="control-label tal">Nama Pemilik</label> : <?= $info["nmbil"] ?>
                </dv>
              </div>
              <div class="row mb5">
                <div class="col-md-12 s13"><label class="control-label tal">Alamat Harta</label> :
                  <?php
                  if ($info["adpg1"] != "") {
                    echo $info["adpg1"] . ", ";
                  }
                  if ($info["adpg2"] != "" && $info["adpg2"] != "-") {
                    echo $info["adpg2"] . ", ";
                  }
                  if ($info["adpg3"] != "" && $info["adpg3"] != "-") {
                    echo $info["adpg3"] . ", ";
                  }
                  if ($info["adpg4"] != "" && $info["adpg4"] != "-") {
                    echo $info["adpg4"];
                  }
                  ?>
                </div>
              </div>
              <div class="row mb5">
                <div class="col-md-6 s13"><label class="control-label tal">Kegunaan Tanah</label> :
                  <?= $info["tnama"]; ?>
                </div>
                <div class="col-md-6 s13"><label class="control-label tal">Kegunaan Hartanah</label> :
                  <?= $info["hnama"]; ?></div>
              </div>
              <div class="row mb5">
                <div class="col-md-4 s13"><label class="control-label tal">Luas Tanah</label> :
                  <?= $info["lstnh"] . " mp"; ?></div>
                <div class="col-md-4 s13"><label class="control-label tal">Luas Bangunan</label> :
                  <?= $info["lsbgn"] . " mp"; ?></div>
                <div class="col-md-4 s13"><label class="control-label tal">Luas Ansolari</label> :
                  <?= $info["lsans"] . " mp"; ?></div>
              </div>
              <div class="row">
                <div class="col-md-4 s13"><label class="control-label tal">Nilai Tahunan</label> :
                  <?= "RM " . $info["nilth_asal"] ?></div>
                <div class="col-md-4 s13"><label class="control-label tal">Kadar</label> :
                  <?= $info["kadar_asal"] . " %"; ?></div>
                <div class="col-md-4 s13"><label class="control-label tal">Cukai Tahunan</label> :
                  <?= "RM " . $info["cukai_asal"] ?></div>
              </div>
              <input type="hidden" id="kwkod" value="<?= $info['kwkod']; ?>">
              <input type="hidden" id="htkod" value="<?= $info['htkod']; ?>">
            </div>
          </div>
          <!-- <div class="panel">
            <div class="panel-body">
              <div class="mapSideView" id="mapSideView"></div>
            </div>
          </div> -->
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4>NILAIAN - BANGUNAN</h4>
            </div>
            <div class="panel-body">
              <div id="edit-calc-building" class="bwizard">
                <!-- Start .bwizard -->
                <ul class="bwizard-steps">
                  <li class="active">
                    <a href="#tab1" data-toggle="tab">
                      <span class="step-number">1</span>
                      <span class="step-text">Perbandingan & Tanah</span>
                    </a>
                  </li>
                  <li>
                    <a href="#tab2" data-toggle="tab">
                      <span class="step-number">2</span>
                      <span class="step-text">Bangunan Utama</span>
                    </a>
                  </li>
                  <li>
                    <a href="#tab3" data-toggle="tab">
                      <span class="step-number">3</span>
                      <span class="step-text">Bangunan Luar</span>
                    </a>
                  </li>
                  <li>
                    <a href="#tab4" data-toggle="tab">
                      <span class="step-number">4</span>
                      <span class="step-text">Pengiraan</span>
                    </a>
                  </li>
                </ul>
                <form class="form-horizontal" role="form" id="editCalcBuilding" method="post">
                  <input type="hidden" name="akaun" value="<?= $info["no_akaun"] ?>">
                  <input type="hidden" name="siri_no" value="<?= $info["siri_no"] ?>">
                  <div class="tab-content">
                    <div class=" tab-pane active" id="tab1">
                      <div class="page-header">
                        <h4><strong>PERBANDINGAN</strong></h4>
                      </div>
                      <button id="add-comparison" class="btn btn-primary btn-sm mb5" type="button">Add row</button>
                      <table class="table table-bordered comparison" style="font-size:13px;">
                        <thead>
                          <tr>
                            <th></th>
                            <th style="width:20%">Nama Taman</th>
                            <th style="width:15%">Jenis Bangunan</th>
                            <th>Keluasan</th>
                            <th style="width:10%">Nilai Tahunan</th>
                            <th style="width:15%">Sewa SMP(MFA)</th>
                            <th style="width:15%">Sewa SMP(AFA)</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="comparison_table">
                          <?php foreach ($info['comparison'] as $row) { ?>
                            <tr id="0">
                              <td><button class="btn btn-primary btn-xs" id="add" type="button"><i class="fa fa-plus"></i></button></td>
                              <td>
                                <input type="hidden" name="comparison[]" id="comparison" value="<?= $row['id'] ?>">
                                <div class='control-label tal' id='jlname'><?= $row['jln_jnama'] ?></div>
                              </td>
                              <td>
                                <div class='control-label tal' id='bgtype'><?= $row['bgn_bnama'] ?></div>
                              </td>
                              <td>
                                <div class='control-label tal' id='breadth'><?= $row['peg_lsbgn'] ?></div>
                              </td>
                              <td>
                                <div class='control-label tal' id='nilth'><?php echo "RM " . $row['peg_nilth'] ?></div>
                              </td>
                              <td>
                                <div class='control-label tal' id='mfa'><?php echo "RM " . $row['mfa'] ?></div>
                              </td>
                              <td>
                                <div class='control-label tal' id='afa'><?php echo "RM " . $row['afa'] ?></div>
                              </td>
                              <td><button class="btn btn-danger btn-xs" id="delete" type="button"><i class="fa fa-trash"></i></button></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                      <div class="page-header">
                        <h4><strong>TANAH</strong></h4>
                      </div>
                      <table class="table table-bordered land">
                        <thead>
                          <tr>
                            <th style="width:30%"></th>
                            <th style="width:15%">Keluasan</th>
                            <th style="width:10%">Jenis</th>
                            <th></th>
                            <th style="width:15%">Nilai Unit</th>
                            <th style="width:10%">Jenis</th>
                            <th style="width:15%">Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                            <td><input type="number" class="form-control input-sm" name="breadth_land" id="breadth_land" min="0" value="<?= $info['land']["breadth"] ?>"></td>
                            <td>mp</td>
                            <td style="text-align:center">X</td>
                            <td><input type="number" class="form-control input-sm" name="price_land" id="price_land" min="0" value="<?= $info['land']["price"] ?>"></td>
                            <td>smp</td>
                            <td><input type="number" class="form-control input-sm ttl_partly" id="total_land" value="<?= $info['land']["total"] ?>" readonly>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="tab2">
                      <div class="page-header">
                        <h4><strong>BANGUNAN UTAMA</strong></h4>
                      </div>
                      <button id="add-section-one" class="btn btn-success btn-sm mb5" type="button">Add
                        Section</button>
                      <hr>
                      <div class="section_one">
                        <?php foreach ($info['mfa'] as $section) { ?>
                          <section id="<?= $section['id'] ?>">
                            <div class="form-group">
                              <label class="col-lg-2 col-md-3 control-label tal"><strong>Perkara</strong></label>
                              <div class="col-lg-10 col-md-9">
                                <input type="hidden" name="section_one[<?= $section['id'] ?>][id]" value="<?= $section['id'] ?>">
                                <input type="text" class="form-control input-sm" name="section_one[<?= $section['id'] ?>][main_title]" value="<?= $section['title'] ?>">
                              </div>
                            </div>
                            <button id="0" class="btn btn-primary btn-sm add-one" type="button">Add Row</button>
                            <table class="table table-bordered one" id="zero" style="font-size:13px;">
                              <thead>
                                <tr>
                                  <th style="width:30%">Perkara</th>
                                  <th style="width:15%">Keluasan/Kuantiti</th>
                                  <th style="width:10%">Jenis</th>
                                  <th></th>
                                  <th style="width:15%">Nilai Unit</th>
                                  <th style="width:10%">Jenis</th>
                                  <th style="width:15%">Jumlah</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="zero">
                                <?php foreach ($section['items'] as $row) { ?>
                                  <tr id="<?= $row['id'] ?>">
                                    <td>
                                      <input type="hidden" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][id]" value="<?= $row['id'] ?>">
                                      <input type="text" class="form-control input-sm" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][title_one]" value="<?= $row['title'] ?>">
                                    </td>
                                    <td><input type="number" class="form-control input-sm" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][breadth_one]" id="breadth_one" min="0" value="<?= $row["breadth"] ?>"></td>
                                    <td>
                                      <select class="form-control input-sm" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][breadthtype_one]">
                                        <option value="">Sila Pilih</option>
                                        <option value="mp" <?php if ($row["breadthtype"] == "mp") {
                                                              echo "selected";
                                                            } ?>>Meter
                                        </option>
                                        <option value="ft" <?php if ($row["breadthtype"] == "ft") {
                                                              echo "selected";
                                                            } ?>>Kaki</option>
                                        <option value="unit" <?php if ($row["breadthtype"] == "unit") {
                                                                echo "selected";
                                                              } ?>>Unit</option>
                                        <option value="petak" <?php if ($row["breadthtype"] == "petak") {
                                                                echo "selected";
                                                              } ?>>Petak</option>
                                      </select>
                                    </td>
                                    <td style="text-align:center">X</td>
                                    <td><input type="number" class="form-control input-sm" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][price_one]" id="price_one" min="0" value="<?= $row['price'] ?>"></td>
                                    <td>
                                      <select class="form-control input-sm" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][pricetype_one]">
                                        <option value="">Sila Pilih</option>
                                        <option value="smp" <?php if ($row["pricetype"] == "smp") {
                                                              echo "selected";
                                                            } ?>>Meter Persegi</option>
                                        <option value="sft" <?php if ($row["pricetype"] == "sft") {
                                                              echo "selected";
                                                            } ?>>Kaki Persegi</option>
                                        <option value="p/unit" <?php if ($row["pricetype"] == "p/unit") {
                                                                  echo "selected";
                                                                } ?>>Per-Unit</option>
                                        <option value="sepetak" <?php if ($row["pricetype"] == "sepetak") {
                                                                  echo "selected";
                                                                } ?>>Sepetak</option>
                                      </select>
                                    </td>
                                    <td><input type="number" class="form-control input-sm" name="section_one[<?= $section['id'] ?>][item][<?= $row['id'] ?>][total_one]" id="total_one" value="<?= $row['total'] ?>" readonly></td>
                                    <td></td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </section>
                        <?php } ?>
                      </div>
                      <table class="table mb10">
                        <tbody>
                          <tr>
                          <tr>
                            <td style="width:25%"></td>
                            <td style="width:15%"></td>
                            <td style="width:10%"></td>
                            <td></td>
                            <td style="width:15%"></td>
                            <td style="width:15%">Jumlah</td>
                            <td colspan="2">
                              <div class="input-group input-group-sm">
                                <span class="input-group-addon">RM</span>
                                <input type="text" class="form-control input-sm ttl_partly" id="overall_one" value="<?= $info['totalmfa']; ?>" readonly>
                              </div>
                            </td>

                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="tab3">
                      <div class="page-header">
                        <h4><strong>BANGUNAN LUAR</strong></h4>
                      </div>
                      <button id="add-section-two" class="btn btn-success btn-sm mb5" type="button">Add
                        Section</button>
                      <hr>
                      <div class="section_two">
                        <?php foreach ($info['afa'] as $section2) { ?>
                          <section id="<?= $section2['id']; ?>">
                            <div class="form-group">
                              <label class="col-lg-2 col-md-3 control-label tal"><strong>Perkara</strong></label>
                              <div class="col-lg-10 col-md-9">
                                <input type="hidden" name="section_two[<?= $section2['id']; ?>][id]" value="<?= $section2['id'] ?>">
                                <input type="text" class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][external_title]" value="<?= $section2['title']; ?>">
                              </div>
                            </div>
                            <button id="0" class="btn btn-primary btn-sm add-two" type="button">Add Row</button>
                            <table class="table table-bordered two" id="zero" style="font-size:13px;">
                              <thead>
                                <tr>
                                  <th style="width:30%">Perkara</th>
                                  <th style="width:15%">Keluasan/Kuantiti</th>
                                  <th style="width:10%">Jenis</th>
                                  <th></th>
                                  <th style="width:15%">Nilai Unit</th>
                                  <th style="width:10%">Jenis</th>
                                  <th style="width:15%">Jumlah</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="zero">
                                <?php foreach ($section2['items'] as $row) { ?>
                                  <tr id="<?= $row['id'] ?>">
                                    <td>
                                      <input type="hidden" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][id]" value="<?= $row['id'] ?>">
                                      <input type="text" class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][title_two]" value="<?= $row['title'] ?>">
                                    </td>
                                    <td><input type="number" class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][breadth_two]" id="breadth_two" min="0" value="<?= $row['breadth'] ?>"></td>
                                    <td>
                                      <select class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][breadthtype_two]">
                                        <option value="">Sila Pilih</option>
                                        <option value="mp" <?php if ($row["breadthtype"] == "mp") {
                                                              echo "selected";
                                                            } ?>>Meter</option>
                                        <option value="ft" <?php if ($row["breadthtype"] == "ft") {
                                                              echo "selected";
                                                            } ?>>Kaki</option>
                                        <option value="unit" <?php if ($row["breadthtype"] == "unit") {
                                                                echo "selected";
                                                              } ?>>Unit</option>
                                        <option value="petak" <?php if ($row["breadthtype"] == "petak") {
                                                                echo "selected";
                                                              } ?>>Petak</option>
                                      </select>
                                    </td>
                                    <td style="text-align:center">X</td>
                                    <td><input type="number" class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][price_two]" min="0" id="price_two" value="<?= $row['price'] ?>"></td>
                                    <td>
                                      <select class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][pricetype_two]">
                                        <option value="">Sila Pilih</option>
                                        <option value="smp" <?php if ($row["pricetype"] == "smp") {
                                                              echo "selected";
                                                            } ?>>Meter Persegi</option>
                                        <option value="sft" <?php if ($row["pricetype"] == "sft") {
                                                              echo "selected";
                                                            } ?>>Kaki Persegi</option>
                                        <option value="p/unit" <?php if ($row["pricetype"] == "p/unit") {
                                                                  echo "selected";
                                                                } ?>>Per-Unit</option>
                                        <option value="sepetak" <?php if ($row["pricetype"] == "sepetak") {
                                                                  echo "selected";
                                                                } ?>>Sepetak</option>
                                      </select>
                                    </td>
                                    <td><input type="number" class="form-control input-sm" name="section_two[<?= $section2['id']; ?>][item][<?= $row['id'] ?>][total_two]" id="total_two" value="<?= $row['total'] ?>" readonly></td>
                                    <td></td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </section>
                        <?php } ?>
                      </div>
                      <table class="table mb10">
                        <tbody>
                          <tr>
                          <tr>
                            <td style="width:25%"></td>
                            <td style="width:15%"></td>
                            <td style="width:10%"></td>
                            <td></td>
                            <td style="width:15%"></td>
                            <td style="width:15%">Jumlah</td>
                            <td colspan="2">
                              <div class="input-group input-group-sm">
                                <span class="input-group-addon">RM</span>
                                <input type="text" class="form-control input-sm ttl_partly" value="<?= $info['totalafa']; ?>" id="overall_two" readonly>
                              </div>
                            </td>

                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="tab4">
                      <div class="page-header">
                        <h4><strong>PENGIRAAN</strong></h4>
                      </div>
                      <table style="width:100%;font-size:13px;" class="calculator mb15">
                        <tr>
                          <td style="width:80%" colspan="2"><strong>ANGGARAN SEWA BULANAN</strong></td>
                          <td style="width:20%">
                            <input type="hidden" name="rental" id="rental" value="<?= $info['rental']; ?>">
                            RM <span class="control-label tal" id="dummy_rental"><?= $info['rental']; ?></span>
                          </td>
                        </tr>
                        <tr>
                          <td style="width:65%"></td>
                          <td>
                            <div class="input-group input-group-sm">
                              <input type="number" class="form-control input-sm" name="discount" id="discount" placeholder="Diskaun" value="<?= $info['discount']; ?>">
                              <span class=" input-group-addon">%</span>
                            </div>
                          </td>
                          <td>
                            RM <span class="control-label tal" id="dummy_discount">
                              <?php if ($info['discount'] < 1) {
                                echo $info['rental'];
                              } else if ($info['discount'] == "" || $info['discount'] == 0 || $info['discount'] >= 1) {
                                echo $info['rental'] - ($info['rental'] * ($info['discount'] / 100));
                              }
                              ?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>SEWA BULANAN DIGENAPKAN</strong></td>
                          <td>
                            <div class="input-group input-group-sm">
                              <span class="input-group-addon">RM</span>
                              <input type="number" class="form-control input-sm" name="even" id="even" value="<?= $info['even']; ?>">
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>TEMPOH TAHUNAN</strong></td>
                          <td>X 12 BULAN</td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>NILAI TAHUNAN</strong></td>
                          <td>
                            <input type="hidden" name="yearly" id="yearly" value="<?= $info['yearly_price']; ?>">
                            RM <span class="control-label tal" id="dummy_yearly"><?= $info['yearly_price']; ?></span>
                          </td>
                        </tr>
                        <tr>
                          <td><strong>KADAR</strong></td>
                          <td>
                            <button type="button" class="btn btn-default btn-sm" id="update_rate">Kemaskini</button>
                          </td>
                          <td>
                            <div class="input-group input-group-sm">
                              <input type="number" class="form-control input-sm" name="rate" id="rate" value="<?= $info["rate"] ?>">
                              <span class=" input-group-addon">%</span>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>CUKAI TAKSIRAN</strong></td>
                          <td>
                            <input type="hidden" name="tax" id="tax" value="<?= $info["assessment_tax"] ?>">
                            <strong>RM</strong> <span class="control-label tal bold" id="dummy_tax"><?= $info["assessment_tax"] ?></span>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </form>
                <ul class="pager">
                  <li class="previous"><a href="#">&larr; Sebelumnya</a>
                  </li>
                  <li class="next"><a href="#">Seterusnya &rarr;</a>
                  </li>
                  <li class="next finish" style="display:none;"><a href="#">Kemaskini</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="comparison_popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xlg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title">SENARAI DATA PERBANDINGAN</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered" id="popup_comparison" width="100%">
            <thead>
              <tr>
                <th></th>
                <th>Nama Jalan</th>
                <th>Jenis Bangunan</th>
                <th>Keluasan</th>
                <th>Nilai Tahunan</th>
                <th>Sewa SMP(MFA)</th>
                <th>Sewa SMP(AFA)</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>