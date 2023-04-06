function format(d) {
  // `d` is the original data object for the row
  return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;">' + "<tr><td><b>Sebab-sebab : </b></td></tr>" + "<tr><td><b>Sebab-sebab : </b></td></tr></table >"
}
var evaluation = $("#evaluationlist").DataTable({
  pageLength: 50,
  lengthMenu: [
    [50, 100, 200, 500],
    [50, 100, 200, 500]
  ],
  processing: true,
  serverSide: true,
  searching: true,
  serverMethod: "post",
  ajax: "evaluationtable",
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
        if (type === "display") {
          data = row.no_akaun + "</br>" + row.no_siri
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
          data = row.pmk_nmbil + "<br/>"
          data += row.adpg1 + "<br/>"
          if (row.adpg2 != null) {
            data += row.adpg2 + "<br/>"
          }
          if (row.adpg3 != null) {
            data += row.adpg3 + "<br/>"
          }
          if (row.adpg4 != null) {
            data += row.adpg4 + "<br/>"
          }
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
          data = row.peg_nolot + "</br>" + row.peg_nompt + "</br>" + row.pmk_hkmlk
        }
        return data
      }
    },
    {
      targets: 4,
      orderable: false,
      data: "peg_lsbgn"
    },
    {
      targets: 5,
      orderable: false,
      data: "peg_lstnh"
    },
    {
      targets: 6,
      orderable: false,
      data: "peg_nilth"
    },
    {
      targets: 7,
      orderable: false,
      data: "nilth_baru"
    },
    {
      targets: 8,
      orderable: false,
      data: "peg_tksir"
    },
    {
      targets: 9,
      orderable: false,
      data: "cukai_baru"
    },
    {
      targets: 10,
      orderable: false,
      data: "kaw_kadar"
    },
    {
      targets: 11,
      orderable: false,
      data: "kadar_baru"
    }
  ],
  order: [[2, "asc"]],
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
$("#evaluationlist tbody").on("click", "td.details-control", function () {
  var tr = $(this).closest("tr")
  var row = evaluation.row(tr)

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
$("#evaluationlist tbody").css("font-size", 13)

$("#print_submit").click(function () {
  var url = config.root + "Printing/datanilaiansemula"
  window.open(url, "_blank")
})
