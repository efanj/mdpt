<div class="page-content sidebar-page clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <?php $kws = $this->controller->elements->area(); ?>
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
          <div class="panel panel-mdpt">
            <div class="panel-heading">
              <h4>SENARAI NILAIAN SEMULA</h4>
            </div>
            <div class="panel-body">
              <div class="row mb10">
                <div class="col-lg-6 col-sm-6 col-md-6 tal pl15">
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 tar pr15">
                  <form class="form-inline" role="form">
                    <button type="button" class="btn btn-info btn-sm btn-alt ml30" id="print"><i class="fa fa-print"></i>
                      Cetak</button> |
                    <div class="form-group">
                      <select class="form-control input-sm" name="area" id="area">
                        <option selected value="">Sila Pilih Kawasan</option>
                        <?php foreach ($kws as $row) { ?>
                          <option value="<?= $row["kws_kwkod"] ?>"><?= $row["kws_knama"] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <select class="form-control input-sm" name="street" id="street" style="width:100%">
                        <option selected value="">Sila Pilih Jalan</option>
                      </select>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="filter"><i class="fa  fa-search"></i>
                      Saring</button>
                  </form>
                </div>
              </div>
              <div class="table-responsive">
                <table id="reviewlists" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Jadual</th>
                      <th>
                        No. Akaun<br />
                        No. Siri
                      </th>
                      <th>
                        Tarikh Mesyuarat<br />
                        Tarikh Kuatkuasa
                      </th>
                      <th>
                        Kegunaan Tanah<br />
                        Jenis Bangunan<br />
                        Kegunaan Hartanah<br />
                        Struktur Bangunan
                      </th>
                      <th>
                        Nilai Tahunan Asal<br />
                        Kadar Tahunan Asal<br />
                        Cukai Taksiran Asal
                      </th>
                      <th>
                        Nilai Tahunan Baru<br />
                        Kadar Tahunan Baru<br />
                        Cukai Taksiran Baru
                      </th>
                      <th>Perbezaan</th>
                      <th>Sebab-Sebab / Catatan</th>
                      <th>Status</th>
                      <th>
                        Pegawai Pendaftar<br />
                        Pegawai Pengesah
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End .row -->
    </div>
    <!-- End .page-content-inner -->
  </div>
  <!-- / page-content-wrapper -->
</div>