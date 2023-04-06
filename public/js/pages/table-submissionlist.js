jQuery(function () {
  var table = $("#submitdatereview").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    info: false,
    serverMethod: "post",
    ajax: "submitiondatareviews",
    columnDefs: [
      {
        targets: 0,
        orderable: false,
        data: "id"
      },
      {
        targets: 1,
        orderable: false,
        data: "reference"
      },
      {
        targets: 2,
        orderable: false,
        data: "submition_date"
      },
      {
        targets: 3,
        orderable: false,
        data: "items"
      }
    ],
    select: {
      style: "single"
    },
    order: [[0, "asc"]],
    language: {
      search: "Saring : ",
      lengthMenu: "Paparkan _MENU_ rekod",
      zeroRecords: "Tiada maklumat yang dijumpai",
      info: "Memaparkan _START_ sehingga _END_ rekod daripada _TOTAL_ rekod",
      infoEmpty: "Tiada rekod",
      infoFiltered: "(Ditapis daripada _MAX_ rekod)",
      paginate: {
        first: "Pertama",
        last: "Terakhir",
        next: "Seterus",
        previous: "Sebelum"
      }
    }
  })
  table.columns([3]).visible(false)

  $("#submitdatereview tbody").on("click", "tr", function () {
    $("#print_submit").prop("disabled", false)
    var d = table.row(this).data()
    submitionDataReview(d.id)
  })

  $("#print_submit").click(function () {
    var selectdate = table.rows({ selected: true }).data()
    var date = selectdate[0].submition_date
    console.log(date)
    var newDate = date.replace(/[^\w\s]/gi, "")
    var url = config.root + "Printing/datasubmition/" + newDate
    window.open(url, "_blank")
  })

  function format(d) {
    // `d` is the original data object for the row
    return (
      '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;">' +
      "<tr>" +
      "<td width='10%' style='background-color: #f4f5f5;'><b>Nama Bil:</b></td>" +
      "<td width='15%'>" +
      d.pmk_nmbil +
      "</td>" +
      "<td width='10%' style='background-color: #f4f5f5;'><b>ID/No. Syarikat:</b></td>" +
      "<td width='15%'>" +
      d.pmk_plgid +
      "</td>" +
      "<td width='10%' style='background-color: #f4f5f5;'><b>No. Hakmilik:</b></td>" +
      "<td width='15%'>" +
      d.pmk_hkmlk +
      "</td>" +
      "<td width='10%' style='background-color: #f4f5f5;'><b>No. PT:</b></td>" +
      "<td width='15%'>" +
      d.smk_nompt +
      "</td>" +
      "</tr>" +
      "<tr>" +
      "<td style='background-color: #f4f5f5;'><b>Alamat:</b></td>" +
      "<td>" +
      d.smk_adpg1 +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Alamat:</b></td>" +
      "<td>" +
      d.smk_adpg2 +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Alamat:</b></td>" +
      "<td>" +
      d.smk_adpg3 +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Alamat:</b></td>" +
      "<td>" +
      d.smk_adpg4 +
      "</td>" +
      "</tr>" +
      "<tr>" +
      "<td style='background-color: #f4f5f5;'><b>Jalan:</b></td>" +
      "<td>" +
      d.jln_jnama +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Kawasan:</b></td>" +
      "<td>" +
      d.jln_kname +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>No. Pelan:</b></td>" +
      "<td>" +
      d.peg_pelan +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Rujukan MMK:</b></td>" +
      "<td>" +
      d.peg_rjmmk +
      "</td>" +
      "</tr>" +
      "<tr>" +
      "<td style='background-color: #f4f5f5;'><b>Kegunaan Tanah:</b></td>" +
      "<td>" +
      d.tnh_tnama +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Jenis Bangunan:</b></td>" +
      "<td>" +
      d.bgn_bnama +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Kegunaan Hartanah:</b></td>" +
      "<td>" +
      d.hrt_hnama +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Struktur Bangunan:</b></td>" +
      "<td>" +
      d.stb_snama +
      "</td>" +
      "</tr>" +
      "<tr>" +
      "<td style='background-color: #f4f5f5;'><b>Nilai Tahunan:</b></td>" +
      "<td>RM " +
      d.peg_nilth +
      "</td>" +
      "<td style='background-color: #f4f5f5;'><b>Kadar:</b></td>" +
      "<td>" +
      d.kaw_kadar +
      "%</td>" +
      "<td style='background-color: #f4f5f5;'><b>Cukai Tahunan:</b></td>" +
      "<td>RM " +
      d.peg_tksir +
      "</td>" +
      "<td style='background-color: #f4f5f5;'></td>" +
      "<td>" +
      "</td>" +
      "</tr>" +
      "</table>"
    )
  }
  function submitionDataReview(date) {
    var submitsitereview = $("#submitsitereview").DataTable({
      pageLength: 50,
      lengthMenu: [
        [50, 100, 200, 500],
        [50, 100, 200, 500]
      ],
      scrollY: "60vh",
      scrollCollapse: true,
      processing: true,
      serverSide: true,
      searching: true,
      ajax: {
        url: "submitsitereviewtable",
        type: "POST",
        data: function (d) {
          return $.extend({}, d, {
            date: date
          })
        }
      },
      columnDefs: [
        {
          width: "3%",
          targets: 0,
          className: "details-control",
          orderable: false,
          data: null,
          defaultContent: ""
        },
        {
          targets: 1,
          orderable: false,
          data: null,
          render: function (data, type, row, meta) {
            // console.log(row);
            if (type === "display") {
              data = row.smk_akaun + "<br>" + row.smk_nolot + "<br>"
            }
            return data
          }
        },
        {
          targets: 2,
          orderable: false,
          data: null,
          render: function (data, type, row, meta) {
            if (type === "display") {
              data = row.smk_lsbgn + " m&sup2; <br>" + row.smk_lstnh + " m&sup2; <br>" + row.smk_lsans + " m&sup2;"
            }
            return data
          }
        },
        {
          targets: 3,
          orderable: false,
          data: null,
          render: function (data, type, row, meta) {
            if (type === "display") {
              data = row.smk_lsbgn_tmbh + " m&sup2; <br>" + row.smk_lsans_tmbh + " m&sup2;"
            }
            return data
          }
        },
        {
          targets: 4,
          orderable: false,
          data: null,
          render: function (data, type, row, meta) {
            if (type === "display") {
              data = row.hadapan + "<br>" + row.belakang
            }
            return data
          }
        },
        {
          targets: 5,
          orderable: false,
          data: null,
          render: function (data, type, row, meta) {
            if (type === "display") {
              data = row.smk_datevisit + "</br>" + row.smk_timevisit
            }
            return data
          }
        },
        {
          targets: 6,
          orderable: false,
          data: null,
          render: function (data, type, row, meta) {
            // console.log(row.smk_stspn)
            if (type === "display") {
              if (row.smk_stspn === 2) {
                data = "<span class='label label-primary'>Telah Serah</span>"
              }
              if (row.smk_stspn === 3) {
                data = "<span class='label label-success'>Diterima</span>"
              }
              if (row.smk_stspn === 4) {
                data = "<span class='label label-danger'>Semak Semula</span>"
              }
              if (row.smk_stspn === 5) {
                data = "<span class='label label-primary'>Serah Semula</span>"
              }
            }
            return data
          }
        },
        {
          targets: 7,
          orderable: false,
          className: "dt-body-center",
          data: null,
          render: function (data, type, row, meta) {
            if (type === "display") {
              data = '<div class="btn-group btn-group-xs" role="group">'
              if (row.sirino != "-") {
                data += '<a href="' + row.calctype + "/" + row.sirino + '" class="btn btn-success btn-xs" title="Borang Nilaian"><i class="fa fa-calculator"></i></a>'
              } else {
                data += '<a href="' + row.calctype + "/" + row.id + '" class="btn btn-default btn-xs" title="Borang Nilaian"><i class="fa fa-calculator"></i></a>'
              }
              data += '<a href="viewimages/' + row.id + '" class="btn '
              if (row.file != null) {
                data += "btn-success"
              } else {
                data += "btn-default"
              }
              data += ' btn-xs" title="Gambar"><i class="fa fa-file-photo-o"></i></a>'
              data += '<a href="viewdocuments/' + row.id + '" class="btn '
              if (row.doc != null) {
                data += "btn-success"
              } else {
                data += "btn-default"
              }
              data += ' btn-xs" title="Dokumen"><i class="fa fa-file-pdf-o"></i></a>'
              data += "</div>"
            }
            return data
          }
        }
      ],
      select: {
        style: "multi"
      },
      order: [[5, "asc"]],
      language: {
        search: "Saring : ",
        lengthMenu: "Paparkan _MENU_ rekod",
        zeroRecords: "Tiada maklumat yang dijumpai",
        info: "Memaparkan _START_ sehingga _END_ rekod daripada _TOTAL_ rekod",
        infoEmpty: "Tiada rekod",
        infoFiltered: "(Ditapis daripada _MAX_ rekod)",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Seterus",
          previous: "Sebelum"
        }
      }
    })

    // Add event listener for opening and closing details
    $("#submitsitereview tbody").on("click", "td.details-control", function () {
      var tr = $(this).closest("tr")
      var row = submitsitereview.row(tr)

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide()
        tr.removeClass("shown")
      } else {
        // Open this row
        row.child(format(row.data())).show()
        tr.addClass("shown")
      }
    })

    $("#form-verifylists").on("submit", function (e) {
      $("#submit_popup").modal("show")
      var form = this
      var rows_selected = table.column(0).checkboxes.selected()
      console.log(rows_selected)
      // $.each(rows_selected, function (index, rowId) {
      //   data += rowId
      // })
      var data = rows_selected.join(",")
      $("#id").val(data)

      // Prevent actual form submission
      e.preventDefault()
    })

    $("body").on("click", ".edit-area", function () {
      $("#luas_popup").modal("show")
      var row = $(this).parents("tr")[0]
      var rowindex = $(this).closest("tr").index()
      var rowval = table.row(row).data()

      $("#index").val(rowindex)
      $("#id").val(rowval.id)
      $("#akaun").val(rowval.akaun)
      console.log(rowindex)
      // console.log(table.row(row).data())
    })

    $("#submitsitereview").css("font-size", 13)
  }

  $("#submitionareareview").submit(function (e) {
    e.preventDefault()
    var data = $("#submitionareareview").serialize()
    var index = this.index
    var lsbgn = this.lsbgn
    var lsans = this.lsans

    // console.log(index.value)
    $.ajax({
      url: config.root + "vendor/updatebreadth",
      type: "post",
      dataType: "json",
      data: data
    }).done(function (result) {
      // console.log(result.success)
      if (result === true) {
        $("#submitionareareview")[0].reset()
        $("#luas_popup").modal("hide")
        $("#sitereviews").DataTable().ajax.reload()
        swal("Berjaya", "Kemaskini keluasan, telah Berjaya direkodkan.", "success")
      } else {
        $("#luas_popup").modal("hide")
        swal("Oops...", "Kemaskini keluasan, tidak berjaya direkodkan!", "error")
      }
    })
  })
  // $("#sitereviews tbody").on("click", "#remove", function () {
  //   var data = table.row($(this).parents("tr")).data()
  //   alert(data[0] + "'s salary is: " + data[5])
  // })

  // $("#sitereviews tbody tr td #remove").click(function (e) {
  //   e.preventDefault()
  //   if (!confirm("Are you sure?")) {
  //     return
  //   }

  //   var row = $(this).parent().parent()
  //   var fileId = row.attr("id")

  //   ajax.send("Vendor/deletesitereview", { file_id: fileId }, deleteFileCallBack)
  //   function deleteFileCallBack(result) {
  //     if (helpers.validateData(result, row, "after", "row", "success")) {
  //       $(row).remove()
  //     }
  //   }
  // })
})
