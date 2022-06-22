"user strict"
class Model {
    constructor() {
        this.URL = 'https://sidar.id/guard/api/v1/'
        //this.URL = 'https://sidar.id/patrol/api/v1/'
        //this.URL = 'http://192.168.1.95/patrol/api/v1/'
    }

    authentication(query, handlers) {
        fetch(`${this.URL}auth/?hash=${query.hash}&device=web`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    login(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append(`username`, query.username)
        urlencoded.append(`password`, query.password)
        urlencoded.append(`device`, query.device)

        fetch(`${this.URL}auth/?action=${query.token}`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    addPhase(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("date", query.date)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}phase/?action=add`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    copyAllPhase(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("date", query.date)
        urlencoded.append("date-select", query.dateSelect)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}phase/?action=duplicate`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    removePhase(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("phase", query.phase)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}phase/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getPhaseSchedule(query, handlers) {
        fetch(`${this.URL}phase/?date=${query.date}&action=schedule`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getPhaseDashboard(query, handlers) {
        fetch(`${this.URL}phase/?date=${query.date}&action=dashboard`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    addSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("mapping", query.mapping)
        urlencoded.append("person", query.person)
        urlencoded.append("activity", query.activity)
        urlencoded.append("checkpoint", query.checkpoint)
        urlencoded.append("phase", query.phase)
        urlencoded.append("start", query.start)
        urlencoded.append("end", query.end)
        urlencoded.append("date", query.date)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=schedule`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    scheduleTemplate(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("template", query.template)
        urlencoded.append("phase", query.phase)
        urlencoded.append("date", query.date)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=schedule-template`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    templateSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("name", query.name)
        urlencoded.append("mapping", query.mapping)
        urlencoded.append("person", query.person)
        urlencoded.append("checkpoint", query.checkpoint)
        urlencoded.append("start", query.start)
        urlencoded.append("end", query.end)
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=template`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    copyTemplateSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("template", query.template)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=copy-template`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getTemplateSchedule(query, handlers) {
        fetch(`${this.URL}schedule/?hash=${query.hash}&action=template`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getSchedule(query, handlers) {
        fetch(`${this.URL}schedule/?phase=${query.phase}&action=schedule`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getTemplateScheduleDetail(query, handlers) {
        fetch(`${this.URL}schedule/?action=schedule-template&template=${query.template}&hash=${query.hash}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    removeSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("schedule", query.schedule)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=schedule`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    removeAllSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("phase", query.phase)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=all`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    removeAllPhase(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("phase", query.phase)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=all-phase`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    removeTemplateSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("template", query.template)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=template`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("schedule", query.schedule)
        urlencoded.append("start", query.start)
        urlencoded.append("end", query.end)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=schedule`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editTemplateSchedule(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("name", query.name)
        urlencoded.append("mapping", query.mapping)
        urlencoded.append("person", query.person)
        urlencoded.append("checkpoint", query.checkpoint)
        urlencoded.append("start", query.start)
        urlencoded.append("end", query.end)
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}schedule/?action=template`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getPerson(query, handlers) {
        fetch(`${this.URL}person/?hash=${query.hash}&device=web&action=person`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getMapping(query, handlers) {
        fetch(`${this.URL}person/?hash=${query.hash}&device=web&action=mapping`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    addPerson(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("name", query.name)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}person/?device=web`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editPerson(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("person", query.person)
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}person/?action=person`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    rmPerson(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}person/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editMapping(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("mapping", query.mapping)
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}person/?action=mapping`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getCheckpoint(query, handlers) {
        fetch(`${this.URL}checkpoint/?hash=${query.hash}&device=web`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editCheckpoint(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("checkpoint", query.checkpoint)
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}checkpoint/?action=edit`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    rmCheckpoint(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}checkpoint/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    toggleCheckpoint(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}checkpoint/?action=toggle`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    setCheckpoint(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("latitude", query.latitude)
        urlencoded.append("longitude", query.longitude)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}checkpoint/?action=set`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getUser(query, handlers) {
        fetch(`${this.URL}users/?hash=${query.hash}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    addUser(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("user", query.user)
        urlencoded.append("password", query.password)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}users/`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editUser(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("user", query.user)
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}users/?action=update`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    enableUser(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}users/?action=enable`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    disableUser(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}users/?action=disable`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    logoutUser(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}users/?action=logout`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    rmUser(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}users/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getReportDate(query, handlers) {
        fetch(`${this.URL}report/?hash=${query.hash}&action=date&name=${query.name}&date=${query.date}&month=${query.month}&start=${query.start}&end=${query.end}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getReportTask(query, handlers) {
        fetch(`${this.URL}task/?hash=${query.hash}&action=report&phase=${query.phase}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getActivity(query, handlers) {
        fetch(`${this.URL}activity/?hash=${query.hash}&phase=${query.phase}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    addTask(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=task`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editTask(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=task`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    editTemplate(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("template", query.template)
        urlencoded.append("_template", query._template)
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=template`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    rmTask(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=task`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getTask(query, handlers) {
        fetch(`${this.URL}task/?hash=${query.hash}&action=task`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    setTask(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("id", query.id)
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=set`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    addTemplate(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("template", query.template)
        urlencoded.append("task", query.task)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=template`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getTemplate(query, handlers) {
        fetch(`${this.URL}task/?hash=${query.hash}&action=template`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    rmTemplate(query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("template", query.template)
        urlencoded.append("hash", query.hash)

        fetch(`${this.URL}task/?action=template`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }

    getLogs(query, handlers) {
        fetch(`${this.URL}logs/?hash=${query.hash}&action=${query.filter}&date=${query.date}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    }
}