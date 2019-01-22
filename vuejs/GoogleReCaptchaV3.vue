<template>
    <div :id="id"></div>
</template>

<script>
    export default {
        name: 'google-recaptcha-v3',
        props: {
            action: {
                type: String,
                required: false,
                default: 'validate_grecaptcha'
            },
            id: {
                type: String,
                required: false,
                default: 'grecaptcha_container'
            },
            siteKey: {
                type: String,
                required: false, // set to true if you don't want to store the siteKey in this component
                default: '' // set siteKey here if you want to store it in this component
            },
            inline: {
                type: Boolean,
                required: false,
                default: false,
            },
        },
        data() {
            return {
                captchaId: null,
            }
        },
        mounted() {
            this.init();
        },
        methods: {
            init() {
                if (!document.getElementById('gRecaptchaScript')) {

                    window.gRecaptchaOnLoadCallbacks = [this.render];
                    window.gRecaptchaOnLoad = function () {
                        for (let i = 0; i < window.gRecaptchaOnLoadCallbacks.length; i++) {
                            window.gRecaptchaOnLoadCallbacks[i]();
                        }
                        delete window.gRecaptchaOnLoadCallbacks;
                        delete window.gRecaptchaOnLoad;
                    };

                    let recaptchaScript = document.createElement('script');
                    recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js?render=explicit&onload=gRecaptchaOnLoad');
                    recaptchaScript.setAttribute('id', 'gRecaptchaScript');
                    recaptchaScript.async = true;
                    recaptchaScript.defer = true;
                    document.head.appendChild(recaptchaScript);

                } else if (!window.grecaptcha || !window.grecaptcha.render) {
                    window.gRecaptchaOnLoadCallbacks.push(this.render);
                } else {
                    this.render();
                }
            },

            render() {
                this.captchaId = window.grecaptcha.render(this.id, {
                    sitekey: this.siteKey,
                    badge: this.inline === true ? 'inline' : '',
                    size: 'invisible',
                    'expired-callback': this.execute
                });

                this.execute();
            },

            execute() {
                window.grecaptcha.execute(this.captchaId, {
                    action: this.action,
                }).then((token) => {
                    this.$emit('input', token);
                });
            }
        }
    }
</script>