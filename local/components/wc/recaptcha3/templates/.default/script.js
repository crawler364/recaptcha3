class ReCaptcha3 {
    constructor(props) {
        this.props = props;
    }

    static async getParams(props) {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'getParams', {
            mode: 'class',
            signedParameters: props.signedParameters
        });
        if (response.status == 'success') {
            let siteKey = response.data.siteKey;
            let secretKey = response.data.secretKey;
            let action = response.data.action;
            if (typeof siteKey != 'undefined' && typeof secretKey != 'undefined' && typeof action != 'undefined') {
                return response;
            }
        }
    }

    handler(props) {
        grecaptcha.ready(async function () {
            let params = await ReCaptcha3.getParams(props);
            console.log(params);
            let token = await grecaptcha.execute(params.data.siteKey, {action: params.data.action});
            let siteVerify = await ReCaptcha3.siteVerify(params.data.secretKey, token);
            if (siteVerify.data.response.success == true) {
                let catpchaSid = document.getElementById('wcCaptchaSid').value;
                document.getElementById('wcCaptchaWord').value = await ReCaptcha3.getCaptchaWord(catpchaSid);
            }
        });
    }

    static async siteVerify(secretKey, token) {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'siteVerify', {
            mode: 'class',
            data: {
                secretKey: secretKey,
                token: token,
            }
        });
        return response;
    }

    static async getCaptchaWord(catpchaSid) {
        let responce = await BX.ajax.runComponentAction('wc:recaptcha3', 'getCaptchaWord', {
            mode: 'class',
            data: {
                catpchaSid: catpchaSid,
            }
        });
        return responce.data.captchaWord;
    }
}