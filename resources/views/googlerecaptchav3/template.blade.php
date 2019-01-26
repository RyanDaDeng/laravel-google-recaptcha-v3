{{\TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3::setHasAction(true)}}
<script>

    function onloadCallback() {
                @foreach($mappers as $action=>$fields)
                @foreach($fields as $field)
        let client{{$field}} = grecaptcha.render('{{$field}}', {
                'sitekey': '{{$publicKey}}',
                    @if($inline===true) 'badge': 'inline', @endif
                'size': 'invisible',
                'hl': '{{$language}}'
            });
        grecaptcha.ready(function () {
            grecaptcha.execute(client{{$field}}, {
                action: '{{$action}}'
            });
        });
        @endforeach
        @endforeach
    }
</script>
<script id='gReCaptchaScript' src="https://www.google.com/recaptcha/api.js?render=explicit&onload=onloadCallback" defer
        async></script>
