<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartASPOO</title>
    <link rel="icon" href="{{ URL::asset('/img/portal/android-chrome-512x512.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <style>

        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #FBD9C0;
            font-weight: 600;
            display: flex;
            flex-wrap: inherit;
            align-items: center;
            justify-content: flex-start;
        }

        .navbar>.container,
        .navbar>.container-fluid,
        .navbar>.container-lg,
        .navbar>.container-md,
        .navbar>.container-sm,
        .navbar>.container-xl,
        .navbar>.container-xxl {
            display: flex;
            flex-wrap: inherit;
            align-items: center;
            justify-content: flex-start;
            font-weight: bolder;
        }

        .arrow-icon {
            font-size: 28px;
            color: #000;
            background: none;
            border: none;
            padding: 0;
        }

        .status-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

    .container {
        margin-top: 20px;
        margin-bottom: 50px;
    }

    .product-detail {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        background-color: #F0F0F0;
        padding: 20px;
        border-radius: 10px;
    }

    .imageproduk {
        max-width: 200px;
        margin-right: 20px;
    }
        .shipment-details {
            margin-left: 60px;
        }

        .shipment-info {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .shipment-info2 {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 50px;
        }

        .resi {
            font-family: 'Poppins', sans-serif;
            font-weight: bolder;
        }

        .rigth-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-left: 20px;
        }

        .btn-text-primary {
            color: #196CE9;
            border: none;
            padding-left: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .section-divider {
            border-top: 2px solid #000000;
            margin-top: 50px;
            margin-bottom: 60px;
        }

        .timeline {
            position: relative;
        }

        .timeline-item {
            position: relative;
            padding-left: 50px;
            margin-bottom: 30px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #000000;
        }

        .timeline-content {
            margin-left: 40px;
        }

        .timeline-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 20px;
        }

        .timeline-time {
            position: absolute;
            left: -100px;
            top: 0;
            font-size: 14px;
            font-weight: 500;
        }

        .timeline-description {
            font-size: 16px;
        }

        .timeline-divider {
            position: absolute;
            left: 10px;
            top: 20px;
            height: calc(100%);
            border-left: 2px solid #000000;
        }

        .timeline::before{
            display: none;
        }
    </style>
</head>

<body>


    <div class="container">
        <div class="product-detail">
            <img class="imageproduk" src="{{ $data['image_product'] }}" alt="Product Image">
            <div class="shipment-info">
                <div>{{ $data['keterangan'] }}</div>
                <br>
                <div>Dikirim menggunakan &emsp;: &emsp;{{ $data['kurir'] }}</div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="shipment-info2">
            <div class="resi">Nomor Resi</div>
            <div class="rigth-info">
                <div>{{ $data['resi'] }}</div>
                <button id="salinResi" class="btn btn-text-primary">Salin</button>
            </div>
        </div>
        <div class="section-divider"></div>
        @if (isset($data['pengiriman']))
            @foreach ($data['pengiriman'] as $timeline)
                <?php
                if (intval($timeline['status']) > 10) {
                    $teks = 'color:red;';
                } else {
                    $teks = 'color: black;';
                }
                $mysqlTimestamp = $timeline['created_at'];
                $date = new DateTime($mysqlTimestamp, new DateTimeZone('UTC'));
                
                // Set the timezone to Indonesia
                $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
                
                // Format the date as per your requirements
                $dateInIndonesia = $date->format('d M Y ');
                ?>
                <div class="shipment-details">
                    <div class="shipment-details">
                        <div class="timeline">
                            <div class="timeline-divider"></div>
                            <div class="timeline-item">
                                <div class="timeline-time" style="{{ @$teks }}">{{ @$dateInIndonesia }}</div>
                                <div class="timeline-content">
                                    <div class="timeline-number" style="{{ @$teks }}">
                                        {{ @$timeline['status_readable'] }}</div>
                                    <div class="timeline-description" style="{{ @$teks }}">
                                        {{ @$timeline['keterangan'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
        <script>
            new ClipboardJS('#salinResi', {
                text: function() {
                    return "{{ $data['resi'] }}";
                }
            });
            document.getElementById('salinResi').addEventListener('click', function() {
                alert('Nomor Resi telah disalin ke clipboard.');
            });
        </script>


</body>

</html>
