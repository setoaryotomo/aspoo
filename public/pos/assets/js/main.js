var url = "./penjualan/api.php",
  dataPenjualan,
  arrData = [],
  deletedData = [],
  i = 0,
  dataObat;

function editObatPenjualan(arr) {
  $.post(
    url,
    {
      id: arr,
      request: "dataObat",
    },
    (data, status, xhr) => {
      dataObat = data;
      $("#obat-selected").html(
        data.obat_kode +
          " | " +
          data.obat_nama +
          " | Rp. " +
          data.obat_harga_jual
      );
    }
  );
}

function hapusTr(it) {
  if (parseInt(it) != 0) it--;
  if (typeof arrData[it].penjualan_child_id != "undefined")
    deletedData.push(arrData[it]);
  delete arrData[it];
  $("#tr_" + it).remove();
  arrData = $.grep(arrData, (n) => {
    return n == 0 || n;
  });
  countTotal();
}

function countTotal() {
  var total = 0;
  for (x in arrData) total += parseInt(arrData[x].subtotal);
  $("#total").val(total);
  kembali();
}
function kembali() {
  $("#kembali").val(parseInt($("#bayar").val()) - parseInt($("#total").val()));
}

$(document).ready(() => {
  $("#buat_data").click(() => {
    dataObat["jumlah_data"] = $("#jumlah").val();
    dataObat["subtotal"] =
      parseInt(dataObat.jumlah_data) * parseInt(dataObat.obat_harga_jual);
    // tambah ke table
    $("#bodyTable").append(`
            <tr id="tr_${i++}">
                <td>${i}</td>
                <td>${dataObat.obat_nama}</td>
                <td>${dataObat.satuan_nama}</td>
                <td>${dataObat.jumlah_data}</td>
                <td>${dataObat.obat_harga_jual}</td>
                <td>${dataObat.subtotal}</td>
                <td><button type="button" class="btn btn-danger" onclick="hapusTr('${i}')">Hapus</button></td>
            </tr>
        `);
    arrData.push(dataObat);
    $("#obat-selected").html("Pilih Obat");
    $("#jumlah").val("");
    countTotal();
  });

  $("#bayar").keyup(() => {
    kembali();
  });

  $("#simpan_data").click(() => {
    dataPenjualan = {
      id_pelanggan: $("#pelanggan option:selected").val(),
      total: $("#total").val(),
      bayar: $("#bayar").val(),
      kembali: $("#kembali").val(),
    };
    var retr = {
      request: "kirimData",
      penjualan: dataPenjualan,
      obat: arrData,
    };
    $("#allData").val(JSON.stringify(retr));
    $("#kirim").submit();
  });
});
