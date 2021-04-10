class ReCaptcha3 {
    constructor(params) {
        this.siteKey = params.siteKey;
        this.position = params.position;
        this.action = params.action;
        this.signedParameters = params.signedParameters;
        this.captchaSid = params.captchaSid;
        this.captchaWordContainer = BX.findChild(BX('wc-recaptcha3'), {attribute: {'data-type': 'captcha-word'}}, true, false);
        this.badgeContainer = BX.findChild(BX('wc-recaptcha3'), {attribute: {'data-type': 'badge'}}, true, false);
    }

    async handler() {
        let render = await grecaptcha.render(this.badgeContainer, {
            'sitekey': this.siteKey,
            'badge': this.position,
            'size': 'invisible'
        });
        let token = await grecaptcha.execute(render, {
            action: this.action
        });

        BX.ajax.runComponentAction('wc:recaptcha3', 'processCaptcha', {
            mode: 'ajax',
            data: {token: token, captchaSid: this.captchaSid},
            signedParameters: this.signedParameters,
        }).then((response) => {
            this.captchaWordContainer.value = response.data.captchaWord;
        }, (response) => {
            response.errors.forEach(function (error) {
                console.error(error.message);
            });
        });
    }
}
