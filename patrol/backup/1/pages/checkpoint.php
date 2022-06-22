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
                <div class="title text-align-center" style="width: 100%;">Checkpoint</div>
            </div>
        </div>

        <div class="page-content">
            <div style="max-width: 1280px; margin: 0 auto;">
                <div class="card card-outline data-table data-table-collapsible data-table-init">
                    <div class="row no-gap">
                        <div class="col-100 medium-50" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
                            <div class="card-header" style="border-radius: inherit;">
                                <div class="data-table-header">
                                    <div class="data-table-title">Checkpoint List</div>
                                </div>

                                <div class="data-table-header-selected">
                                    <!-- Selected table title -->
                                    <div class="data-table-title-selected"><span class="data-table-selected-count"></span> items selected</div>
                                    <!-- Selected table actions -->
                                    <div class="data-table-actions">
                                        <a class="link icon-only" @click="${toggle}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-toggles" viewBox="0 0 16 16">
                                                <path d="M4.5 9a3.5 3.5 0 1 0 0 7h7a3.5 3.5 0 1 0 0-7h-7zm7 6a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm-7-14a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm2.45 0A3.49 3.49 0 0 1 8 3.5 3.49 3.49 0 0 1 6.95 6h4.55a2.5 2.5 0 0 0 0-5H6.95zM4.5 0h7a3.5 3.5 0 1 1 0 7h-7a3.5 3.5 0 1 1 0-7z"/>
                                            </svg>
                                        </a>
                                        <a class="link icon-only popover-open" data-popover="#checkpoint-edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                                                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="label-cell" colspan="2"><b>Checkpoint Name</b></th>
                                        <th class="label-cell"><b>Checkpoint Ref</b></th>
                                        <th class="numeric-cell"><b>Last Update</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    ${checkpoint && checkpoint.map((checkpoint) => $h`
                                    <tr style="background-color: white; color: ${checkpoint.color}">
                                        <td class="checkbox-cell">
                                            <label class="checkbox">
                                                <input type="checkbox" class="checkpoint-check" @click="${()=>check(checkpoint.name, checkpoint.ref)}" />
                                                <i class="icon-checkbox"></i>
                                            </label>
                                        </td>
                                        <td class="label-cell" data-collapsible-title="Checkpoint Name">${checkpoint.name}</td>
                                        <td class="label-cell" data-collapsible-title="Checkpoint Ref">${checkpoint.ref}</td>
                                        <td class="numeric-cell" data-collapsible-title="Last Update">${checkpoint.update}</td>
                                    </tr>
                                    `)}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-100 medium-50">
                            <div class="margin">
                                ${locationView && $h`
                                <img @click="${()=> map(`https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/${locationView}/auto/640x640@2x?access_token=pk.eyJ1IjoiZG9rb3RlbGVrIiwiYSI6ImNrNTUydHU0eTBwdDYzZXBubnU1cGg0bnMifQ.3mx4XwIRpMPjdcEssgS4lg&attribution=false&logo=false`)}" src="https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/${locationView}/auto/600x300@2x?access_token=pk.eyJ1IjoiZG9rb3RlbGVrIiwiYSI6ImNrNTUydHU0eTBwdDYzZXBubnU1cGg0bnMifQ.3mx4XwIRpMPjdcEssgS4lg&attribution=false&logo=false" style="width: 100%; cursor: pointer;" />
                                `}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popover" id="checkpoint-edit">
            <div class="popover-inner">
                <div class="block">
                    <form>
                        <div class="list margin-right">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">Checkpoint Name</div>
                                        <div class="item-input-wrap">
                                            <input type="text" autocomplete="off" name="edit-name" value="${checkpointName}" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content padding-top">
                                    <div class="segmented segmented-raised" style="width: 100%;">
                                        <a class="button" @click="${rmCheckpoint}" href="#" style="border-radius: 0;">Remove</a>
                                        <a class="button" @click="${editCheckpoint}" href="#" style="border-radius: 0;">Save</a>
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
        let checkpoint
        let checkpointName
        let checkpointId
        let location = []
        let locationView
        $on('page:mounted', () => {
            getCheckpoint()
        })

        const getCheckpoint = () => {
            try {
                location = []
                model.getCheckpoint({
                    hash: storage.getItem('hash') || ''
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        checkpoint = res.checkpoint
                        let len = checkpoint.length
                        let i = 0
                        while (i < len) {
                            if (checkpoint[i].location != ',')
                                checkpoint[i].status ? location.push(`pin-s-circle+285A98(${checkpoint[i].location})`) : location.push(`pin-s-circle+ff0000(${checkpoint[i].location})`)
                            i++
                        }
                        locationView = location.join(',')
                        $update()

                        $tick().then(() => {
                            $('.checkpoint-check').click(function () {
                                if ($(this).prop('checked') && $('.data-table-has-checked').length < 1) {
                                } else {
                                    if (!$(this).prop('checked') && $('.data-table-has-checked').length > 0) {
                                        $(this).prop('checked', false)
                                    } else {
                                        $('.checkpoint-check').prop('checked', false)
                                        $(this).prop('checked', true)
                                    }
                                }
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

        const check = (a, b) => {
            checkpointName = a
            checkpointId = b
            $update()
        }

        const editCheckpoint = () => {
            try {
                $f7.popover.close()
                $f7.dialog.preloader('Editing...')
                model.editCheckpoint({
                    checkpoint: $('input[name="edit-name"]').val(),
                    ref: checkpointId
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            toast('Success Edited!')
                            getCheckpoint()
                        } else {
                            $f7.dialog.close()
                            toast('Failed Edited!')
                        }
                    }, error: function () {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const rmCheckpoint = () => {
            $f7.popover.close()
            $f7.dialog.create({
                text: 'Are you sure you want to remove this checkpoint?',
                buttons: [{
                    text: 'Cancel',
                    close: true
                }, {
                    text: 'Remove',
                    onClick: function () {
                        try {
                            $f7.dialog.preloader('Deleting...')
                            model.rmCheckpoint({
                                ref: checkpointId
                            }, {
                                success: function (data) {
                                    let res = JSON.parse(data)
                                    $f7.dialog.close()
                                    if (res.status == "success") {
                                        toast('Success deleted!')
                                        getCheckpoint()
                                    } else {
                                        $f7.dialog.close()
                                        toast('Failed deleted!')
                                    }
                                }, error: function () {
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

        const toggle = () => {
            try {
                model.toggleCheckpoint({
                    ref: checkpointId
                }, {
                    success: function (data) {
                        let res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            toast('Success Edited!')
                            getCheckpoint()
                        } else {
                            $f7.dialog.close()
                            toast('Failed Edited!')
                        }
                    }, error: function () {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const map = (e) => {
            window.open(e)
        }

        return $render
    }
</script>