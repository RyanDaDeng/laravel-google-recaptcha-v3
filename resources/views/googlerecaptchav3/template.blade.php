<?php
    $nonce = !empty($nonce) ? "nonce='{$nonce}'" : '';
?>

@if(! $hasAction && $backgroundMode )
    @if($display === false)
        <style {!! $nonce !!}>
            .grecaptcha-badge {
                display: none;
            }
        </style>
    @endif
    <script {!! $nonce !!}>
        if (!document.getElementById('gReCaptchaScript')) {
            let reCaptchaScript = document.createElement('script');
            reCaptchaScript.setAttribute('src', '{{$apiJsUrl}}?render={{$publicKey}}');
            reCaptchaScript.async = true;
            reCaptchaScript.defer = true;
            document.head.appendChild(reCaptchaScript);
        }
    </script>
@endif


@if($hasAction)
    <script {!! $nonce !!}>
        @foreach($mappers as $action=>$fields)
                @foreach($fields as $field)
                    var client{{$field}};
                 @endforeach
        @endforeach

        function onloadCallback() {
                    @foreach($mappers as $action=>$fields)
                    @foreach($fields as $field)
                    if (document.getElementById('{{$field}}')) {
                            client{{$field}} = grecaptcha.render('{{$field}}', {
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
                    }
            @endforeach
            @endforeach
        }
    </script>
    <script id='gReCaptchaScript' src="{{$apiJsUrl}}?render=explicit&onload=onloadCallback"
            defer
            async {!! $nonce !!}></script>
@endif

<script {!! $nonce !!}>
    function refreshReCaptchaV3(fieldId,action){
        grecaptcha.reset(window['client'+fieldId]);
        grecaptcha.ready(function () {
            grecaptcha.execute(window['client'+fieldId], {
                action: action
            });
        });
    }

    function getReCaptchaV3Response(fieldId){
        return grecaptcha.getResponse(window['client'+fieldId])
    }
</script>

