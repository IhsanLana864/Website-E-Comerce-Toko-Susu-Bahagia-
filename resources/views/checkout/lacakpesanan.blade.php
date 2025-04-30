<!-- Box Input ID Pesanan -->
<form action="{{ route('tracking.show') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div style="background-color: #cceeff;
                border: 2px solid #0099ff;
                border-radius: 8px;
                padding: 20px;
                max-width: 950px;
                margin: auto;
                display: flex;
                align-items: center;
                gap: 20px;
                flex-wrap: wrap;">

        <label for="order_id" style="font-weight: bold; color: #003366; min-width: 100px;">
            ID Pesanan:
        </label>

        <input type="text" id="order_id" name="order_id" placeholder="Masukan ID Pesanan Anda" required
            style="flex: 1;
                    min-width: 250px;
                    padding: 10px 15px;
                    border-radius: 8px;
                    border: none;
                    box-shadow: inset 0 0 3px rgba(0,0,0,0.1);">

        <button type="submit"
                style="background-color: #0b3c9c;
                    color: white;
                    font-weight: bold;
                    border: none;
                    border-radius: 8px;
                    padding: 10px 20px;
                    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
                    cursor: pointer;">
            Lihat Pesanan
        </button>
    </div>
</form>

<!-- Spasi antar section -->
<div style="height: 40px;"></div>
