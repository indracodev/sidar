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
                                        <a class="link icon-only popup-open" data-popup="#map-location">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            </svg>
                                        </a>
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
                                                <input type="checkbox" class="checkpoint-check" @click="${()=>check(checkpoint.name, checkpoint.ref, checkpoint.location)}" />
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

        <div class="popover" id="checkpoint-edit" data-close-by-backdrop-click="false" data-close-by-outside-click="false">
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
                                        <div class="item-title item-label">Checkpoint Name</div>
                                        <div class="item-input-wrap">
                                            <input type="text" autocomplete="off" name="edit-name" value="${checkpointName}" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content padding-top">
                                    <div class="segmented segmented-raised" style="width: 100%;">
                                        <a class="button" @click="${rmCheckpoint}" href="#" style="border-radius: 0; color: red;">Remove</a>
                                        <a class="button" @click="${editCheckpoint}" href="#" style="border-radius: 0;">Save</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="popup" id="map-location" data-close-by-backdrop-click="true">
            <a class="button popup-close" href="#" style="position: absolute; right: 0; z-index: 2;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                </svg>
            </a>
            <div id="map" style="position: absolute; top: 0; bottom: 0; width: 100%; height: 100%;"></div>
            <a class="button button-fill button-large" @click="${setLocation}" href="#" style="position: fixed; bottom: 0; width: 100%; z-index: 2; border-radius: 0;">Save</a>
        </div>

    </div>
</template>
<script>
    "user strict"
    export default (props, { $onBeforeMount, $onMounted, $onBeforeUnmount, $, $f7, $update, $tick }) => {
        var checkpoint
        var checkpointName
        var checkpointId
        var location = []
        var locationView
        var hash = storage.getItem('hash-patrol') || ''
        var mapbox
        var mapboxMarker
        var latitude
        var longitude

        $onBeforeMount(() => {
            getCheckpoint()
        })

        $onMounted(() => {
            $('#checkpoint-edit').on('popover:close', () => {
                $('.data-table').removeClass('data-table-has-checked')
                $('.checkpoint-check').prop('checked', false)
            })

            $('#map-location').on('popup:open', () => {
                mapboxgl.accessToken = 'pk.eyJ1IjoiZG9rb3RlbGVrIiwiYSI6ImNrNTUydHU0eTBwdDYzZXBubnU1cGg0bnMifQ.3mx4XwIRpMPjdcEssgS4lg'
                mapbox = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [112.675324, -7.293357],
                    zoom: 18
                })

                mapboxMarker = new mapboxgl.Marker({
                    draggable: true
                })

                mapboxMarker.on('dragend', function () {
                    var lngLat = mapboxMarker.getLngLat()
                    latitude = lngLat.lat
                    longitude = lngLat.lng
                    lngLat = null
                })

                mapbox.on('load', function () {
                    mapboxMarker.setLngLat([longitude || 112.675324,latitude || -7.293357]).addTo(mapbox)
                })
            })
        })

        $onBeforeUnmount(() => {
            checkpoint = null
            checkpointName = null
            checkpointId = null
            location = null
            locationView = null
            hash = null
            mapbox = null
            mapboxMarker = null
        })

        const getCheckpoint = () => {
            try {
                location = []
                model.getCheckpoint({
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        checkpoint = res.checkpoint
                        var len = checkpoint.length
                        var i = 0
                        while (i < len) {
                            if (checkpoint[i].location != ',')
                                checkpoint[i].status ? location.push(`pin-s-circle+285A98(${checkpoint[i].location})`) : location.push(`pin-s-circle+ff0000(${checkpoint[i].location})`)
                            i++
                        }
                        locationView = location.join(',')
                        res = null
                        len = null
                        i = null
                        $update()

                        $tick().then(() => {
                            $('.checkpoint-check').click( function () {
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
                    }, error: () => {
                        toast('Connection problem!')
                    }
                })
            } catch (e) {
                toast('Code problem!')
            }
        }

        const check = (a, b, c) => {
            checkpointName = a
            checkpointId = b
            var locationTemp = c.split(',')
            latitude = locationTemp[1]
            longitude = locationTemp[0]
            locationTemp = null
            $update()
        }

        const editCheckpoint = () => {
            try {
                $f7.popover.close()
                $f7.dialog.preloader('Editing...')
                model.editCheckpoint({
                    checkpoint: $('input[name="edit-name"]').val(),
                    id: checkpointId,
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            res = null
                            toast('Success Edited!')
                            getCheckpoint()
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

        const rmCheckpoint = () => {
            $f7.popover.close()
            $f7.dialog.create({
                text: 'Are you sure you want to remove this checkpoint?',
                buttons: [{
                    text: 'Cancel',
                    close: true
                }, {
                    text: 'Remove',
                    onClick: () => {
                        try {
                            $f7.popover.close()
                            $f7.dialog.preloader('Deleting...')
                            model.rmCheckpoint({
                                id: checkpointId,
                                hash: hash
                            }, {
                                success: (data) => {
                                    let res = JSON.parse(data)
                                    $f7.dialog.close()
                                    if (res.status == "success") {
                                        res = null
                                        toast('Success deleted!')
                                        getCheckpoint()
                                    } else {
                                        res = null
                                        toast('Failed deleted!')
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

        const setLocation = () => {
            try {
                $f7.popup.close()
                $f7.dialog.preloader('Setting...')
                model.setCheckpoint({
                    id: checkpointId,
                    latitude: latitude,
                    longitude: longitude,
                    hash: hash
                }, {
                    success: (data) => {
                        let res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            res = null
                            getCheckpoint()
                            toast('Success set location!')
                        } else {
                            res = null
                            toast('Failed set location !')
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

        const toggle = () => {
            try {
                model.toggleCheckpoint({
                    id: checkpointId,
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            res = null
                            toast('Success Edited!')
                            getCheckpoint()
                        } else {
                            res = null
                            toast('Failed Edited!')
                        }
                    }, error: () => {
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