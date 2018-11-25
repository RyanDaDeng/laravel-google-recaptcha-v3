<input type="hidden" id="{{$id}}" name="{{$name}}">
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('{{$publicKey}}', {action: '{{$action}}'}).then(function (token) {
            console.log(token);
            document.getElementById('{{$id}}').value = token;
        });
    });
</script>
