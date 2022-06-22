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
                <div class="title text-align-center" style="width: 100%;">Report</div>
            </div>
        </div>

        <div class="page-content">
            <div style="max-width: 1280px; margin: 0 auto;">
                <div class="card card-outline data-table data-table-collapsible data-table-init">
                    <div class="card-header">
                        <div class="data-table-title">Report List</div>
                    </div>
                    <div class="card-content">
                        <table>
                            <thead>
                            <tr>
                                <th class="label-cell"><b>No</b></th>
                                <th class="label-cell"><b>Guard Name</b></th>
                                <th class="label-cell"><b>Checkpoint</b></th>
                                <th class="label-cell"><b>Location</b></th>
                                <th class="numeric-cell"><b>Date</b></th>
                                <th class="numeric-cell"><b>Time</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            ${report && report.map((report) => $h`
                            <tr>
                                <td class="label-cell" data-collapsible-title="Number">${report.no}</td>
                                <td class="label-cell" data-collapsible-title="Guard Name">${report.person}</td>
                                <td class="label-cell" data-collapsible-title="Checkpoint">From ${report.checkpoint}</td>
                                <td class="label-cell" data-collapsible-title="Location">
                                    <a class="button button-outline" href="#" @click="${()=> map(report.startLocation, report.endLocation)}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                             class="bi bi-geo-alt padding-right" viewBox="0 0 16 16">
                                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                        Open Maps</a></td>
                                <td class="numeric-cell" data-collapsible-title="Date">${report.date}</td>
                                <td class="numeric-cell" data-collapsible-title="Time">${report.time}</td>
                            </tr>
                            `)}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    "user strict"
    export default (props, { $onBeforeMount, $onBeforeUnmount, $update, $f7 }) => {
        var report

        $onBeforeMount(() => {
            getReport()
        })

        $onBeforeUnmount(() => {
            report = null
        })

        const getReport = () => {
            try {
                model.getReport({
                    hash: storage.getItem('hash-patrol') || ''
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        report = res.person
                        res = null
                        $update()
                    }, error: () => {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const map = (a, b) => {
            window.open(`https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s-circle+285A98(${a}),pin-s-circle+285A98(${b})/auto/640x640@2x?access_token=pk.eyJ1IjoiZG9rb3RlbGVrIiwiYSI6ImNrNTUydHU0eTBwdDYzZXBubnU1cGg0bnMifQ.3mx4XwIRpMPjdcEssgS4lg&attribution=false&logo=false`)
        }

        return $render
    }
</script>