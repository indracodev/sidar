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
                <div class="title text-align-center" style="width: 100%;">Schedule</div>
            </div>
        </div>

        <div class="page-content">
            <div style="max-width: 1280px; margin: 0 auto;">
                <div class="card card-outline" style="border: 0; background: whitesmoke;">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-100 medium-50" style="border: 1px solid #e0e0e0; background: white;">
                                <div id="calendar"></div>
                            </div>
                            <div class="col-100 medium-50" style="border: 1px solid #e0e0e0; background: white;">
                                <div class="list accordion-list">
                                    <ul>
                                        ${phase && phase.map((phase, index) => $h`
                                        <li class="accordion-item" data-phase="${phase}">
                                            <a class="item-content item-link padding-right" href="#">
                                                <div class="item-inner no-padding-right margin-right">
                                                    <div class="item-title" style="font-weight: 500;">Phase ${parseInt(index)+1} <small class="text-color-primary" style="font-weight: 400;">(${calendarView})</small></div>
                                                </div>
                                            </a>
                                            <div class="accordion-item-content">
                                                <div class="block">
                                                    <div class="list media-list">
                                                        <ul>
                                                            ${!schedule && $h`
                                                            <li>
                                                                <div class="item-content">
                                                                    <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                            <div class="item-title" style="text-transform: capitalize; font-weight: 400;">No Schedule</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            `}
                                                            ${schedule && schedule.map((schedule, index) => $h`
                                                            <li>
                                                                <div class="item-content">
                                                                    <div class="item-inner no-padding-right margin-right">
                                                                        <div class="item-title-row">
                                                                            <div class="item-title" style="text-transform: capitalize; font-weight: 400;">Point ${schedule.checkpoint} - ${schedule.person}</div>
                                                                            <div class="item-after">
                                                                                ${schedule.isEdit && schedule.status == 'white' && $h`
                                                                                <a @click="${()=>scheduleEdit(phase, schedule.id, index)}" href="#" class="link popover-open" data-popover="#schedule-edit">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                         width="20" height="20"
                                                                                         fill="currentColor"
                                                                                         class="bi bi-pencil-square"
                                                                                         viewBox="0 0 16 16">
                                                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                                        <path fill-rule="evenodd"
                                                                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                                                    </svg>
                                                                                </a>
                                                                                `}
                                                                                ${schedule.status != 'white' && $h`
                                                                                <span class="badge color-${schedule.status}"></span>
                                                                                `}
                                                                            </div>
                                                                        </div>
                                                                        <div class="item-subtitle">${schedule.start} - ${schedule.end}</div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            `)}
                                                        </ul>
                                                    </div>
                                                    ${isEdited && $h`
                                                    <div class="segmented padding">
                                                        ${!schedule && $h`
                                                        <a class="button button-fill color-red" @click="${()=>removePhase(phase)}" href="#">Remove Phase</a>
                                                        `}
                                                        <a class="button button-outline popover-open" data-popover="#schedule-add" @click="${()=>popoverSchedule(phase)}" href="#">Add Schedule</a>
                                                    </div>
                                                    `}
                                                </div>
                                            </div>
                                        </li>
                                        `)}
                                    </ul>
                                </div>
                                ${isEdited && $h`
                                <div class="padding">
                                    <a class="button button-fill" @click="${addPhase}" href="#">Add Phase</a>
                                </div>
                                `}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popover" id="schedule-add" data-close-by-backdrop-click="false" data-close-by-outside-click="false">
            <div class="popover-inner">
                <div class="block">
                    <form>
                        <div class="list margin-right">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">Person</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="person-id" style="text-transform: capitalize;">
                                                <option value="" selected></option>
                                                ${person && person.map((person) => $h`
                                                <option value="${person.ref}">${person.name}</option>
                                                `)}
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">Checkpoint</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="checkpoint-name">
                                                <option value="" selected></option>
                                                ${checkpoint && checkpoint.map((checkpoint) => $h`
                                                <option value="${checkpoint.name}">Point ${checkpoint.name}</option>
                                                `)}
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">Start Time</div>
                                        <div class="item-input-wrap">
                                            <input type="time" autocomplete="off" name="schedule-start" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">End Time</div>
                                        <div class="item-input-wrap">
                                            <input type="time" autocomplete="off" name="schedule-end" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content padding-top">
                                    <div class="segmented segmented-raised" style="width: 100%;">
                                        <a class="button popover-close" href="#" style="border-radius: 0;">Cancel</a>
                                        <a class="button" @click="${addSchedule}" style="width: 100%;">Add</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="popover" id="schedule-edit" data-close-by-backdrop-click="false" data-close-by-outside-click="false">
            <a class="button popover-close" href="#" style="position: absolute; right: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </a>
            <div class="popover-inner">
                <div class="block">
                    <form>
                        <div class="list margin-right">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">Start Time</div>
                                        <div class="item-input-wrap">
                                            <input type="time" autocomplete="off" name="edit-start" value="${scheduleStart}" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">End Time</div>
                                        <div class="item-input-wrap">
                                            <input type="time" autocomplete="off" name="edit-end" value="${scheduleEnd}" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content padding-top">
                                    <div class="segmented segmented-raised" style="width: 100%;">
                                        <a class="button" @click="${removeSchedule}" href="#" style="border-radius: 0; color: red;">Remove</a>
                                        <a class="button" @click="${editSchedule}" href="#" style="border-radius: 0;">Save</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    "user strict"
    export default (props, { $onBeforeMount, $onMounted, $onBeforeUnmount, $, $f7, $update, $tick }) => {
        var calendar
        var calendarView
        var phase
        var phaseId
        var schedule
        var scheduleId
        var scheduleStart
        var scheduleEnd
        var isEdited = true
        var person
        var checkpoint
        var hash = storage.getItem('hash-patrol') || ''

        const dateDiff = (a, b) => {
            const d1 = new Date(a)
            const d2 = new Date(b)
            var dit = d2.getTime() - d1.getTime()
            var did = dit / (1000 * 3600 * 24)
            return did
        }

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
            getPerson()
            getCheckpoint()
        })

        $onMounted(() => {
            try {
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                calendar = $f7.calendar.create({
                    containerEl: '#calendar',
                    value: [new Date()],
                    weekHeader: true,
                    renderToolbar: () => {
                        return `
                            <div class="toolbar calendar-custom-toolbar no-shadow">
                                <div class="toolbar-inner">
                                    <div class="left">
                                        <a href="#" class="link icon-only"><i class="icon icon-back"></i></a>
                                    </div>
                                    <div class="center"></div>
                                    <div class="right">
                                        <a href="#" class="link icon-only"><i class="icon icon-forward"></i></a>
                                    </div>
                                </div>
                            </div>
                        `
                    },
                    on: {
                        init: (c) => {
                            $('.calendar-custom-toolbar .center').text(`${monthNames[c.currentMonth]}, ${c.currentYear}`)
                            calendarView = `${c.value[0].getDate()} ${monthNames[c.currentMonth]}`
                            $('.calendar-custom-toolbar .left .link').click(() => {
                                calendar.prevMonth()
                            })
                            $('.calendar-custom-toolbar .right .link').click(() => {
                                calendar.nextMonth()
                            })
                        },
                        monthYearChangeStart: (c) => {
                            $('.calendar-custom-toolbar .center').text(`${monthNames[c.currentMonth]}, ${c.currentYear}`)
                        }
                    }
                })

                calendar.on('change', (c, e) => {
                    if ($('.accordion-item-opened').length > 0) $f7.accordion.close('.accordion-item')
                    calendarView = `${e[0].getDate()} ${monthNames[c.currentMonth]}`
                    schedule = null
                    $update()
                    getPhase()
                })

                getPhase()
            } catch (e) {
                toast('Code problem!')
            }
        })

        $onBeforeUnmount(() => {
            calendar = null
            calendarView = null
            phase = null
            phaseId = null
            schedule = null
            scheduleId = null
            scheduleStart = null
            scheduleEnd = null
            isEdited = null
            person = null
            checkpoint = null
            hash = null
        })

        const getPerson = () => {
            try {
                model.getPerson({
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        person = res.person
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

        const getCheckpoint = () => {
            try {
                model.getCheckpoint({
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        checkpoint = res.checkpoint
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

        const getPhase = () => {
            try {
                if ($('.accordion-item').on('accordion:open').length > 0) $('.accordion-item').off('accordion:open')
                model.getPhaseSchedule({
                    date: formatDate(calendar.getValue())
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        if (dateDiff(formatDate(new Date()), formatDate(calendar.getValue())) < 0) {
                            isEdited = false
                        } else {
                            isEdited = true
                        }
                        phase = res.phaseId
                        res = null
                        $update()

                        $tick().then(() => {
                            $('.accordion-item').on('accordion:open', function () {
                                getSchedule($(this).data('phase'))
                            })
                        })
                    }, error: () => {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const addPhase = () => {
            try{
                $f7.dialog.preloader('Adding...')
                model.phase({
                    date: formatDate(calendar.getValue())
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        $f7.dialog.close()
                        res.status == "success" ? toast('Success Added!') : toast('Failed Added!')
                        res = null
                        getPhase()
                    }, error: () => {
                        $f7.dialog.close()
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const removePhase = (e) => {
            $f7.dialog.create({
                text: 'Are you sure you want to remove this phase?',
                buttons: [{
                    text: 'Cancel',
                    close: true
                }, {
                    text: 'Remove',
                    onClick: () => {
                        try{
                            $f7.dialog.preloader('Deleting...')
                            model.removePhase({
                                phase: e,
                                hash: hash
                            }, {
                                success: (data) => {
                                    var res = JSON.parse(data)
                                    $f7.dialog.close()
                                    res.status == "success" ? toast('Success Deleted!') : toast('Failed Deleted!')
                                    res = null
                                    getPhase()
                                }, error: () => {
                                    $f7.dialog.close()
                                    toast('Connection problem!')
                                }
                            })
                        } catch (e) {
                            toast('Code problem!')
                        }
                    }
                }]
            }).open()
        }

        const getSchedule = (e) => {
            try {
                model.getSchedule({
                    phase: e
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        schedule = res.schedule
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

        const editSchedule = () => {
            try {
                $f7.popover.close()
                $f7.dialog.preloader('Editing...')
                model.editSchedule({
                    schedule: scheduleId,
                    start: $('input[name="edit-start"]').val(),
                    end: $('input[name="edit-end"]').val(),
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            res = null
                            toast('Success Edited!')
                            getSchedule(phaseId)
                        } else {
                            res = null
                            toast('Failed Edited!')
                        }
                    }, error: () => {
                        $f7.dialog.close()
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const removeSchedule = () => {
            $f7.dialog.create({
                text: 'Are you sure you want to remove this schedule?',
                buttons: [{
                    text: 'Cancel',
                    close: true
                }, {
                    text: 'Remove',
                    onClick: () => {
                        try {
                            $f7.popover.close()
                            $f7.dialog.preloader('Deleting...')
                            model.removeSchedule({
                                schedule: scheduleId,
                                hash: hash
                            }, {
                                success: (data) => {
                                    var res = JSON.parse(data)
                                    $f7.dialog.close()
                                    if (res.status == "success") {
                                        res = null
                                        toast('Success Deleted!')
                                        getSchedule(phaseId)
                                    } else {
                                        res = null
                                        toast('Failed Deleted!')
                                    }
                                }, error: () => {
                                    $f7.dialog.close()
                                    toast('Connection problem!')
                                }
                            })
                        } catch (e) {
                            toast('Code problem!')
                        }
                    }
                }]
            }).open()
        }

        const scheduleEdit = (a, b, c) => {
            try {
                phaseId = a
                scheduleId = b
                scheduleStart = schedule[c].start
                scheduleEnd = schedule[c].end
                $update()
            } catch (e) {
                toast('Code problem!')
            }
        }

        const popoverSchedule = (e) => {
            try {
                phaseId = e
            } catch (e) {
                toast('Code problem!')
            }
        }

        const addSchedule = () => {
            try {
                $f7.popover.close()
                $f7.dialog.preloader('Adding...')
                model.activity({
                    action: `schedule`,
                    person: $('select[name="person-id"]').val()
                }, {
                    success: (data)=> {
                        var res = JSON.parse(data)
                        switch (res.status) {
                            case 'success':
                                model.schedule({
                                    person: $('select[name="person-id"]').val(),
                                    activity: res.activity,
                                    checkpoint: $('select[name="checkpoint-name"]').val(),
                                    phase: phaseId,
                                    start: $('input[name="schedule-start"]').val(),
                                    end: $('input[name="schedule-end"]').val(),
                                    date: formatDate(calendar.getValue()),
                                    hash: hash
                                }, {
                                    success: (data)=> {
                                        var res = JSON.parse(data)
                                        $f7.dialog.close()
                                        switch (res.status) {
                                            case 'success':
                                                res = null
                                                toast('Success Added!')
                                                getSchedule(phaseId)
                                                break
                                            case 'false':
                                                res = null
                                                toast('Failed, User Unknown!')
                                                break
                                            case 'failed':
                                                res = null
                                                toast('Failed Added!')
                                                break
                                            case 'error':
                                                res = null
                                                toast('Data problem!')
                                                break
                                        }
                                    }, error: ()=> {
                                        $f7.dialog.close()
                                        toast('Connection problem!')
                                    }
                                })
                                break
                            case 'failed':
                                res = null
                                $f7.dialog.close()
                                toast('Failed Added!')
                                break
                            case 'error':
                                res = null
                                $f7.dialog.close()
                                toast('Data problem!')
                                break
                        }
                    }, error: ()=> {
                        $f7.dialog.close()
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        return $render
    }
</script>