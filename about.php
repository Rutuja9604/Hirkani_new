<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - Hirkani Beauty Parlour</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdf6ff;
      color: #333;
      line-height: 1.6;
    }

    header {
      
      background-color:rgb(251, 63, 129);
      color: white;
      padding: 40px 20px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    header h1 {
      font-size: 36px;
      margin-bottom: 10px;
    }

    header p {
      font-size: 16px;
      color: #fddde6;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .section {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    h2 {
      font-size: 26px;
      margin-bottom: 20px;
      color:rgb(251, 63, 129);
      border-bottom: 2px solid #e1bee7;
      padding-bottom: 10px;
    }

    p {
      font-size: 16px;
      margin-bottom: 15px;
      text-align: justify;
    }

    .info-icon {
      color:rgb(251, 63, 129);
      margin-right: 10px;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #f3e5f5;
      font-size: 14px;
      color: #555;
    }

    @media (max-width: 768px) {
      header h1 {
        font-size: 28px;
      }

      h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>

<header>
  <h1>Hirkani Beauty Parlour</h1>
 <b><p><h3>Empowering Beauty, Embracing Elegance</h3></p></b>
</header>

<div class="container">
  <div class="section">
    <h2><i class="fa fa-map-marker-alt info-icon"></i> Address</h2>
    <p>Hirkani Beauty Parlour, Chougale Building, Walva Road, Bidri, Kolhapur, Maharashtra 4160208</p>
  </div>

  <div class="section">
    <h2><i class="fa fa-info-circle info-icon"></i> Who We Are</h2>
    <p>
      Hirkani Beauty Parlour is a trusted beauty and wellness destination located in the heart of Kolhapur. We offer a broad range of personalized services tailored to enhance your natural beauty and boost confidence.
    </p>
    <p>
      From hair care and skin treatments to makeup and grooming, our expert team is dedicated to delivering an exceptional experience for every client. We combine traditional beauty techniques with modern tools and technology to ensure the best results.
    </p>
    <p>
      At Hirkani, we believe that beauty is personal. Our mission is to provide a serene and professional environment where each guest feels valued, pampered, and refreshed.
    </p>
  </div>

  <div class="section">
    <h2><i class="fa fa-cogs info-icon"></i> Our Commitment</h2>
    <p>
      We are constantly evolving by embracing modern digital tools to enhance operational efficiency and customer satisfaction. Your comfort, safety, and satisfaction remain at the core of our values.
    </p>
  </div>
</div>

<footer>
  &copy; <?php echo date("Y"); ?> Hirkani Beauty Parlour. All rights reserved.
</footer>

</body>
</html>
