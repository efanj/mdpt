<div class="page-content sidebar-page clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <?php $kws = $this->controller->elements->area(); ?>
      <div class="row">
        <div class="col-lg-3 col-sm-3 col-md-3">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row align-items-center">
                <div class="col">
                  <h4 class="ml15">MAKLUMAT SERAHAN</h4>
                </div>
                <!--end col-->
                <div class="col-auto">
                  <button class="btn btn-default btn-sm mt5 mr15" id="print_submit" disabled><i
                      class="glyphicon glyphicon-print"></i></button>
                </div>
                <!--end col-->
              </div>
            </div>
            <div class="panel-body">
              <table id="submitdatereview" class="table table-bordered" style="width:100%;">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Rujukan</th>
                    <th>Tarikh</th>
                    <th></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-sm-9 col-md-9">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4>SENARAI SERAHAN NILAIAN SEMULA</h4>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <form role="form" id="form-verifylists">
                  <table id="submitsitereview" class="table table-bordered" style="width:100%;">
                    <thead>
                      <tr>
                        <th></th>
                        <th>
                          No. Akaun <br />
                          No. Lot
                        </th>
                        <th>
                          Luas Bangunan(mp) <br />
                          Luas Tanah(mp) <br />
                          Luas Ansolari(mp)
                        </th>
                        <th>
                          Luas Bgn Tamb.(mp) <br />
                          Luas Ans Tamb.(mp)
                        </th>
                        <th width="15%">
                          Catatan Hadapan <br />
                          Catatan Belakang
                        </th>
                        <th>Tarikh Lawatan</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </form>
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

<div class="modal fade" id="submit_popup" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" id="submitionreview">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">SERAHAN DATA</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputEmail6" class="col-sm-4 control-label">Jalan / Taman</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control input-sm" id="inputEmail6">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputEmail6" class="col-sm-4 control-label">Tarikh</label>
                <div class="col-sm-8">

                </div>
              </div>
            </div>
          </div>
          <div class="row mt5">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputEmail6" class="col-sm-4 control-label">Kegunaan</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control input-sm" id="inputEmail6">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputEmail6" class="col-sm-4 control-label">Kaedah</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control input-sm" id="inputEmail6">
                </div>
              </div>
            </div>
          </div>
          <div class="row mt5">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inputPassword5" class="col-sm-12 control-label">Pilihan Data</label>
                <div class="col-sm-12">
                  <textarea class="form-control" rows="3" id="id" readonly></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>