<script src="https://www.google.com/recaptcha/api.js?render={{$publicKey}}"></script>
<script>
    grecaptcha.ready(function () {
        @foreach($rows as $action =>$id)
            grecaptcha.execute('{{$publicKey}}', {action: '{{$action}}'}).then(function (token) {
                document.getElementById('{{$id}}').value = token;
            });
        @endforeach
    });
</script>

