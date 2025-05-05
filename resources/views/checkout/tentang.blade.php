<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Toko Susu Bahagia - Tentang</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff5f9;
            color: #333;
        }

        header {
            background: linear-gradient(to bottom, #ffeef5, #fff);
            padding: 50px 20px;
            text-align: center;
            position: relative;
        }

        header h1 {
            color: #003087;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }

        .btn-toko {
            background-color: #003087;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }

        .babies-img {
            position: absolute;
            right: 20px;
            bottom: 10px;
            width: 150px;
        }

        section {
            text-align: center;
            padding: 40px 20px;
        }

        section h2 {
            color: #003087;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .about-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .about-container img {
            width: 200px;
            height: auto;
        }

        .about-text {
            max-width: 450px;
            text-align: left;
            font-size: 1rem;
            line-height: 1.6;
        }

        .chat-section {
            background-color: #e0f0ff;
            padding: 30px 20px;
            text-align: center;
        }

        .chat-section p {
            font-size: 1.2rem;
            font-weight: bold;
            color: #003087;
            margin-bottom: 15px;
        }

        .btn-chat {
            background-color: white;
            border: 2px solid #003087;
            color: #003087;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }

    </style>
</head>

<body>

    {{-- <header>
        <h1>Toko Susu Bahagia</h1>
        <p>Tumbuh Sehat dengan Susu Terbaik!<br> Dukung pertumbuhan si kecil dan kesehatan keluarga dengan susu segar
            penuh nutrisi.</p>
        <a href="#" class="btn-toko">Toko</a>
        <img src="{{ asset('assets/images/bg-bby2.png') }}" alt="Baby Image" class="babies-img">
    </header> --}}

    <div class="clouds"></div>
{{-- 
    <section>
        <h2>Tentang Toko Susu Bahagia</h2>
        <div class="about-container">
            <img src="{{ asset('assets/images/furniture.png') }}" alt="Produk Pampers">
            <div class="about-text">
                <p>Toko Susu Bahagia terletak di Cibarusah Mutiara Bekasi Jaya blok J1/28, Cikarang. Toko ini telah
                    berdiri sejak tahun 2017 dan menjadi pilihan utama bagi para orang tua yang mencari perlengkapan
                    bayi dengan kualitas terbaik.</p>
                <p>Di Toko Susu Bahagia, tersedia berbagai kebutuhan bayi seperti susu formula, popok, makanan bayi, dan
                    perlengkapan mandi. Kami selalu mengutamakan pemenuhan kebutuhan si kecil dengan pelayanan yang
                    ramah dan harga yang bersaing.</p>
                <p>Kunjungi kami dan temukan produk terbaik untuk buah hati Anda!</p>
            </div>
        </div>
    </section> --}}

    <div class="chat-section">
        <p>Ada Pertanyaan? Hubungi Kami!</p>
        <a href="#" class="btn-chat">Klik untuk Chat</a>
    </div>

    <div class="footer-wave"></div>

</body>

</html>
