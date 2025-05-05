<style>
    body {
      margin: 0;
      padding: 0;
    }

    /* Header Checkout */
    .keranjang-header {
      background: linear-gradient(to bottom, #f9f9f9, white);
      background-image: url('{{ asset("assets/images/bg-lacak.png") }}');
      background-size: cover;
      background-position: top;
      padding: 80px 20px;
      position: relative;
      text-align: center;
      height: 500px;

      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 40px;
      flex-direction: column;
    }

    .keranjang-header h1 {
      font-family: 'Protest Riot', sans-serif;
      font-size: 2.5rem;
      color: #0b3c9c;
      margin: 0;
      display: inline-block;
      text-shadow:
        -2px -2px 0 #ffffff,
         2px -2px 0 #ffffff,
        -2px  2px 0 #ffffff,
         2px  2px 0 #ffffff,
         0px  0px 4px #ffffff;
    }

    .keranjang-header img {
      width: 40px;
      height: auto;
      margin-left: 10px;
    }

    .clouds {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 60px;
      background: url('{{ asset("assets/images/clouds.png") }}') repeat-x center;
      background-size: contain;
    }

    .form-container {
      margin-top: 60px;
      padding: 30px;
      background-color: #f4fdb4;
      border-radius: 10px;
    }

    .order-summary {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
    }

    .order-item {
      background-color: #cde8ff;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .order-item img {
      height: 70px;
      width: auto;
    }

    .status-badge {
      font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .keranjang-header {
        padding: 40px 15px;
        height: auto;
        text-align: center;
        flex-direction: column;
      }

      .keranjang-header h1 {
        font-size: 1.8rem;
      }

      .keranjang-header img {
        width: 30px;
        margin: 10px 0 0 0;
      }

      .form-container {
        padding: 20px;
      }

      .order-item {
        flex-direction: column;
        align-items: flex-start;
      }

      .order-item img {
        height: 60px;
      }
    }
  </style>
