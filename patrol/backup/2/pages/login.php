<template>
    <div class="page">
        <div class="page-content login-screen-content display-flex flex-direction-column justify-content-center">
            <div class="login-screen-title">
                <img src="img/icon.png" width="120" height="120"/>
            </div>
            <form>
                <div class="list">
                    <ul>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">Username</div>
                                <div class="item-input-wrap">
                                    <input type="text" autocomplete="off" name="username" placeholder="Your username"
                                           required
                                           validate/>
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">Password</div>
                                <div class="item-input-wrap">
                                    <input type="password" name="password" placeholder="Your password" required
                                           validate/>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="padding" style="text-align: -webkit-right;">
                                <a class="button button-fill" @click="${submit}" style="width: 100px; background: var(--f7-theme-color);">Sign
                                    In</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    "user strict"
    export default (props, { $onMounted, $, $f7 }) => {

        const submit = () => {
            try {
                model.login({
                    username: $('input[name="username"]').val(),
                    password: $('input[name="password"]').val(),
                    device: 'web',
                    token: Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
                }, {
                    success : (data) => {
                        var res = JSON.parse(data)
                        switch (res.status) {
                            case 'success' :
                                storage.setItem('hash-patrol', res.hash)
                                $f7.view.main.router.navigate(`/navi/${res.level}/`, {transition: 'f7-circle'})
                                res = null
                                break
                            case 'false' :
                                toast('Wrong combination!')
                                break
                            case 'failed' :
                                toast('Database problem!')
                                break
                            case 'error' :
                                toast('Form problem!')
                                break
                            case 'unauth' :
                                toast('Not authorized!')
                                break
                        }
                    }, error : () => {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        $onMounted(() => {
            $('input[name="username"]').focus()
            $('input[name="password"]').keypress((e) => {
                if (e.which == 13) {
                    submit()
                }
            })
        })

        return $render
    }
</script>