<template>
    <div class="container">
        <div class="selector">
            <p>Number of events:</p>
            <select v-model="eventsOnPage">
                <option v-for="num in selectCol">{{num}}</option>
            </select>
            <p>Types of events:</p>
            <select v-model="eventType">
              <option v-for="one in typesList">{{one}}</option>
            </select>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Event type</th>
                    <th scope="col">Event name</th>
                    <th scope="col">Date&Time</th>
                    <th scope="col">Event on the map</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="event in paginatedEvents">
                    <td>{{ event.id }}</td>
                    <td>{{ event.type }}</td>
                    <td>{{ event.title }}</td>
                    <td>{{ event.date_time }}</td>
                    <td><a :href="`https://maps.google.com/maps?q=${ event.latitude },${ event.longitude }&ll=${ event.latitude },${ event.longitude }&z=17`">Event on the map</a></td>
                </tr>
            </tbody>
        </table>
        <div class="tbl-pagination">
            <div class="page"
                 v-for="page in pages"
                 v-if="Math.abs(page - pageNum) < 3 || page === pages || page === 1"
                 :key="page"
                 @click="pageClick(page)"
                 :class="{'page-selected': page === pageNum, current: pageNum === page, last: (page === pages && Math.abs(page - pageNum) > 3), first: (page === 1 && Math.abs(page - pageNum) > 3)}">
                {{ page }}
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {toInteger} from "lodash/lang";

export default {
    name: "Events",
    data: () => ({
        allEvents: [],
        eventsList: [],
        typesList: [],
        eventType: "All",
        selectCol: [5, 10, 20],
        eventsOnPage: 10,
        pageNum: 1
    }),
    mounted() {
        this.loadEvents()
        this.loadTypesOfEvents()
    },
    computed: {
        paginatedEvents() {
            this.sortByType()
            let from = (this.pageNum - 1) * this.eventsOnPage
            let to = toInteger(this.eventsOnPage) + from
            if (from > this.eventsList.length) {
                this.pageNum = 1
                from = 0
                to = toInteger(this.eventsOnPage) + from
            }
            return this.eventsList.slice(from, to)
        },
        pages() {
            return Math.ceil(this.eventsList.length / this.eventsOnPage)
        },
    },
    methods: {
        loadEvents() {
            axios.get('/api/events')
            .then(res => {
                this.allEvents = res.data
                this.eventsList = res.data
            })
        },
        loadTypesOfEvents() {
            axios.get('/api/types')
                .then(res => {
                    this.typesList = res.data
                })
        },
        pageClick(page) {
            this.pageNum = page
        },
        sortByType() {
            let eventsList = []
            let eventType = this.eventType
            this.allEvents.map(function (item) {
                if (item.type === eventType) {
                    eventsList.push(item)
                } else if (eventType === 'All') {
                    eventsList.push(item)
                }
            })
            this.eventsList = eventsList
        },
    }
}
</script>

<style scoped>
.table {
    margin-top: 10px;
}

.tbl-pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 30px;
}

.page {
    padding: 5px;
    margin-right: 5px;
    border-radius: 10%;
}

.page:hover {
    background: lightgray;
    cursor: pointer;
}

.page-selected {
    background: lightgray;
    cursor: pointer;
}

select {
    padding: 5px 30px;
}

.selector {
    margin-top: 50px;
    display: flex;
    align-items: center;
}

p {
    margin: 0 10px 0 30px;
}
.page.first::after {
    content:'...'
}

.page.last::before {
    content:'...'
}
</style>
