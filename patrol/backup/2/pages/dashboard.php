<template>
    <div class="page">
        <div class="navbar">
            <div class="navbar-bg"></div>
            <div class="navbar-inner">
                <div class="left left-navbar">
                    <a href="#" class="link back">
                        <span>Back</span>
                    </a>
                </div>
                <div class="title text-align-center" style="width: 100%;">Dashboard</div>
            </div>
        </div>

        <div class="page-content">
            <div style="max-width: 1280px; margin: 0 auto;">
                <div class="card card-outline">
                    <div class="card-header">
                        <span>Today Activity</span>
                        <a class="button button-raised" href="#" @click="${refresh}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            ${phase && phase.map((phase, index) => $h`
                            <div class="col-100 medium-30">
                                <div class="display-flex flex-direction-column">
                                    <a data-reload-detail="true" @click="${()=> getActivity(phase, index+1)}" href="#" data-transition="f7-circle" class="button button-outline margin popup-open phase-button" data-popup="#activity-popup" style="height: 150px;">
                                        <div class="display-flex flex-direction-column">
                                        <span style="font-size: xxx-large">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                        </span>
                                            <span style="text-transform: capitalize;">Phase ${index + 1}</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            `)}
                            ${phaseLen%2 == 0 && $h`
                            <div class="col-100 medium-30"></div>
                            `}
                            ${!phase && $h`
                            <div class="padding">
                                <span>No activity today!</span>
                            </div>
                            `}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup" id="activity-popup" data-close-by-backdrop-click="false">
            <div class="display-flex justify-content-center align-items-center">
                <span class="padding" style="font-size: xx-large">Phase ${phaseIndex}</span>
                <a class="button button-outline" @click="${refreshPopup}" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                    </svg>
                </a>
            </div>
            <div class="page-content" style="background: white!important; padding-bottom: 125px;">
                ${checkpoint && $h`
                <div class="timeline timeline-sides">
                    ${checkpoint.map((activity) => $h`
                    <div class="timeline-item timeline-item-right" style="margin-left: calc(50% - (var(--f7-timeline-divider-margin-horizontal) * 2 + 10px)/ 2 - 125px);">
                        <div class="timeline-item-date">
                            <span>${activity.start || 'Start'}</span>
                        </div>
                        <div class="timeline-item-divider" style="background: ${activity.status}"></div>
                        <div class="timeline-item-date" style="width: 50px; position: absolute; bottom: 0; left: 95px;">
                            <span>${activity.end || 'End'}</span>
                        </div>
                        <div class="timeline-item-content" style="padding-left: 65px;">
                            <div class="timeline-item-inner margin-top">
                                <span>Checkpoint : ${activity.checkpoint}</span><br/>
                                <span>Guard : ${activity.person}</span>
                            </div>
                        </div>
                    </div>
                    `)}
                    <div class="timeline-item timeline-item-right" style="margin-left: calc(50% - (var(--f7-timeline-divider-margin-horizontal) * 2 + 10px)/ 2 - 125px);">
                        <div class="timeline-item-date"></div>
                        <div class="timeline-item-divider" style="background: ${endStatus};"></div>
                    </div>
                </div>
                `}
                ${!checkpoint && $h`
                <div class="display-flex justify-content-center padding">
                    <div class="preloader"></div>
                </div>
                `}
            </div>
            <a class="button button-fill button-large popup-close" href="#" style="position: fixed; bottom: 0; width: 100%; z-index: 1; border-radius: 0;">Close</a>
        </div>

    </div>
</template>
<script>
    "user strict"
    export default (props, { $onBeforeMount, $onBeforeUnmount, $update }) => {
        var phase
        var phaseId
        var phaseIndex
        var phaseLen
        var checkpoint
        var endStatus

        const formatDate = (date) => {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear()

            if (month.length < 2) month = '0' + month
            if (day.length < 2) day = '0' + day
            d = null
            return [year, month, day].join('-')
        }

        $onBeforeMount(() => {
            getPhase()
        })

        $onBeforeUnmount(() => {
            phase = null
            phaseId = null
            phaseIndex = null
            phaseLen = null
            checkpoint = null
            endStatus = null
        })

        const getPhase = () => {
            try {
                model.getPhaseDashboard({
                    date: formatDate(new Date())
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        switch (res.status) {
                            case 'success':
                                phase = res.phaseId
                                phaseLen = phase.length
                                res = null
                                $update()
                                break
                            case 'false':
                                toast('No data!')
                                break
                            case 'error':
                                toast('Data problem!')
                                break
                        }
                    }, error: () => {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const getActivity = (e, i) => {
            try {
                phaseId = e
                phaseIndex = i
                model.getActivity({
                    hash: storage.getItem('hash-patrol') || '',
                    phase: e
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        checkpoint = res.schedule
                        res = null
                        var len = checkpoint.length-1
                        endStatus = checkpoint[len].status
                        len = null
                        $update()
                    }, error: () => {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const refreshPopup = () => {
            getActivity(phaseId, phaseIndex)
        }

        const refresh = () => {
            getPhase()
        }

        return $render
    }
</script>