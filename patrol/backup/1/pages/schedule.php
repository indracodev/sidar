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
                <div class="card card-outline">
                    <div class="card-content">
                        <div class="row no-gap">
                            <div class="col-100 medium-50">
                                <div id="calendar"
                                     style="border: 1px solid #e0e0e0; border-radius: var(--f7-card-border-radius);"></div>
                            </div>
                            <div class="col-100 medium-50">
                                <div class="list accordion-list" style="border: 1px solid #e0e0e0;">
                                    <ul>
                                        ${phase && phase.map((phase, index) => $h`
                                        <li class="accordion-item" data-phase="${phase}">
                                            <a class="item-content item-link padding-right" href="#">
                                                <div class="item-inner">
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
                                                            <li style="background: ${schedule.status};">
                                                                <div class="item-content">
                                                                    <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                            <div class="item-title" style="text-transform: capitalize; font-weight: 400;">Point ${schedule.checkpoint} - ${schedule.person}</div>
                                                                            <div class="item-after">
                                                                                ${schedule.isEdit && $h`
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
                                <div class="padding">
                                    ${isEdited && $h`
                                    <a class="button button-fill" @click="${addPhase}" href="#">Add Phase</a>
                                    `}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popover" id="schedule-add">
            <div class="popover-inner">
                <div class="block">
                    <form>
                        <div class="list margin-right">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">Person</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="person-id">
                                                <option value="" selected></option>
                                                <?php
                                                include 'header.php';
                                                $sql = $conn->prepare("SELECT personId, personName FROM tb_person");
                                                $sql->execute();
                                                $sqlResult = $sql->get_result();
                                                if ($sqlResult->num_rows > 0) {
                                                    while ($row = $sqlResult->fetch_assoc()) {
                                                        echo('<option value="'.$row['personId'].'">'.ucfirst($row['personName']).'</option>');
                                                    }
                                                    $conn->close();
                                                }
                                                $conn->close();
                                                ?>
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
                                                <?php
                                                include 'header.php';
                                                $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint");
                                                $sql->execute();
                                                $sqlResult = $sql->get_result();
                                                if ($sqlResult->num_rows > 0) {
                                                    while ($row = $sqlResult->fetch_assoc()) {
                                                        echo('<option value="'.$row['checkpointName'].'">Point '.$row['checkpointName'].'</option>');
                                                    }
                                                }
                                                ?>
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
                                    <a class="button button-raised" @click="${addSchedule}" style="width: 100%;">Add</a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="popover" id="schedule-edit">
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
                                        <a class="button" @click="${removeSchedule}" href="#" style="border-radius: 0;">Remove</a>
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
    export default (props, {$on, $, $f7, $update, $tick}) => {
        let calendar
        let calendarView
        let phase
        let phaseId
        let schedule
        let scheduleId
        let scheduleStart
        let scheduleEnd
        let isEdited = true

        const dateDiff = (a, b) => {
            const d1 = new Date(a)
            const d2 = new Date(b)
            let dit = d2.getTime() - d1.getTime()
            let did = dit / (1000 * 3600 * 24)
            return did
        }

        $on('pageInit', () => {
            try {
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                calendar = $f7.calendar.create({
                    containerEl: '#calendar',
                    value: [new Date()],
                    weekHeader: true,
                    renderToolbar: function () {
                        return `
                            <div class="toolbar calendar-custom-toolbar no-shadow">
                                <div class="toolbar-inner">
                                    <div class="left">
                                        <a href="#" class="link icon-only"><i class="icon icon-back ${$f7.theme === 'md' ? 'color-black' : ''}"></i></a>
                                    </div>
                                    <div class="center"></div>
                                    <div class="right">
                                        <a href="#" class="link icon-only"><i class="icon icon-forward ${$f7.theme === 'md' ? 'color-black' : ''}"></i></a>
                                    </div>
                                </div>
                            </div>
                        `
                    },
                    on: {
                        init: function (c) {
                            $('.calendar-custom-toolbar .center').text(`${monthNames[c.currentMonth]}, ${c.currentYear}`)
                            calendarView = `${c.value[0].getDate()} ${monthNames[c.currentMonth]}`
                            $('.calendar-custom-toolbar .left .link').click(function () {
                                calendar.prevMonth()
                            })
                            $('.calendar-custom-toolbar .right .link').click(function () {
                                calendar.nextMonth()
                            })
                        },
                        monthYearChangeStart: function (c) {
                            $('.calendar-custom-toolbar .center').text(`${monthNames[c.currentMonth]}, ${c.currentYear}`)
                        }
                    }
                })

                calendar.on('change', function (c, e) {
                    if ($('.accordion-item-opened').length > 0) $f7.accordion.close('.accordion-item')
                    calendarView = `${e[0].getDate()} ${monthNames[c.currentMonth]}`
                    getPhase()
                })

                getPhase()
            } catch (e) {
                toast('Code problem!')
            }
        })

        const getPhase = () => {
            try {
                if ($('.accordion-item').on('accordion:open').length > 0) $('.accordion-item').off('accordion:open')
                model.getPhase({
                    date: formatDate(calendar.getValue())
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        console.log()
                        if (dateDiff(formatDate(new Date()), formatDate(calendar.getValue())) < 0) {
                            isEdited = false
                        } else {
                            isEdited = true
                        }
                        phase = res.phaseId
                        $update()

                        $tick().then(() => {
                            $('.accordion-item').on('accordion:open', function () {
                                getSchedule($(this).data('phase'))
                            })
                        })
                    }, error: function () {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const formatDate = (date) => {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear()

            if (month.length < 2)
                month = '0' + month
            if (day.length < 2)
                day = '0' + day

            return [year, month, day].join('-')
        }

        const addPhase = () => {
            try{
                $f7.dialog.preloader('Adding...')
                model.phase({
                    date: formatDate(calendar.getValue())
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        $f7.dialog.close()
                        res.status == "success" ? toast('Success Added!') : toast('Failed Added!')
                        getPhase()
                    }, error: function () {
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
                    onClick: function () {
                        try{
                            $f7.dialog.preloader('Deleting...')
                            model.removePhase({
                                phase: e
                            }, {
                                success: function (data) {
                                    let res = JSON.parse(data)
                                    $f7.dialog.close()
                                    res.status == "success" ? toast('Success Deleted!') : toast('Failed Deleted!')
                                    getPhase()
                                }, error: function () {
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
                    success: function (data) {
                        let res = JSON.parse(data)
                        schedule = res.schedule
                        $update()
                    }, error: function () {
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
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            toast('Success Edited!')
                            getSchedule(phaseId)
                        } else {
                            toast('Failed Edited!')
                        }
                    }, error: function () {
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
                    onClick: function () {
                        try {
                            $f7.dialog.preloader('Deleting...')
                            model.removeSchedule({
                                schedule: scheduleId
                            }, {
                                success: function (data) {
                                    let res = JSON.parse(data)
                                    $f7.dialog.close()
                                    if (res.status == "success") {
                                        toast('Success Deleted!')
                                        getSchedule(phaseId)
                                    } else {
                                        toast('Failed Deleted!')
                                    }
                                }, error: function () {
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
                model.schedule({
                    person: $('select[name="person-id"]').val(),
                    checkpoint: $('select[name="checkpoint-name"]').val(),
                    phase: phaseId,
                    start: $('input[name="schedule-start"]').val(),
                    end: $('input[name="schedule-end"]').val(),
                    date: formatDate(calendar.getValue()),
                    user: storage.getItem('hash') || ''
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        $f7.dialog.close()
                        switch (res.status) {
                            case 'success':
                                toast('Success Added!')
                                getSchedule(phaseId)
                                break
                            case 'false':
                                toast('Failed, User Unknown!')
                                break
                            case 'failed':
                                toast('Failed Added!')
                                break
                            case 'error':
                                toast('Data problem!')
                                break
                        }
                    }, error: function () {
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