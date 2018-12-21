<script>
    function onloadCallback() {
                @foreach($mappers as $action=>$fields)
                @foreach($fields as $field)

        let client{{$field}} = grecaptcha.render('{{$field}}', {
                'sitekey': '{{$publicKey}}',
                    @if($inline===true) 'badge': 'inline', @endif
                'size': 'invisible'
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


<script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=onloadCallback" defer async></script>
