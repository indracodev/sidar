"user strict"
const model = {
    URL: 'https://sidar.id/patrol/api/v1/',
    //URL: 'http://192.168.1.95/patrol/api/v1/',
    auth: function (query, handlers) {
        fetch(`${this.URL}auth/?hash=${query.hash}&device=web`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    login: function (query, handlers) {
        let rand = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
        let urlencoded = new URLSearchParams()
        urlencoded.append(`username`, query.username)
        urlencoded.append(`password`, query.password)
        urlencoded.append(`device`, query.device)

        fetch(`${this.URL}auth/?action=${rand}`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    phase: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("date", query.date)

        fetch(`${this.URL}phase/`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    removePhase: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("phase", query.phase)

        fetch(`${this.URL}phase/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    getPhase: function (query, handlers) {
        fetch(`${this.URL}phase/?date=${query.date}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    schedule: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("person", query.person)
        urlencoded.append("checkpoint", query.checkpoint)
        urlencoded.append("phase", query.phase)
        urlencoded.append("start", query.start)
        urlencoded.append("end", query.end)
        urlencoded.append("date", query.date)
        urlencoded.append("user", query.user)

        fetch(`${this.URL}schedule/`, {
            method: 'POST',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    getSchedule: function (query, handlers) {
        fetch(`${this.URL}schedule/?phase=${query.phase}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    removeSchedule: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("schedule", query.schedule)

        fetch(`${this.URL}schedule/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    editSchedule: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("schedule", query.schedule)
        urlencoded.append("start", query.start)
        urlencoded.append("end", query.end)

        fetch(`${this.URL}schedule/`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    getPerson: function (query, handlers) {
        fetch(`${this.URL}person/?hash=${query.hash}&device=web`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    editPerson: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("person", query.person)
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}person/`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    rmPerson: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}person/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    getCheckpoint: function (query, handlers) {
        fetch(`${this.URL}checkpoint/?hash=${query.hash}&device=web`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    editCheckpoint: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("checkpoint", query.checkpoint)
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}checkpoint/`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    rmCheckpoint: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}checkpoint/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    toggleCheckpoint: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}checkpoint/`, {
            method: 'PATCH',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    getUser: function (query, handlers) {
        fetch(`${this.URL}users/?hash=${query.hash}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    editUser: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("user", query.user)
        urlencoded.append("id", query.id)

        fetch(`${this.URL}users/`, {
            method: 'PUT',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    rmUser: function (query, handlers) {
        let urlencoded = new URLSearchParams()
        urlencoded.append("ref", query.ref)

        fetch(`${this.URL}person/`, {
            method: 'DELETE',
            body: urlencoded,
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },

    getReport: function (query, handlers) {
        fetch(`${this.URL}report/?hash=${query.hash}`, {
            method: 'GET',
            redirect: 'follow'
        })
            .then(response => response.text())
            .then(result => handlers.success(result))
            .catch(error => handlers.error(error))
    },
}