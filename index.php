<!-- index.php -->
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['login'])){
    header("Location: dassboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login CheeseStock</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#111827;
            padding:20px;
        }

        .container{
            width:100%;
            max-width:1400px;
            min-height:90vh;
            display:flex;
            border-radius:25px;
            overflow:hidden;
            background:white;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        /* LEFT */
        .left{
            width:50%;
            position:relative;
            background:url('https://images.unsplash.com/photo-1452195100486-9cc805987862?q=80&w=1974&auto=format&fit=crop') center/cover;
            padding:60px;
            color:white;
        }

        .overlay{
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.65);
        }

        .content{
            position:relative;
            z-index:2;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:15px;
            margin-bottom:50px;
        }

        .logo i{
            font-size:50px;
            color:#ffcc00;
        }

        .logo h1{
            font-size:45px;
        }

        .logo span{
            color:#ffcc00;
        }

        .subtitle{
            font-size:20px;
            line-height:1.7;
            margin-bottom:50px;
            max-width:500px;
        }

        .feature{
            display:flex;
            gap:15px;
            margin-bottom:30px;
        }

        .feature-icon{
            width:55px;
            height:55px;
            border-radius:15px;
            border:1px solid rgba(255,255,255,0.2);
            display:flex;
            justify-content:center;
            align-items:center;
            color:#ffcc00;
            font-size:22px;
        }

        .feature h3{
            margin-bottom:5px;
        }

        .feature p{
            color:#ddd;
            font-size:15px;
        }

        .copyright{
            position:absolute;
            bottom:30px;
            left:60px;
            z-index:2;
            color:#ccc;
        }

        /* RIGHT */
        .right{
            width:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:50px;
            background:white;
        }

        .login-box{
            width:100%;
            max-width:500px;
        }

        .lock{
            width:120px;
            height:120px;
            background:#fff5db;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            margin-bottom:30px;
        }

        .lock i{
            font-size:50px;
            color:#ffcc00;
        }

        .login-box h2{
            text-align:center;
            font-size:42px;
            color:#111827;
            margin-bottom:10px;
        }

        .login-box .desc{
            text-align:center;
            color:#6b7280;
            margin-bottom:40px;
        }

        .input-group{
            position:relative;
            margin-bottom:25px;
        }

        .input-group input{
            width:100%;
            height:65px;
            border:1px solid #ddd;
            border-radius:15px;
            padding-left:60px;
            font-size:17px;
            outline:none;
        }

        .input-group i{
            position:absolute;
            top:22px;
            left:20px;
            color:#6b7280;
            font-size:20px;
        }

        .option{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .option a{
            text-decoration:none;
            color:#2563eb;
        }

        .btn{
            width:100%;
            height:65px;
            border:none;
            border-radius:15px;
            background:#ffcc00;
            color:white;
            font-size:20px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover{
            background:#e6b800;
        }

        .divider{
            text-align:center;
            margin:35px 0;
            position:relative;
            color:#999;
        }

        .divider::before,
        .divider::after{
            content:'';
            position:absolute;
            top:50%;
            width:40%;
            height:1px;
            background:#ddd;
        }

        .divider::before{
            left:0;
        }

        .divider::after{
            right:0;
        }

        .back{
            width:100%;
            height:65px;
            border-radius:15px;
            border:1px solid #ddd;
            background:white;
            cursor:pointer;
            font-size:18px;
        }

        .help{
            text-align:center;
            margin-top:35px;
            color:#777;
        }

        .help a{
            color:#2563eb;
            text-decoration:none;
        }

        @media(max-width:1000px){

            .container{
                flex-direction:column;
            }

            .left,
            .right{
                width:100%;
            }

            .left{
                min-height:500px;
            }

        }

    </style>

</head>
<body>

<div class="container">

    <!-- LEFT -->
    <div class="left">

        <div class="overlay"></div>

        <div class="content">

            <div class="logo">

                <i class="fa-solid fa-cheese"></i>

                <div>
                    <h1>Cheese<span>Stock</span></h1>
                    <p>Sistem Data Produk Keju</p>
                </div>

            </div>

            <div class="subtitle">
                Kelola Data Produk Keju dengan Mudah & Terorganisir
            </div>

            <div class="feature">

                <div class="feature-icon">
                    <i class="fa-solid fa-cube"></i>
                </div>

                <div>
                    <h3>Kelola Produk</h3>
                    <p>Tambah, edit dan hapus produk keju</p>
                </div>

            </div>

            <div class="feature">

                <div class="feature-icon">
                    <i class="fa-solid fa-chart-column"></i>
                </div>

                <div>
                    <h3>Pantau Stok</h3>
                    <p>Monitoring stok secara realtime</p>
                </div>

            </div>

            

            <div class="feature">

                <div class="feature-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>
                    <h3>Aman & Terpercaya</h3>
                    <p>Data terlindungi dengan sistem keamanan</p>
                </div>

            </div>

        </div>


    </div>

    <!-- RIGHT -->
    <div class="right">

        <div class="login-box">

            <div class="lock">
                <i class="fa-solid fa-lock"></i>
            </div>

            <h2>Login Administrator</h2>

            <p class="desc">
                Masuk untuk mengakses dashboard admin
            </p>

            <form action="login.php" method="POST">

                <div class="input-group">

                    <i class="fa-regular fa-user"></i>

                    <input 
                        type="text" 
                        name="username"
                        placeholder="Username"
                        required
                    >

                </div>

                <div class="input-group">

                    <i class="fa-solid fa-lock"></i>

                    <input 
                        type="password"
                        name="password"
                        placeholder="Password"
                        required
                    >

                </div>

                

                <button type="submit" class="btn">
                    Login
                </button>

            </form>


        </div>

    </div>

</div>

</body>
</html>