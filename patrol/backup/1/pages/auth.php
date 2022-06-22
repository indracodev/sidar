<template>
    <div class="page page-home">
        <div class="page-content display-flex align-items-center justify-content-center">
            <div class="preloader" style="width: 44px; height: 44px"></div>
        </div>
    </div>
</template>
<script>
    "user strict"
    export default (props, { $on, $f7 }) => {
        $on('pageInit', () => {
            try {
                let hash = storage.getItem('hash') || ''
                model.auth({
                    hash : hash
                }, {
                    success : function (data) {
                        let res = JSON.parse(data)
                        res.status == 'success' ? $f7.view.main.router.navigate(`/navi/${res.level}/`, {transition: 'f7-circle'}) :
                            $f7.view.main.router.navigate({path: '/login/'}, {transition: 'f7-circle'})
                    }, error : function () {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        })

        return $render
    }
</script>