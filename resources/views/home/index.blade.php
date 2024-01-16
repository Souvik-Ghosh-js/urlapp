<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Url shortener</title>

</head>

<body>
    <!-- Section 1: Landing Page -->
    <section class="landing-section">
        <div class="landing-page">
            <header>
                <div class="container">
                    <a href="/" class="logo"><span style="color:#5d5d5d; text-decoration: none, ;">REDISIGN your </span><b> URl</b></a>
                    <ul class="links">
                        <li>Home</li>
                        <li>About Us</li>
                        <li>Work</li>
                        <li>Info</li>
                        <li><a href="/dashboard" id="ds">Dashboard</a></li>
                        @if(auth()->check())
                        <form method ="post" action="/logout">
                            @csrf
                        <button type="submit" style="outline: 0; border: none; color: #d8c026;"><li>Logout</li></button>
                        </form>
                        @else
                        <li><a href="/loginpage" id="dy" > Get Started</a></li>
                        @endif

                    </ul>
                </div>
                <style>
                    #ds{
                        text-decoration: none;
                        color: #5d5d5d;
                        transition: 0.2s all;
                    }
                    #ds:hover{
                        color: #6c63ff;
                    }
                    #dy{
                        text-decoration: none;
                        color: #fff;
                        transition: 0.2s all;
                    }
                    </style>
            </header>
            <div class="content">
                <div class="container">
                    <div class="info">
                        <h1>Looking For Better <span style="color: #d8c026; font-size: 50px; font-weight: 900   ">URLs </span></h1>
                        <p>This might be your best Experience. Shorten your <span style="color: #d8c026; font-size: 22px; font-weight: 600">URLs</span>, Design your Urls into QR codes, fancy names and much more.</p>
                        <button><a href="/abc" style=" color: #fff; font-size: 20px; font-weight: 600">Press me To Explore</a></button>
                    </div>
                    <div class="image">
                        <img src="https://i.pinimg.com/564x/ba/e7/a6/bae7a6b97e6821bafac4cfab6763de4f.jpg">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section 1 -->

</body>

</html>
