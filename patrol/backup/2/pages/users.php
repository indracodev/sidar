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
                <div class="title text-align-center" style="width: 100%;">Users</div>
            </div>
        </div>

        <div class="page-content">
            <div style="max-width: 1280px; margin: 0 auto;">
                <div class="card card-outline data-table data-table-collapsible data-table-init">
                    <div class="card-header" style="border-radius: inherit;">
                        <div class="data-table-header">
                            <div class="data-table-title">User List</div>
                        </div>

                        <div class="data-table-header-selected">
                            <!-- Selected table title -->
                            <div class="data-table-title-selected"><span class="data-table-selected-count"></span> items selected</div>
                            <!-- Selected table actions -->
                            <div class="data-table-actions">
                                <a class="link icon-only popover-open" data-popover="#user-edit">
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
                                <th class="label-cell" colspan="2"><b>No</b></th>
                                <th class="label-cell"><b>User Name</b></th>
                                <th class="numeric-cell"><b>Last Update</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            ${user && user.map((user) => $h`
                            <tr style="background-color: white;">
                                <td class="checkbox-cell">
                                    <label class="checkbox">
                                        <input type="checkbox" class="user-check" @click="${()=>check(user.name, user.id)}" />
                                        <i class="icon-checkbox"></i>
                                    </label>
                                </td>
                                <td class="label-cell" data-collapsible-title="No">${user.no}</td>
                                <td class="label-cell" data-collapsible-title="User Name">${user.name}</td>
                                <td class="numeric-cell" data-collapsible-title="Last Update">${user.update}</td>
                            </tr>
                            `)}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="popover" id="user-edit" data-close-by-backdrop-click="false" data-close-by-outside-click="false">
            <div class="popover-inner">
                <div class="block">
                    <form>
                        <div class="list margin-right">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">User Name</div>
                                        <div class="item-input-wrap">
                                            <input type="text" autocomplete="off" name="edit-name" value="${userName}" required
                                                   validate/>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content padding-top">
                                    <div class="segmented segmented-raised" style="width: 100%;">
                                        <a class="button popover-close" href="#" style="border-radius: 0; color: red;">Cancel</a>
                                        <a class="button" @click="${editUser}" href="#" style="border-radius: 0;">Save</a>
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
    export default (props, { $onBeforeMount, $onBeforeUnmount, $onMounted, $, $f7, $update, $tick }) => {
        var user
        var userName
        var userId
        var hash = storage.getItem('hash-patrol') || ''

        $onBeforeMount(() => {
            getUser()
        })

        $onMounted(() => {
            $('#user-edit').on('popover:close', () => {
                $('.data-table').removeClass('data-table-has-checked')
                $('.user-check').prop('checked', false)
            })
        })

        $onBeforeUnmount(() => {
            user = null
            userName = null
            userId = null
            hash = null
        })

        const getUser = () => {
            try {
                model.getUser({
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        user = res.users
                        res = null
                        $update()

                        $tick().then(() => {
                            $('.user-check').click( function () {
                                if ($(this).prop('checked') && $('.data-table-has-checked').length < 1) {
                                } else {
                                    if (!$(this).prop('checked') && $('.data-table-has-checked').length > 0) {
                                        $(this).prop('checked', false)
                                    } else {
                                        $('.user-check').prop('checked', false)
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

        const check = (a, b) => {
            userName = a
            userId = b
            $update()
        }

        const editUser = () => {
            try {
                $f7.popover.close()
                $f7.dialog.preloader('Editing...')
                model.editUser({
                    user: $('input[name="edit-name"]').val(),
                    id: userId,
                    hash: hash
                }, {
                    success: (data) => {
                        var res = JSON.parse(data)
                        $f7.dialog.close()
                        if (res.status == "success") {
                            res = null
                            toast('Success edited!')
                            getUser()
                        } else {
                            res = null
                            toast('Failed edited!')
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

        const rmUser = () => {
            $f7.popover.close()
            $f7.dialog.create({
                text: 'Are you sure you want to remove this person?',
                buttons: [{
                    text: 'Cancel',
                    close: true
                }, {
                    text: 'Remove',
                    onClick: () => {
                    }
                }]
            }).open()
        }

        return $render
    }
</script>