<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/url.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Url shortener</title>

</head>
<style>
        .hidden {
            display: none;
        }
        h3 {
            color: white;
            font-size : 16px;
        }

    </style>
<body>
<section class="landing-section">
        <div class="landing-page">
            <header>
                <div class="container">
                    <a href="/" class="logo"><span style="color:#5d5d5d;">REDISIGN your <span><b> URl</b></a>
                    <ul class="links">
                        <li>Home</li>
                        <li>About Us</li>
                        <li>Work</li>
                        <li>Info</li>
                        <li><a href="/dashboard" id="ds">Dashboard</a></li>
                        @if(auth()->check())
                        <form method ="post" action="/logout">
                            @csrf
                        <button type="submit" id="dy"><li>Logout</li></button>
                        </form>
                        @else
                        <li><a href="/loginpage"> Get Started</a></li>
                        @endif

                    </ul>
                </div>
            </header>

    </section>
<section class="login-section">
        <div class="login-box">
            <h1>URL shorten</h1>
            <form action="{{ url('/api/shorten') }}" method="post">
    @csrf
    <div class="user-box">
        <input type="text" name="long_url" required="">
        <label>Enter your URL</label>
    </div>

    <!-- Radio button group -->
    <div class="radio-group" >
        <div class="rd">
    <input type="radio" id="shorten" name="action" value="shorten" checked>
    <label for="shorten">Shorten URL</label>
    </div>
    <div class="rd">
    <input type="radio" id="mask" name="action" value="mask">
    <label for="mask">Mask URL</label>
    </div>
    <div class="rd">
    <input type="radio" id="generateQR" name="action" value="generateQR">
    <label for="generateQR">Generate QR Code</label>
    </div>
</div>
<div class="user-box">
<div id="additionalField" class="hidden">
    <h3 >Your new URL hint</h3>
    <input type="text" id="additionalInput" name="additionalInput">
</div>
    </div>
    <button>
        Submit
    </button>
</form>
<div id="result-container">
            @if(isset($short_url))
                <div>
                <p>Your Shortened URL: <a href=" {{ url('/short/' . $short_url) }}" target="_blank">{{ $short_url }}</a></p>
                </div>
            @endif

            @if(isset($masked_url))
                <div>
                <p>Your masked URL: <a href="{{ url('/masked/' . $masked_url) }}"  target="_blank">{{ $masked_url }}</a></p>
                </div>
            @endif

            @if(isset($qr_code))
                <div>
                <h3>QR Code for the Long URL:</h3>
                <!-- {!! $qr_code !!} -->
                {{$qr_code}}
                <button id="download-qr-button">Download QR Code</button>

                </div>
            @endif
        </div>

        </div>
    </section>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var radioMask = document.getElementById('mask');
        var additionalField = document.getElementById('additionalField');

        radioMask.addEventListener('change', function () {
            if (radioMask.checked) {
                additionalField.classList.remove('hidden');
            } else {
                additionalField.classList.add('hidden');
            }
        });
    });
    const downloadButton = document.getElementById('download-qr-button');
    downloadButton.addEventListener('click', function() {
        const svgElement = document.querySelector('#result-container svg');
        const svgData = new XMLSerializer().serializeToString(svgElement);
        const blob = new Blob([svgData], { type: 'image/svg+xml' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'qrcode.svg'; // Optional: Set a custom filename
        link.click();
        URL.revokeObjectURL(link.href);
    });
</script>
</html>
