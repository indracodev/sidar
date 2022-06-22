<template>
    <div class="page" style="border-right: 0">
        <div class="navbar">
            <div class="navbar-bg"></div>
            <div class="navbar-inner" style="place-content: center;">
                <span><b>PATROL</b></span>
            </div>
        </div>

        <div class="page-content">
            <div class="list no-margin"
                 style="border-right: 1px solid #e0e0e0; height: calc(100vh - var(--f7-navbar-height));">
                <ul>
                    <li>
                        <a data-reload-detail="true" href="/dashboard/" id="root" data-transition="f7-circle" class="item-link item-content">
                            <div class="item-inner">
                                <div class="item-title">Dashboard</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a data-reload-detail="true" href="/checkpoint/" data-transition="f7-circle" class="item-link item-content">
                            <div class="item-inner">
                                <div class="item-title">Checkpoint</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a data-reload-detail="true" href="/person/" data-transition="f7-circle" class="item-link item-content">
                            <div class="item-inner">
                                <div class="item-title">Guard</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a data-reload-detail="true" href="/report/" data-transition="f7-circle" class="item-link item-content">
                            <div class="item-inner">
                                <div class="item-title">Report</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a data-reload-detail="true" href="/schedule/" data-transition="f7-circle" class="item-link item-content">
                            <div class="item-inner">
                                <div class="item-title">Schedule</div>
                            </div>
                        </a>
                    </li>
                    ${isAuth && $h`
                    <li>
                        <a data-reload-detail="true" href="/users/" data-transition="f7-circle" class="item-link item-content">
                            <div class="item-inner">
                                <div class="item-title">Users</div>
                            </div>
                        </a>
                    </li>
                    `}
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
    "user strict"
    export default (props, {$on, $update, $f7}) => {
        let isAuth = false
        $on('page:mounted', () => {
            if (props.level == '10') {
                isAuth = true
                $update()
            }
        })

        $on('page:afterin', () => {
            $f7.view.main.router.navigate(`/dashboard/`)
        })

        return $render
    }
</script>