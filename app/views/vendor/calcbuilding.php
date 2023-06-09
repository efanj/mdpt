<div class="page-content sidebar-page clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4">
          <?php $info = $this->controller->informations->getReviewAcctInfo($reviewId); ?>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4>MAKLUMAT PEGANGAN</h4>
            </div>
            <div class="panel-body s12">
              <div class="row mb5">
                <div class="col-md-6 s13"><label class="control-label tal">No. Akaun</label> : <?= $info["smk_akaun"] ?>
                </div>
                <div class="col-md-6 s13"><label class="control-label tal">IC Pemilik</label> :
                  <?= $info["pmk_plgid"] ?>
                </div>
              </div>
              <div class="row mb5">
                <dv class="col-md-12 s13"><label class="control-label tal">Nama Pemilik</label> :
                  <?= $info["pmk_nmbil"] ?>
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
              <input type="hidden" id="kwkod" value="<?= $info['kaw_kwkod']; ?>">
              <input type="hidden" id="htkod" value="<?= $info['htkod']; ?>">
            </div>
          </div>
          <div class="panel">
            <div class="panel-body">
              <div class="mapSideView" id="mapSideView"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4>NILAIAN - BANGUNAN</h4>
            </div>
            <div class="panel-body">
              <div id="calc-building" class="bwizard">
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
                <form class="form-horizontal" role="form" id="calcBuilding" method="post">
                  <input type="hidden" name="akaun" value="<?= $info["smk_akaun"] ?>">
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
                          <tr id="0">
                            <td><button class="btn btn-primary btn-xs" id="add" type="button"><i class="fa fa-plus"></i></button></td>
                            <td>
                              <input type="hidden" name="comparison[]" id="comparison_0">
                              <div class='control-label tal' id='jlname_0'></div>
                            </td>
                            <td>
                              <div class='control-label tal' id='bgtype_0'></div>
                            </td>
                            <td>
                              <div class='control-label tal' id='breadth_0'></div>
                            </td>
                            <td>
                              <div class='control-label tal' id='nilth_0'></div>
                            </td>
                            <td>
                              <div class='control-label tal' id='mfa_0'></div>
                            </td>
                            <td>
                              <div class='control-label tal' id='afa_0'></div>
                            </td>
                            <td><button class="btn btn-danger btn-xs" id="delete" type="button"><i class="fa fa-trash"></i></button></td>
                          </tr>
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
                            <td><input type="number" class="form-control input-sm" name="breadth_land" id="breadth_land" min="0" value="<?= $info["lstnh"] ?>"></td>
                            <td>mp</td>
                            <td style="text-align:center">X</td>
                            <td><input type="number" class="form-control input-sm" name="price_land" id="price_land" min="0" value="0"></td>
                            <td>smp</td>
                            <td><input type="number" class="form-control input-sm ttl_partly" id="total_land" readonly>
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
                        <section id="0">
                          <div class="form-group">
                            <label class="col-lg-2 col-md-3 control-label tal"><strong>Perkara</strong></label>
                            <div class="col-lg-10 col-md-9">
                              <input type="text" class="form-control input-sm" name="section_one[0][main_title]">
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
                              <tr id="0">
                                <td><input type="text" class="form-control input-sm" name="section_one[0][item][0][title_one]"></td>
                                <td><input type="number" class="form-control input-sm" name="section_one[0][item][0][breadth_one]" id="breadth_one" min="0" value="<?= $info["lsbgn"] ?>"></td>
                                <td>
                                  <select class="form-control input-sm" name="section_one[0][item][0][breadthtype_one]">
                                    <option value="">Sila Pilih</option>
                                    <option value="mp" selected>Meter</option>
                                    <option value="ft">Kaki</option>
                                    <option value="unit">Unit</option>
                                    <option value="petak">Petak</option>
                                  </select>
                                </td>
                                <td style="text-align:center">X</td>
                                <td><input type="number" class="form-control input-sm" name="section_one[0][item][0][price_one]" id="price_one" min="0" value="0"></td>
                                <td>
                                  <select class="form-control input-sm" name="section_one[0][item][0][pricetype_one]">
                                    <option value="">Sila Pilih</option>
                                    <option value="smp" selected>Meter Persegi</option>
                                    <option value="sft">Kaki Persegi</option>
                                    <option value="p/unit">Per-Unit</option>
                                    <option value="sepetak">Sepetak</option>
                                  </select>
                                </td>
                                <td><input type="number" class="form-control input-sm" name="section_one[0][item][0][total_one]" id="total_one" readonly></td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </section>
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
                                <input type="text" class="form-control input-sm ttl_partly" id="overall_one" readonly>
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
                        <section id="0">
                          <div class="form-group">
                            <label class="col-lg-2 col-md-3 control-label tal"><strong>Perkara</strong></label>
                            <div class="col-lg-10 col-md-9">
                              <input type="text" class="form-control input-sm" name="section_two[0][external_title]">
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
                              <tr id="0">
                                <td><input type="text" class="form-control input-sm" name="section_two[0][item][0][title_two]" value=""></td>
                                <td><input type="number" class="form-control input-sm" name="section_two[0][item][0][breadth_two]" id="breadth_two" min="0" value="<?= $info["lsans"] ?>"></td>
                                <td>
                                  <select class="form-control input-sm" name="section_two[0][item][0][breadthtype_two]">
                                    <option value="">Sila Pilih</option>
                                    <option value="mp" selected>Meter</option>
                                    <option value="ft">Kaki</option>
                                    <option value="unit">Unit</option>
                                    <option value="petak">Petak</option>
                                  </select>
                                </td>
                                <td style="text-align:center">X</td>
                                <td><input type="number" class="form-control input-sm" name="section_two[0][item][0][price_two]" min="0" id="price_two" value="0"></td>
                                <td>
                                  <select class="form-control input-sm" name="section_two[0][item][0][pricetype_two]">
                                    <option value="">Sila Pilih</option>
                                    <option value="smp" selected>Meter Persegi</option>
                                    <option value="sft">Kaki Persegi</option>
                                    <option value="p/unit">Per-Unit</option>
                                    <option value="sepetak">Sepetak</option>
                                  </select>
                                </td>
                                <td><input type="number" class="form-control input-sm" name="section_two[0][item][0][total_two]" id="total_two" readonly></td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </section>
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
                                <input type="text" class="form-control input-sm ttl_partly" id="overall_two" readonly>
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
                            <input type="hidden" name="rental" id="rental">
                            RM <span class="control-label tal" id="dummy_rental"></span>
                          </td>
                        </tr>
                        <tr>
                          <td style="width:65%"></td>
                          <td>
                            <div class="input-group input-group-sm">
                              <input type="number" class="form-control input-sm" name="discount" id="discount" placeholder="Diskaun">
                              <span class=" input-group-addon">%</span>
                            </div>
                          </td>
                          <td>
                            RM <span class="control-label tal" id="dummy_discount"></span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>SEWA BULANAN DIGENAPKAN</strong></td>
                          <td>
                            <div class="input-group input-group-sm">
                              <span class="input-group-addon">RM</span>
                              <input type="number" class="form-control input-sm" name="even" id="even">
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
                            <input type="hidden" name="yearly" id="yearly">
                            RM <span class="control-label tal" id="dummy_yearly"></span>
                          </td>
                        </tr>
                        <tr>
                          <td><strong>KADAR</strong></td>
                          <td>
                            <button type="button" class="btn btn-default btn-sm" id="update_rate">Kemaskini</button>
                          </td>
                          <td>
                            <div class="input-group input-group-sm">
                              <input type="number" class="form-control input-sm" name="rate" id="rate" value="<?= $info["kadar_asal"] ?>">
                              <span class=" input-group-addon">%</span>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>CUKAI TAKSIRAN</strong></td>
                          <td>
                            <input type="hidden" name="tax" id="tax">
                            <strong>RM</strong> <span class="control-label tal bold" id="dummy_tax"></span>
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
                  <li class="next finish" style="display:none;"><a href="#">Simpan</a>
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
    <div class="modal-dialog modal-lg">
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