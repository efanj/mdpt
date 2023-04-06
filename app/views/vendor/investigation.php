<div class="page-content sidebar-page clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <div class="row">
        <div class="col-lg-8 col-sm-8 col-md-8">
          <?php $info = $this->controller->account->getAccountInfo($fileId); ?>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4>SEMAKAN - DESKTOP</h4>
            </div>
            <div class="panel-body">
              <form method="post" id="form-semak-desktop">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>No.IC / Daftar Syarikat :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["pmk_plgid"] ?>" name="plgid"
                        readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama Dibil :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["pmk_nmbil"] ?>" name="nmbil"
                        readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>No. Akaun :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["peg_akaun"] ?>" name="noAkaun"
                        readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>No. Lot :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["peg_nolot"] ?>" name="noLot"
                        readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>No. PT :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["peg_nompt"] ?>" name="noPT"
                        readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Alamat</label>
                      <input type="text" class="form-control input-sm round" name="adpg1"
                        value="<?= $info["adpg1"] ?>" />
                      <input type="hidden" name="jlkod" value="<?= $info["jln_jlkod"] ?>" />
                      <input type="hidden" name="kwkod" value="<?= $info["jln_kwkod"] ?>" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Jalan</label>
                      <input type="text" class="form-control input-sm round" name="adpg2"
                        value="<?= $info["adpg2"] ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Daerah/Kawasan</label>
                      <input type="text" class="form-control input-sm round" name="adpg3"
                        value="<?= $info["adpg3"] ?>" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Negeri</label>
                      <input type="text" class="form-control input-sm round" name="adpg4"
                        value="<?= $info["adpg4"] ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="tanah">Kegunaan Tanah</label>
                      <input type="hidden" name="tnama" value="<?= $info["peg_thkod"] ?>">
                      <input type="text" class="form-control input-sm round" id="tnama"
                        value="<?= $info["tnh_tnama"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="bangunan">Jenis Bangunan</label>
                      <input type="hidden" name="bnama" value="<?= $info["peg_bgkod"] ?>">
                      <input type="text" class="form-control input-sm round" id="bnama"
                        value="<?= $info["bgn_bnama"] ?>" readonly />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="hartanah">Kegunaan Hartanah</label>
                    <input type="hidden" name="hnama" value="<?= $info["peg_htkod"] ?>">
                    <input type="text" class="form-control input-sm round" id="hnama" value="<?= $info["hrt_hnama"] ?>"
                      readonly />
                  </div>
                  <div class="col-sm-6">
                    <label for="struktur">Struktur Bangunan</label>
                    <input type="hidden" name="snama" value="<?= $info["peg_stkod"] ?>">
                    <input type="text" class="form-control input-sm round" id="snama" value="<?= $info["stb_snama"] ?>"
                      readonly />
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="kadar">Kadar</label>
                      <input type="text" class="form-control input-sm round" id="kadar"
                        value="<?= $info["kaw_kadar"] ?>" readonly />
                    </div>
                    <div class="col-sm-6">
                      <label for="nilth">Nilai Tahunan</label>
                      <input type="text" class="form-control input-sm round" id="nilth"
                        value="<?= $info["peg_nilth"] ?>" readonly />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Luas Tanah :</label>
                      <input class="form-control input-sm" type="number" value="<?= $info["peg_lstnh"] ?>" name="lstnh"
                        min="0" value="0" step=".01">
                    </div>
                    <div class="col-md-4">
                      <label>Luas Bangunan :</label>
                      <input class="form-control input-sm" type="number" value="<?= $info["peg_lsbgn"] ?>" name="lsbgn"
                        min="0" value="0" step=".01">
                    </div>
                    <div class="col-md-4">
                      <label>Luas Ansolari :</label>
                      <input class="form-control input-sm" type="number" value="<?= $info["peg_lsans"] ?>" name="lsans"
                        min="0" value="0" step=".01">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Luas Bangunan Tamb. :</label>
                      <input class="form-control input-sm" type="number" value="" name="lsbgn_tamb" min="0" value="0"
                        step=".01">
                    </div>
                    <div class="col-md-4">
                      <label>Luas Ansolari Tamb. :</label>
                      <input class="form-control input-sm" type="number" value="" name="lsans_tamb" min="0" value="0"
                        step=".01">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>koordinat X :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["peg_codex"] ?>" name="codex"
                        id="codex" required>
                    </div>
                    <div class="col-md-6">
                      <label>koordinat Y :</label>
                      <input class="form-control input-sm" type="text" value="<?= $info["peg_codey"] ?>" name="codey"
                        id="codey" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                      <label>Catatan :</label>
                      <textarea class="form-control limitTextarea" maxlength="250" rows="3" name="catatan"
                        id="catatan"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row mt20">
                  <div class="col-md-12 tar">
                    <button type="submit" class="btn btn-square btn-primary btn-sm"><i class="icon-save"></i> Simpan
                      Rekod</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4">
          <div id="mapView" class="mapView"></div>
        </div>
      </div>
      <!-- End .row -->
    </div>
    <!-- End .page-content-inner -->
  </div>
  <!-- / page-content-wrapper -->
</div>