<template>
    <div :id="elementId"
    ></div>
</template>

<script>
    export default {
        name: 'google-recaptcha-v3',
        props: {
            siteKey: String,
            elementId: String,
            inline: Boolean
        },
        data() {
            return {
                gAssignedId: null,
                captchaReady: false,
                renderedReady: false,
                checkInterval: null,
                checkIntervalRunCount: 0
            }
        },
        created() {
        },
        computed: {},
        mounted() {
            this.init();
        },
        watch: {
            captchaReady: function (data) {
                if (data) {
                    clearInterval(this.checkInterval)
                    this.render()
                }
            },
            renderedReady: function (data) {
                if (data) {
                    clearInterval(this.checkInterval)
                    this.execute()
                }
            },
        },
        methods: {
            execute() {
                window.grecaptcha.ready(function () {
                    grecaptcha.execute(this.gAssignedId, {
                        action: 'contact_us'
                    });
                });
            },
            render() {
                this.gAssignedId = window.grecaptcha.render(this.elementId, {
                    sitekey: this.siteKey,
                    badge: this.inline === true ? 'inline' : '',
                    size: 'invisible'
                });
                this.renderedReady = true;
            },
            init() {
                this.checkInterval = setInterval(() => {
                    this.checkIntervalRunCount++;
                    if (window.grecaptcha && window.grecaptcha.hasOwnProperty('render')) {
                        this.captchaReady = true
                    } else {
                        let recaptchaScript = document.createElement('script');
                        recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js?render=explicit');
                        document.head.appendChild(recaptchaScript);
                        recaptchaScript.async = true;
                        recaptchaScript.defer = true;
                    }
                }, 1000)
            }
        }
    }
</script>
