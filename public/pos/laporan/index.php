<?php require '../config.php';
middleware();
$title = 'Laporan';
?>
<?php $active[8] = 'active' ?>
<?php include('../templates/sidebar.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <!-- Tambahkan sebelum script lainnya -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .custom-card {
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            color: white;
            text-align: center;
        }
        .uang-masuk {
            background: linear-gradient(135deg, #4CAF50, #81C784);
        }
        .uang-keluar {
            background: linear-gradient(135deg, #F44336, #E57373);
        }
        .uang-piutang {
            background: linear-gradient(135deg, #FF9800, #FFB74D);
        }
        .total-uang {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
        .sale-card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-left: 4px solid #4CAF50;
        }
        .sale-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sale-body {
            padding: 15px;
        }
        .sale-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }
        .sale-total {
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 10px;
            text-align: right;
        }
        .customer-name {
            font-weight: bold;
            color: #333;
        }
        .sale-time {
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="main-panel bgMain fadeIn animated">
    <div class="container" style="padding-top: 10px;">
        <!-- Summary Cards -->
        <div class="laporan-uang mb-4" style="display: none;">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="custom-card uang-masuk">
                        <h3><i class="fas fa-money-bill-wave mr-2"></i>Uang Penjualan</h3>
                        <p class="total-uang" id="uang_masuk">Rp. 0</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="custom-card uang-keluar">
                        <h3><i class="fas fa-cart-arrow-down mr-2"></i>Uang Pembelian</h3>
                        <p class="total-uang" id="uang_keluar">Rp. 0</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="custom-card uang-piutang">
                        <h3><i class="fas fa-hand-holding-usd mr-2"></i>Uang Piutang</h3>
                        <p class="total-uang" id="uang_piutang">Rp. 0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-group">
                    <label for="tanggal"><i class="fas fa-calendar-alt mr-2"></i>Pilih Tanggal Laporan</label>
                    <input type="date" class="form-control tanggal" id="tanggal" value='<?php echo date('Y-m-d'); ?>'>
                </div>
            </div>
        </div>


        <!-- Sales Report -->
        <div class="card">
            <div class="card-header card-header-primary card-header-bg">
                <h4 class="card-title"><i class="fas fa-chart-line mr-2"></i>Laporan Penjualan</h4><button id="exportPdf" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            </div>
            
            <div class="card-body">
            
                <div id="sales-container">
                    <!-- Sales will be loaded here -->
                </div>
            </div>
        </div>

        <!-- Purchase Report (hidden by default) -->
        <div class="card mt-4" id="purchase-section" style="display: none;">
            <div class="card-header card-header-primary card-header-bg">
                <h4 class="card-title"><i class="fas fa-shopping-cart mr-2"></i>Laporan Pembelian</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pembelian_table" class="table">
                        <thead class="text-primary">
                            <th>No</th>
                            <th>Nama Supplier</th>
                            <th>Nomor Faktur</th>
                            <th>Jumlah</th>
                            <th>Option</th>
                        </thead>
                        <tbody id="laporan_pembelian">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../templates/footer.php') ?>
<script>
    function formatNumber(num) {
        if (num != null) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        } else {
            return 0
        }
    }

    function formatDateTime(datetime) {
        const date = new Date(datetime);
        return date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
    }

    $(document).ready(() => {
        run();

        $('#tanggal').change(() => {
            clean();
            run();
        });
    });

    function run() {
    const selectedDate = $("#tanggal").val();
    console.log("Mengambil data untuk tanggal:", selectedDate);
    $(document).on('click', '#exportPdf', function() {
    const tanggal = $('#tanggal').val();
    const fileName = `Laporan_Penjualan_${tanggal}.pdf`;
    
    const pdf = new jsPDF('p', 'pt', 'a4');
    const margin = 40;
    let yPos = margin;
    
    // Header
    pdf.setFontSize(18);
    pdf.setTextColor(40);
    pdf.text('LAPORAN PENJUALAN', pdf.internal.pageSize.getWidth()/2, yPos, {align: 'center'});
    yPos += 30;
    
    pdf.setFontSize(12);
    pdf.text(`Tanggal: ${tanggal}`, pdf.internal.pageSize.getWidth()/2, yPos, {align: 'center'});
    yPos += 50;
    
    // Ambil data dari card yang ditampilkan
    $('.card.mb-4').each(function(index) {
        const id = $(this).find('.card-header span:first').text().trim();
        const date = $(this).find('.card-header span:last').text().trim();
        const total = $(this).find('tr.table-active td:last').text().trim();
        
        // Judul transaksi
        pdf.setFont(undefined, 'bold');
        pdf.text(`${id} - ${date}`, margin, yPos);
        yPos += 30;
        
        // Item transaksi
        pdf.setFont(undefined, 'normal');
        $(this).find('tbody tr:not(.table-active)').each(function() {
            if (yPos > pdf.internal.pageSize.getHeight() - 50) {
                pdf.addPage();
                yPos = margin;
            }
            
            const cols = $(this).find('td');
            const itemText = `${cols.eq(0).text().trim()} - ${cols.eq(1).text().trim()} ${cols.eq(2).text().trim()} (${cols.eq(3).text().trim()})`;
            pdf.text(itemText, margin + 10, yPos);
            yPos += 20;
        });
        
        // Total transaksi
        pdf.setFont(undefined, 'bold');
        // pdf.text(`Total: ${total}`, margin, yPos);
        yPos += 40;
        
        // Garis pemisah
        pdf.line(margin, yPos, pdf.internal.pageSize.getWidth() - margin, yPos);
        yPos += 30;
    });
    
    // Total keseluruhan
    pdf.setFontSize(14);
    pdf.text(`Total Penjualan: ${$('#uang_masuk').text()}`, margin, yPos);
    
    // Simpan PDF
    pdf.save(fileName);
});
    // Tampilkan loading
    $('#sales-container').html(`
        <div class="text-center py-4">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p>Memuat data laporan...</p>
        </div>
    `);

    $.ajax({
        url: "./laporan/api.php",
        method: "POST",
        data: {
            request: 'ambilData',
            hari: selectedDate,
            user_id: <?php echo $_SESSION['data']['id']; ?>
        },
        dataType: 'json',
        success: function(data) {
            console.log("Data diterima:", data);
            
            if (!data || !data.penjualan) {
                $('#sales-container').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Format data tidak valid
                    </div>
                `);
                return;
            }

            // Update summary
            $('#uang_masuk').text("Rp " + formatNumber(data.uang_masuk.uang_masuk || 0));
            
            // Tampilkan data penjualan
            if (data.penjualan.length > 0) {
                let html = '';
                data.penjualan.forEach((transaction, index) => {
                    const transactionDate = new Date(transaction.penjualan_dibuat).toLocaleString('id-ID');
                    
                    // Parse items
                    let itemsHtml = '';
                    if (transaction.items) {
                        transaction.items.split('||').forEach(itemStr => {
                            const [nama, jumlah, harga] = itemStr.split('|');
                            const total = parseInt(jumlah) * parseInt(harga);
                            itemsHtml += `
                                <tr>
                                    <td>${nama || 'Unknown'}</td>
                                    <td class="text-right">${formatNumber(jumlah)}</td>
                                    <td class="text-right">Rp ${formatNumber(harga)}</td>
                                    <td class="text-right">Rp ${formatNumber(total)}</td>
                                </tr>
                            `;
                        });
                    }

                    html += `
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <i class="fas fa-receipt"></i> Transaksi #${transaction.penjualan_id}
                                    </span>
                                    <span>${transactionDate}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th class="text-right">Jumlah</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${itemsHtml}
                                        <tr class="table">
                                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                                            <td class="text-right"><strong>Rp ${formatNumber(transaction.penjualan_total_harga)}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                });
                
                $('#sales-container').html(html);
            } else {
                $('#sales-container').html(`
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Tidak ada transaksi pada ${new Date(selectedDate).toLocaleDateString('id-ID')}
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", status, error);
            $('#sales-container').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> Gagal memuat data: ${error}
                </div>
            `);
        }
    });
}

    function clean() {
        $('#uang_masuk').html("Rp. 0");
        $('#uang_keluar').html("Rp. 0");
        $('#uang_piutang').html("Rp. 0");
        $('#sales-container').html("");
        $('#laporan_pembelian').html("");
        $('#purchase-section').hide();
    }
</script>

<script>
        // Inisialisasi jsPDF
        const { jsPDF } = window.jspdf;
    </script>
</body>
</html>