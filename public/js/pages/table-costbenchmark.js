var account = $("#account").DataTable({
  processing: true,
  serverSide: true,
  searching: false,
  ajax: {
    url: "../elements/acctTable",
    type: "POST",
    data: function (d) {
      return $.extend({}, d, {
        area: $("#area").val()
      })
    }
  },
  select: "single",
  columns: [
    {
      targets: 0,
      orderable: true,
      data: "peg_akaun"
    },
    {
      targets: 1,
      orderable: false,
      data: "pmk_nmbil"
    },
    {
      targets: 2,
      orderable: false,
      data: "jln_jnama"
    },
    {
      targets: 3,
      orderable: false,
      data: "jln_knama"
    },
    {
      targets: 4,
      orderable: false,
      data: "hrt_hnama"
    },
    {
      target: 5,
      visible: false,
      orderable: false,
      data: "jln_jlkod"
    },
    {
      target: 6,
      visible: false,
      orderable: false,
      data: "jln_kwkod"
    },
    {
      target: 7,
      visible: false,
      orderable: false,
      data: "peg_htkod"
    }
  ],
  order: [[0, "asc"]],
  language: {
    search: "Saring : ",
    lengthMenu: "Paparkan _MENU_ rekod",
    zeroRecords: "Tiada maklumat yang dijumpai",
    info: "Memaparkan _START_ sehingga _END_ rekod daripada _TOTAL_ rekod",
    infoEmpty: "Tiada rekod",
    paginate: {
      first: "Pertama",
      last: "Terakhir",
      next: "Seterus",
      previous: "Sebelum"
    }
  }
})
account.columns([5, 6, 7]).visible(false)

$("#account").css("font-size", 13)

$("#account tbody").on("click", "tr", function () {
  var data = account.row(this).data()
  console.log(data)
  $("#akaun").val(data.peg_akaun)
  $("#dummy_akaun").val(data.peg_akaun)
  $("#pemilik").val(data.pmk_nmbil)
  $("#jlkod").val(data.jln_jlkod)
  $("#dummy_jlkod").val(data.jln_jnama)
  $("#kwkod").val(data.jln_kwkod)
  $("#dummy_kwkod").val(data.jln_knama)
  $("#htkod").val(data.peg_htkod)
  $("#dummy_htkod").val(data.hrt_hnama)

  $("#akaun_popup").modal("toggle")
})

$(document).ready(function () {
  account.draw()

  $("#filter").bind("click", function () {
    var area = $("#area").val()
    if (area != "") {
      account.draw()
      $("#akaun_popup").modal("show")
    } else {
      alert("Select filter option")
      account.draw()
    }
  })

  function format(data) {
    var child = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;">'
    $.each(data, function (i, item) {
      child += "<tr>"
      child += "<td style='width:3.5%'></td>"
      child += "<th width='17%'></td>"
      child += "<th width='18%'></td>"
      child += "<td style='width:18%'>"
      child += "- " + item.bgn_bnama + "<br>- " + item.bgside
      child += "</td>"
      child += "<td style='width:8.3%'>RM " + item.nilai + "</td>"
      child += "<td style='width:20%'>" + item.nota + "</td>"
      child += "<td style='width:9%'><a class='btn btn-danger btn-xs remove' title='Padam' id='remove' data-id='" + item.id + "'><i class='fa fa-trash'></i></a></td>"
      child += "</tr>"
    })
    child += "</table>"
    return child
  }
  var benchmark = $("#cost-benchmark").DataTable({
    pageLength: 5,
    lengthMenu: [
      [5, 15, 25, 50],
      [5, 15, 25, 50]
    ],
    processing: true,
    serverSide: true,
    searching: false,
    serverMethod: "post",
    ajax: "costbenchmarktable",
    select: "single",
    columnDefs: [
      {
        targets: 0,
        className: "details-control",
        orderable: false,
        data: null,
        defaultContent: ""
      },
      {
        targets: 1,
        searchable: false,
        orderable: false,
        data: null,
        render: function (data, type, row, meta) {
          // console.log(row);
          if (type === "display") {
            data = row.kws_knama
          }
          return data
        }
      },
      {
        targets: 2,
        orderable: false,
        data: null,
        render: function (data, type, row, meta) {
          // console.log(row);
          if (type === "display") {
            data = row.hrt_hnama
          }
          return data
        }
      },
      {
        targets: 3,
        orderable: false,
        data: null,
        render: function (data, type, row, meta) {
          // console.log(row);
          if (type === "display") {
            data = row.bgn_bnama + "</br>"
            data += row.bgside
          }
          return data
        }
      },
      {
        targets: 4,
        orderable: false,
        data: null,
        render: function (data, type, row, meta) {
          // console.log(row);
          if (type === "display") {
            data = "RM " + row.nilai
          }
          return data
        }
      },
      {
        targets: 5,
        orderable: false,
        data: "nota"
      },
      {
        targets: 6,
        orderable: false,
        data: null,
        render: function (data, type, row, meta) {
          // console.log(data);
          if (type === "display") {
            data = '<div class="btn-group btn-group-xs" role="group">'
            data += '<a href="viewbenchmark/' + row.id + '" class="btn btn-default btn-sm" title="Dokumen"><i class="fa fa-file color-dark"></i></a>'
            data += '<a class="btn btn-danger btn-xs remove" title="Padam" id="remove" data-id="' + row.id + '"><i class="fa fa-trash"></i></a>'
            data += "</div>"
          }
          return data
        }
      }
    ],
    order: [[1, "asc"]],
    language: {
      search: "Saring : ",
      lengthMenu: "Paparkan _MENU_ rekod",
      zeroRecords: "Tiada maklumat yang dijumpai",
      info: "Memaparkan _START_ sehingga _END_ rekod daripada _TOTAL_ rekod",
      infoEmpty: "Tiada rekod",
      paginate: {
        first: "Pertama",
        last: "Terakhir",
        next: "Seterus",
        previous: "Sebelum"
      }
    }
  })

  $("#cost-benchmark tbody").on("click", "td.details-control", function () {
    var tr = $(this).closest("tr")
    var row = benchmark.row(tr)

    if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide()
      tr.removeClass("shown")
    } else {
      // Open this row
      row.child(format(row.data().childs)).show()
      tr.addClass("shown")
    }
  })

  $("#cost-benchmark").css("font-size", 13)

  $("#form-cost-benchmark").submit(function (e) {
    e.preventDefault()
    ajax.send("Vendor/insertcostbenchmark", helpers.serialize(this), costBenchMarkCallBack)
  })
  function costBenchMarkCallBack(result) {
    if (result.success === true) {
      swal(
        {
          title: "Berjaya!",
          text: "Telah berjaya direkodkan, Sila muatnaik dokumen sokongan.",
          icon: "success",
          button: true
        },
        function () {
          $("#cost-benchmark").DataTable().ajax.reload()
        }
      )
    } else {
      swal("Oops...", "Tidak berjaya direkodkan!", "error")
    }
  }

  $("body").on("click", "#remove", function (e) {
    e.preventDefault()
    // console.log($(this).data("id"))
    ajax.send("Vendor/deletecostbenchmark", { id: $(this).data("id") }, rentBenchMarkCallBack)
  })
  function rentBenchMarkCallBack(result) {
    if (result.success === true) {
      swal(
        {
          title: "Berjaya!",
          text: "Telah berjaya dipadamkan.",
          icon: "success",
          button: true
        },
        function () {
          // benchmark.row.add([counter + ".1", counter + ".2", counter + ".3", counter + ".4", counter + ".5"]).draw()
          $("#rent-benchmark").DataTable().ajax.reload()
        }
      )
    } else {
      swal("Oops...", "Tidak berjaya dipadamkan!", "error")
    }
  }
})
