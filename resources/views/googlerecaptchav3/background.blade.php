@if(\TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3::$hasAction === false)
    @if($display === false)
        <style>
            .grecaptcha-badge {
                display: none;
            }
        </style>
    @endif
    <script>
        if (!document.getElementById('gReCaptchaScript')) {
            let reCaptchaScript = document.createElement('script');
            reCaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js?render={{$publicKey}}');
            reCaptchaScript.async = true;
            reCaptchaScript.defer = true;
            document.head.appendChild(reCaptchaScript);
        }
    </script>
@endif
